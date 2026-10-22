@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Products</div>
                    <div class="fs-3 fw-bold mt-1">{{ $stats['total_products'] }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Orders</div>
                    <div class="fs-3 fw-bold mt-1">{{ $stats['total_orders'] }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-bag-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Customers</div>
                    <div class="fs-3 fw-bold mt-1">{{ $stats['total_customers'] }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Categories</div>
                    <div class="fs-3 fw-bold mt-1">{{ $stats['total_categories'] }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-grid"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Pending Orders</div>
                    <div class="fs-3 fw-bold mt-1 text-warning">{{ $stats['pending_orders'] }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted" style="font-size:12px;">Low Stock</div>
                    <div class="fs-3 fw-bold mt-1 text-danger">{{ $stats['low_stock'] }}</div>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="admin-table">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Recent Orders</h6>
        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_orders as $order)
            <tr>
                <td><strong>#{{ $order->order_number }}</strong></td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>PKR {{ number_format($order->total, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-4 text-muted">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection