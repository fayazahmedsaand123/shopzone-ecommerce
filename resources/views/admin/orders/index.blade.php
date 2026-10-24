@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>All Orders</h4>
</div>

{{-- Filters --}}
<div class="admin-table p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                placeholder="Order # or customer name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            @php $colors = ['pending'=>'warning','confirmed'=>'info','processing'=>'primary','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
            <tr>
                <td><strong>#{{ $order->order_number }}</strong></td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->items()->count() }}</td>
                <td class="fw-bold">PKR {{ number_format($order->total) }}</td>
                <td>
                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4 text-muted">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $orders->links() }}</div>
</div>
@endsection