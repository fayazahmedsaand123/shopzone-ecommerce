@extends('layouts.app')
@section('title', 'Checkout — ShopZone')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-lock me-2"></i>Secure Checkout</h4>

    <form method="POST" action="{{ route('customer.checkout.place') }}">
    @csrf
    <div class="row g-4">

        {{-- Left: Shipping Info --}}
        <div class="col-lg-7">
            <div class="bg-white rounded-3 border p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Shipping Information
                </h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                        value="{{ old('full_name', auth()->user()->name) }}">
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone Number *</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', auth()->user()->phone) }}" placeholder="03XX-XXXXXXX">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Complete Address *</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                        rows="3" placeholder="House #, Street, Area">{{ old('address') }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">City *</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city') }}" placeholder="e.g. Karachi, Lahore, Hyderabad">
                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Order Notes (Optional)</label>
                    <textarea name="order_notes" class="form-control" rows="2"
                        placeholder="Any special instructions...">{{ old('order_notes') }}</textarea>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-3 border p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-credit-card me-2 text-primary"></i>Payment Method
                </h6>

                <div class="form-check border rounded-3 p-3 mb-2" style="cursor:pointer;">
                    <input class="form-check-input" type="radio" name="payment_method"
                        id="cod" value="cod" checked>
                    <label class="form-check-label d-flex align-items-center gap-2 w-100" for="cod" style="cursor:pointer;">
                        <i class="bi bi-cash-coin fs-4 text-success"></i>
                        <div>
                            <div class="fw-bold">Cash on Delivery</div>
                            <div class="text-muted" style="font-size:12px;">Pay when your order arrives at your door</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Right: Order Summary --}}
        <div class="col-lg-5">
            <div class="bg-white rounded-3 border p-4 sticky-top" style="top:80px;">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Order Summary</h6>

                {{-- Items --}}
                @foreach($items as $item)
                @php $price = $item->product->sale_price ?? $item->product->price; @endphp
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $item->product->main_image ? asset('storage/'.$item->product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60' }}"
                        width="50" height="50" class="rounded border" style="object-fit:cover;">
                    <div class="flex-grow-1">
                        <div style="font-size:13px;font-weight:600;">{{ Str::limit($item->product->name, 30) }}</div>
                        <div class="text-muted" style="font-size:12px;">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="fw-bold" style="font-size:13px;">
                        PKR {{ number_format($price * $item->quantity) }}
                    </div>
                </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Subtotal</span>
                    <span>PKR {{ number_format($subtotal) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Shipping</span>
                    <span class="{{ $shipping == 0 ? 'text-success fw-bold' : '' }}">
                        {{ $shipping == 0 ? 'FREE' : 'PKR ' . number_format($shipping) }}
                    </span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-6">Total</span>
                    <span class="fw-bold fs-5 text-danger">PKR {{ number_format($total) }}</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold">
                    <i class="bi bi-bag-check me-2"></i>Place Order
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Your information is secure and encrypted
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection