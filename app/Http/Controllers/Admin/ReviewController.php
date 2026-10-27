<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {

    public function index(Request $request) {
        $query = Review::with(['user', 'product']);

        if ($request->status) $query->where('status', $request->status);

        $reviews = $query->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, Review $review) {
        $request->validate(['status' => 'required|in:approved,rejected,pending']);
        $review->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Review ' . $request->status . ' successfully.',
        ]);
    }

    public function destroy(Review $review) {
        $review->delete();
        return response()->json(['success' => true, 'message' => 'Review deleted.']);
    }
}