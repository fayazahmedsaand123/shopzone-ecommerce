<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%");
            });
        }

        if ($request->category_id) $query->where('category_id', $request->category_id);
        if ($request->status) $query->where('status', $request->status);

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('status','active')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status','active')->get();
        $brands     = Brand::where('status','active')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0|lt:price',
            'stock_quantity'    => 'required|integer|min:0',
            'status'            => 'required|in:active,inactive,out_of_stock',
            'is_featured'       => 'boolean',
            'main_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'weight'            => 'nullable|numeric|min:0',
            'dimensions'        => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'name','description','short_description','category_id',
                'brand_id','price','sale_price','stock_quantity',
                'status','weight','dimensions'
            ]);

            $data['slug']        = Str::slug($request->name);
            $data['is_featured'] = $request->boolean('is_featured');
            $data['sku']         = 'SKU-' . strtoupper(Str::random(8));

            // Unique slug
            $count = Product::where('slug', $data['slug'])->count();
            if ($count > 0) $data['slug'] .= '-' . ($count + 1);

            // Main image
            if ($request->hasFile('main_image')) {
                $data['main_image'] = $request->file('main_image')->store('products', 'public');
            }

            $product = Product::create($data);

            // Gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $i => $img) {
                    $path = $img->store('products/gallery', 'public');
                    ProductImage::create(['product_id' => $product->id, 'image' => $path, 'sort_order' => $i]);
                }
            }

            // Inventory record
            if ($product->stock_quantity > 0) {
                InventoryMovement::create([
                    'product_id'  => $product->id,
                    'type'        => 'in',
                    'quantity'    => $product->stock_quantity,
                    'stock_before'=> 0,
                    'stock_after' => $product->stock_quantity,
                    'reason'      => 'Initial stock',
                    'user_id'     => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status','active')->get();
        $brands     = Brand::where('status','active')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id'       => 'required|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0',
            'stock_quantity'    => 'required|integer|min:0',
            'status'            => 'required|in:active,inactive,out_of_stock',
            'main_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'name','description','short_description','category_id',
                'brand_id','price','sale_price','stock_quantity',
                'status','weight','dimensions'
            ]);
            $data['is_featured'] = $request->boolean('is_featured');

            // Track stock change
            $oldStock = $product->stock_quantity;
            $newStock = (int) $request->stock_quantity;

            if ($request->hasFile('main_image')) {
                if ($product->main_image) Storage::disk('public')->delete($product->main_image);
                $data['main_image'] = $request->file('main_image')->store('products', 'public');
            }

            $product->update($data);

            // Gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $i => $img) {
                    $path = $img->store('products/gallery', 'public');
                    ProductImage::create(['product_id' => $product->id, 'image' => $path, 'sort_order' => $i]);
                }
            }

            // Record inventory change
            if ($newStock !== $oldStock) {
                InventoryMovement::create([
                    'product_id'   => $product->id,
                    'type'         => 'adjustment',
                    'quantity'     => abs($newStock - $oldStock),
                    'stock_before' => $oldStock,
                    'stock_after'  => $newStock,
                    'reason'       => 'Manual adjustment',
                    'user_id'      => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        if ($product->main_image) Storage::disk('public')->delete($product->main_image);
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }
}