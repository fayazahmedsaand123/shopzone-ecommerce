<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->status) $query->where('status', $request->status);
        if ($request->search) {
            $query->where('order_number', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'statusHistories', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'  => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'comment' => 'nullable|string|max:500',
        ]);

        $order->update(['status' => $request->status]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status'   => $request->status,
            'comment'  => $request->comment ?? 'Status updated by admin.',
            'user_id'  => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'status'  => ucfirst($request->status),
        ]);
    }
}