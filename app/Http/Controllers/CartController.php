<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add to cart
    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Product is out of stock.']);
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            if ($cart->quantity >= $product->stock_quantity) {
                return response()->json(['success' => false, 'message' => 'Not enough stock available.']);
            }
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        $count = Cart::where('user_id', auth()->id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Added to cart!',
            'cart_count' => $count,
        ]);
    }

    // View cart
    public function index()
    {
        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $items->sum(fn($item) =>
            ($item->product->sale_price ?? $item->product->price) * $item->quantity
        );

        return view('store.cart', compact('items', 'subtotal'));
    }

    // Update quantity via AJAX
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = $cart->product;

        if ($request->quantity > $product->stock_quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock.']);
        }

        $cart->update(['quantity' => $request->quantity]);

        $itemTotal  = ($product->sale_price ?? $product->price) * $cart->quantity;
        $cartItems  = Cart::with('product')->where('user_id', auth()->id())->get();
        $subtotal   = $cartItems->sum(fn($i) => ($i->product->sale_price ?? $i->product->price) * $i->quantity);
        $cartCount  = $cartItems->sum('quantity');

        return response()->json([
            'success'    => true,
            'item_total' => 'PKR ' . number_format($itemTotal),
            'subtotal'   => 'PKR ' . number_format($subtotal),
            'cart_count' => $cartCount,
        ]);
    }

    // Remove item via AJAX
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $cart->delete();

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $subtotal  = $cartItems->sum(fn($i) => ($i->product->sale_price ?? $i->product->price) * $i->quantity);
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'success'    => true,
            'message'    => 'Item removed.',
            'subtotal'   => 'PKR ' . number_format($subtotal),
            'cart_count' => $cartCount,
        ]);
    }
}