<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use App\Models\ContactMessage;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Stats Cards ───────────────────────────────────
        $stats = [
            'total_products'   => Product::count(),
            'total_orders'     => Order::count(),
            'total_customers'  => User::where('role', 'customer')->count(),
            'total_categories' => Category::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'low_stock'        => Product::where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
            'total_revenue'    => Order::whereIn('status', ['delivered','processing','shipped'])->sum('total'),
            'today_orders'     => Order::whereDate('created_at', today())->count(),
        ];

        // ── Sales Last 7 Days ─────────────────────────────
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesLabels[] = $date->format('d M');
            $salesData[] = Order::whereDate('created_at', $date->toDateString())
                ->whereIn('status', ['delivered','processing','shipped','confirmed'])
                ->sum('total');
        }

        // ── Orders by Status ──────────────────────────────
        $orderStatuses = ['pending','confirmed','processing','shipped','delivered','cancelled'];
        $orderStatusData = [];
        foreach ($orderStatuses as $s) {
            $orderStatusData[] = Order::where('status', $s)->count();
        }

        // ── Top 5 Products ────────────────────────────────
        $top_products = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // ── Recent Orders ─────────────────────────────────
        $recent_orders = Order::with('user')->latest()->take(8)->get();

        // ── Monthly Revenue (last 6 months) ───────────────
        $monthlyLabels = [];
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            $monthlyRevenue[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->whereIn('status', ['delivered','processing','shipped','confirmed'])
                ->sum('total');
        }

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'top_products',
            'salesLabels',
            'salesData',
            'orderStatuses',
            'orderStatusData',
            'monthlyLabels',
            'monthlyRevenue'
        ));
    }
}