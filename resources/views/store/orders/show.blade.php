@extends('layouts.app')
@section('title', 'Order #' . $order->order_number . ' — ShopZone')

@section('content')
<div class="container py-4">

    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.orders.index') }}">My Orders</a></li>
                <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="page-title mb-1">Order #{{ $order->order_number }}</h1>
                <p class="page-sub">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Order Items --}}
        <div class="col-lg-8">
            <div class="panel overflow-hidden mb-4">
                <div class="panel-head d-flex justify-content-between align-items-center">
                    <h6 class="panel-title">Order Items</h6>
                    @php
                        $colors = [
                            'pending' => 'warning', 'confirmed' => 'info', 'processing' => 'primary',
                            'shipped' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger',
                        ];
                    @endphp
                    <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="width:76px;">
                                    <img src="{{ $item->product ? $item->product->image_url : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=120&q=80' }}"
                                        alt="{{ $item->product_name }}" class="cart-thumb" style="width:56px;height:56px;">
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                    <div class="text-muted" style="font-size:.74rem;">SKU: {{ $item->product_sku }}</div>
                                </td>
                                <td class="text-muted" style="font-size:.8rem;">
                                    PKR {{ number_format($item->price) }} × {{ $item->quantity }}
                                </td>
                                <td class="fw-bold text-end">
                                    PKR {{ number_format($item->subtotal) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Order Timeline --}}
            <div class="panel panel-pad">
                <h6 class="panel-title mb-4">Order Timeline</h6>
                @foreach($order->statusHistories as $history)
                <div class="d-flex gap-3 mb-3">
                    <div class="text-primary" style="width:20px;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:.84rem;">{{ ucfirst($history->status) }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $history->comment }}</div>
                        <div class="text-muted" style="font-size:.72rem;">{{ $history->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="panel panel-pad mb-4">
                <h6 class="panel-title mb-3 pb-3" style="border-bottom:1px solid var(--line);">Order Summary</h6>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span class="v">PKR {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="v">{{ $order->shipping_amount == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_amount) }}</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span class="v">PKR {{ number_format($order->total) }}</span>
                </div>
            </div>

            <div class="panel panel-pad mb-4">
                <h6 class="panel-title mb-3 pb-3" style="border-bottom:1px solid var(--line);">Shipping Details</h6>
                <div style="font-size:.84rem;">
                    <div class="fw-semibold">{{ $order->shipping_name }}</div>
                    <div class="text-muted">{{ $order->shipping_phone }}</div>
                    <div class="text-muted">{{ $order->shipping_address }}</div>
                    <div class="text-muted">{{ $order->shipping_city }}</div>
                </div>
            </div>

            <div class="panel panel-pad">
                <h6 class="panel-title mb-3 pb-3" style="border-bottom:1px solid var(--line);">Payment</h6>
                <div class="d-flex justify-content-between align-items-center" style="font-size:.84rem;">
                    <span class="text-muted">Method</span>
                    <span class="fw-semibold">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2" style="font-size:.84rem;">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
