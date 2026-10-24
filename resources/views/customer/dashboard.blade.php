@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="bg-white rounded-3 border p-3">
                <div class="text-center mb-3 pb-3 border-bottom">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
                        style="width:60px;height:60px;font-size:24px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ auth()->user()->email }}</div>
                </div>
                <nav class="d-flex flex-column gap-1">
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary btn-sm text-start">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                        <i class="bi bi-bag me-2"></i>My Orders
                    </a>
                    <a href="{{ route('customer.wishlist.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                        <i class="bi bi-heart me-2"></i>Wishlist
                    </a>
                    <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                        <i class="bi bi-cart me-2"></i>Cart
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm w-100 text-start">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-9">

            {{-- Stats --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="bg-white rounded-3 border p-3 text-center">
                        <div class="text-primary fs-2 fw-bold">
                            {{ auth()->user()->orders()->count() }}
                        </div>
                        <div class="text-muted" style="font-size:13px;">Total Orders</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white rounded-3 border p-3 text-center">
                        <div class="text-success fs-2 fw-bold">
                            {{ auth()->user()->orders()->where('status','delivered')->count() }}
                        </div>
                        <div class="text-muted" style="font-size:13px;">Delivered</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white rounded-3 border p-3 text-center">
                        <div class="text-warning fs-2 fw-bold">
                            {{ auth()->user()->wishlist()->count() }}
                        </div>
                        <div class="text-muted" style="font-size:13px;">Wishlist Items</div>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-white rounded-3 border overflow-hidden">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Recent Orders</h6>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <table class="table align-middle mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th style="font-size:12px;color:#6c757d;">Order #</th>
                            <th style="font-size:12px;color:#6c757d;">Date</th>
                            <th style="font-size:12px;color:#6c757d;">Total</th>
                            <th style="font-size:12px;color:#6c757d;">Status</th>
                            <th style="font-size:12px;color:#6c757d;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(auth()->user()->orders()->latest()->take(5)->get() as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td class="text-danger fw-bold">PKR {{ number_format($order->total) }}</td>
                            <td>
                                @php $colors = ['pending'=>'warning','confirmed'=>'info','processing'=>'primary','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
                                <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection