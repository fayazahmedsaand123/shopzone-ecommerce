@extends('layouts.app')
@section('title', 'My Dashboard — ShopZone')

@section('content')
<div class="container">
    <div class="page-head">
        <span class="eyebrow"><i class="bi bi-speedometer2"></i>My account</span>
        <h1 class="page-title mt-2">Dashboard</h1>
        <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}.</p>
    </div>

    <div class="row g-4 pb-5">
        <div class="col-lg-3">
            <div class="panel panel-pad">
                <div class="text-center mb-3 pb-3" style="border-bottom:1px solid var(--line);">
                    <div class="brand-mark mx-auto mb-2" style="width:56px;height:56px;font-size:1.4rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <div class="text-muted small">{{ auth()->user()->email }}</div>
                </div>
                <nav class="d-flex flex-column gap-2">
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary btn-sm text-start">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-light btn-sm text-start">
                        <i class="bi bi-bag me-2"></i>My Orders
                    </a>
                    <a href="{{ route('customer.wishlist.index') }}" class="btn btn-outline-light btn-sm text-start">
                        <i class="bi bi-heart me-2"></i>Wishlist
                    </a>
                    <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-light btn-sm text-start">
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

        <div class="col-lg-9">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="num">{{ auth()->user()->orders()->count() }}</div>
                        <div class="lbl">Total orders</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="num">{{ auth()->user()->orders()->where('status','delivered')->count() }}</div>
                        <div class="lbl">Delivered</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="num">{{ auth()->user()->wishlist()->count() }}</div>
                        <div class="lbl">Wishlist items</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h2 class="h6 fw-bold mb-0">Recent orders</h2>
                    <a href="{{ route('customer.orders.index') }}" class="link-arrow">View all <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(auth()->user()->orders()->latest()->take(5)->get() as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order->order_number }}</td>
                                <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="current-price">PKR {{ number_format($order->total) }}</td>
                                <td>
                                    @php $tones = ['pending'=>'warning','confirmed'=>'info','processing'=>'primary','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger']; @endphp
                                    <span class="badge bg-{{ $tones[$order->status] ?? 'secondary' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-light">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state border-0 py-5">
                                        <div class="icon"><i class="bi bi-bag"></i></div>
                                        <h4>No orders yet</h4>
                                        <p class="mb-3">Your first order is just a few clicks away.</p>
                                        <a href="{{ route('products.index') }}" class="btn btn-primary">Start shopping</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
