<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller {

    // All Products Page
    public function index(Request $request) {
        $query = Product::with(['category', 'brand'])
            ->where('status', 'active');

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('sku', 'like', "%$search%");
            });
        }

        // Category filter
        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Brand filter
        if ($request->brand) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }

        // Price filter
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Availability
        if ($request->in_stock) {
            $query->where('stock_quantity', '>', 0);
        }

        // Sorting
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest'     => $query->oldest(),
            'popular'    => $query->orderBy('views_count', 'desc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('status', 'active')->withCount('products')->get();
        $brands     = Brand::where('status', 'active')->get();

        return view('store.products', compact('products', 'categories', 'brands'));
    }

    // AJAX Live Search
    public function search(Request $request) {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('sku', 'like', "%$query%");
            })
            ->take(6)
            ->get()
            ->map(function ($product) {
                return [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'price'    => number_format($product->sale_price ?? $product->price),
                    'category' => $product->category->name ?? '',
                    'image'    => $product->main_image
                        ? asset('storage/' . $product->main_image)
                        : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=80&q=80',
                    'url'      => route('products.index', ['search' => $product->name]),
                ];
            });

        return response()->json($products);
    }
}