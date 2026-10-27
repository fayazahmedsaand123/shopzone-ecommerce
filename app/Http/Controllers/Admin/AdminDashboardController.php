<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminDashboardController extends Controller {
    public function index() {
        $stats = [
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_categories'=> Category::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}