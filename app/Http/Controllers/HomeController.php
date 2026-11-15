<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class HomeController extends Controller {
    public function index() {
        $categories = Category::where('status', 'active')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $featured_products = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $new_arrivals = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $best_sellers = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->orderBy('views_count', 'desc')
            ->take(8)
            ->get();

        $brands = Brand::where('status', 'active')->take(8)->get();

        $hero_product = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->whereHas('category', fn ($q) => $q->whereIn('slug', [
                'laptops-computers', 'mobile-phones', 'electronics', 'cameras', 'audio',
            ]))
            ->orderByDesc('price')
            ->first();

        $stats = [
            'products'   => Product::where('status', 'active')->count(),
            'brands'     => Brand::where('status', 'active')->count(),
            'categories' => Category::where('status', 'active')->count(),
        ];

        return view('store.home', compact(
            'categories',
            'featured_products',
            'new_arrivals',
            'best_sellers',
            'brands',
            'hero_product',
            'stats'
        ));
    }
}