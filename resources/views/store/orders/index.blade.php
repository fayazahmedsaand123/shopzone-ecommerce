@extends('layouts.app')
@section('title', 'My Orders — ShopZone')

@section('content')
<div class="container py-4">
    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Account</a></li>
                <li class="breadcrumb-item active">My Orders</li>
            </ol>
        </nav>
        <h1 class="page-title"><i class="bi bi-bag me-2"></i>My Orders</h1>
        <p class="page-sub">Track and review all your ShopZone orders</p>
    </div>

    @if($orders->count())
    <div class="panel overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="text-muted">{{ $order->items()->count() }} items</td>
                        <td class="fw-bold" style="color:var(--accent);">PKR {{ number_format($order->total) }}</td>
                        <td>
                            @php
                                $colors = [
                                    'pending'    => 'warning',
                                    'confirmed'  => 'info',
                                    'processing' => 'primary',
                                    'shipped'    => 'primary',
                                    'delivered'  => 'success',
                                    'cancelled'  => 'danger',
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>

    @else
    <div class="empty-state">
        <div class="icon"><i class="bi bi-bag-x"></i></div>
        <h4>No orders yet</h4>
        <p>When you place an order it will appear here.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5 mt-1">Start Shopping</a>
    </div>
    @endif
</div>
@endsection
