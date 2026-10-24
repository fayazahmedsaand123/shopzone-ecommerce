@extends('layouts.app')
@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Order #{{ $order->order_number }}</h4>
        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Orders
        </a>
    </div>

    <div class="row g-4">

        {{-- Order Items --}}
        <div class="col-lg-8">
            <div class="bg-white rounded-3 border overflow-hidden mb-4">
                <div class="p-3 border-bottom bg-light">
                    <h6 class="mb-0 fw-bold">Order Items</h6>
                </div>
                <table class="table align-middle mb-0">
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td width="60">
                                <img src="{{ $item->product && $item->product->main_image ? asset('storage/'.$item->product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60' }}"
                                    width="55" height="55" class="rounded" style="object-fit:cover;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                <div class="text-muted" style="font-size:12px;">SKU: {{ $item->product_sku }}</div>
                            </td>
                            <td class="text-muted" style="font-size:13px;">
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

            {{-- Order Timeline --}}
            <div class="bg-white rounded-3 border p-4">
                <h6 class="fw-bold mb-3">Order Timeline</h6>
                @foreach($order->statusHistories as $history)
                <div class="d-flex gap-3 mb-3">
                    <div class="text-primary" style="width:20px;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px;">{{ ucfirst($history->status) }}</div>
                        <div class="text-muted" style="font-size:12px;">{{ $history->comment }}</div>
                        <div class="text-muted" style="font-size:11px;">{{ $history->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="bg-white rounded-3 border p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Order Summary</h6>

                <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                    <span class="text-muted">Subtotal</span>
                    <span>PKR {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                    <span class="text-muted">Shipping</span>
                    <span>{{ $order->shipping_amount == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_amount) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-danger">PKR {{ number_format($order->total) }}</span>
                </div>
            </div>

            <div class="bg-white rounded-3 border p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Shipping Details</h6>
                <div style="font-size:13px;">
                    <div class="fw-semibold">{{ $order->shipping_name }}</div>
                    <div class="text-muted">{{ $order->shipping_phone }}</div>
                    <div class="text-muted">{{ $order->shipping_address }}</div>
                    <div class="text-muted">{{ $order->shipping_city }}</div>
                </div>
            </div>

            <div class="bg-white rounded-3 border p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Payment</h6>
                <div class="d-flex justify-content-between" style="font-size:13px;">
                    <span class="text-muted">Method</span>
                    <span class="fw-semibold">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-2" style="font-size:13px;">
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