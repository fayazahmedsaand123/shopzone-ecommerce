<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Toggle wishlist
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $action = 'removed';
            $message = 'Removed from wishlist.';
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ]);
            $action = 'added';
            $message = 'Added to wishlist!';
        }

        $count = Wishlist::where('user_id', auth()->id())->count();

        return response()->json([
            'success'        => true,
            'action'         => $action,
            'message'        => $message,
            'wishlist_count' => $count,
        ]);
    }

    // View wishlist
    public function index()
    {
        $items = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('store.wishlist', compact('items'));
    }
}