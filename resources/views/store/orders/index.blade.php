@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-bag me-2"></i>My Orders</h4>

    @if($orders->count())
    <div class="bg-white rounded-3 border overflow-hidden">
        <table class="table align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Order #</th>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Date</th>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Items</th>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Total</th>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Status</th>
                    <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ $order->items()->count() }} items</td>
                    <td class="fw-bold text-danger">PKR {{ number_format($order->total) }}</td>
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
                    <td>
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
    <div class="mt-3">{{ $orders->links() }}</div>

    @else
    <div class="text-center py-5 bg-white rounded-3 border">
        <i class="bi bi-bag-x" style="font-size:64px;color:#ddd;"></i>
        <h4 class="mt-3 text-muted">No orders yet</h4>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5">Start Shopping</a>
    </div>
    @endif
</div>
@endsection