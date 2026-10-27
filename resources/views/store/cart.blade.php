@extends('layouts.app')
@section('title', 'Shopping Cart — ShopZone')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Shopping Cart</h4>

    @if($items->count())
    <div class="row g-4">

        {{-- Cart Items --}}
        <div class="col-lg-8">
            <div class="bg-white rounded-3 border overflow-hidden">
                <table class="table align-middle mb-0" id="cart-table">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th style="font-size:12px;text-transform:uppercase;color:#6c757d;" colspan="2">Product</th>
                            <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Price</th>
                            <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Quantity</th>
                            <th style="font-size:12px;text-transform:uppercase;color:#6c757d;">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        @php
                            $price = $item->product->sale_price ?? $item->product->price;
                            $total = $price * $item->quantity;
                        @endphp
                        <tr id="cart-row-{{ $item->id }}">
                            <td width="70">
                                <img src="{{ $item->product->main_image ? asset('storage/'.$item->product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=80' }}"
                                    width="60" height="60" class="rounded" style="object-fit:cover;">
                            </td>
                            <td>
                                <div class="fw-semibold" style="font-size:14px;">{{ $item->product->name }}</div>
                                <div class="text-muted" style="font-size:12px;">{{ $item->product->category->name ?? '' }}</div>
                            </td>
                            <td>
                                <span class="fw-bold text-danger">PKR {{ number_format($price) }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2" style="width:120px;">
                                    <button class="btn btn-sm btn-outline-secondary qty-btn"
                                        data-cart-id="{{ $item->id }}"
                                        data-action="decrease">−</button>
                                    <span class="fw-bold cart-qty" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button class="btn btn-sm btn-outline-secondary qty-btn"
                                        data-cart-id="{{ $item->id }}"
                                        data-action="increase"
                                        data-max="{{ $item->product->stock_quantity }}">+</button>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold" id="item-total-{{ $item->id }}">
                                    PKR {{ number_format($total) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger remove-btn"
                                    data-cart-id="{{ $item->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                </a>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="bg-white rounded-3 border p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Order Summary</h6>

                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold" id="cart-subtotal">PKR {{ number_format($subtotal) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Shipping</span>
                    <span class="text-success fw-semibold">
                        {{ $subtotal >= 5000 ? 'FREE' : 'PKR 200' }}
                    </span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-danger fs-5" id="cart-total">
                        PKR {{ number_format($subtotal >= 5000 ? $subtotal : $subtotal + 200) }}
                    </span>
                </div>

                <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 btn-lg fw-bold">
                    <i class="bi bi-lock me-2"></i>Proceed to Checkout
                </a>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Secure SSL encrypted payment
                    </small>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- Empty Cart --}}
    <div class="text-center py-5 bg-white rounded-3 border">
        <i class="bi bi-cart-x" style="font-size:64px;color:#ddd;"></i>
        <h4 class="mt-3 text-muted">Your cart is empty</h4>
        <p class="text-muted">Looks like you haven't added anything yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5">
            <i class="bi bi-bag me-2"></i>Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Quantity update
    $(document).on('click', '.qty-btn', function () {
        const cartId = $(this).data('cart-id');
        const action = $(this).data('action');
        const max    = $(this).data('max') || 999;
        let qty      = parseInt($('#qty-' + cartId).text());

        if (action === 'increase') {
            if (qty >= max) { showToast('Not enough stock.', 'error'); return; }
            qty++;
        } else {
            if (qty <= 1) return;
            qty--;
        }

        $.ajax({
            url: '/account/cart/' + cartId,
            type: 'PATCH',
            data: { quantity: qty },
            success: function (res) {
                if (res.success) {
                    $('#qty-' + cartId).text(qty);
                    $('#item-total-' + cartId).text(res.item_total);
                    $('#cart-subtotal').text(res.subtotal);
                    $('#cart-count').text(res.cart_count);
                } else {
                    showToast(res.message, 'error');
                }
            }
        });
    });

    // Remove item
    $(document).on('click', '.remove-btn', function () {
        const cartId = $(this).data('cart-id');
        if (!confirm('Remove this item from cart?')) return;

        $.ajax({
            url: '/account/cart/' + cartId,
            type: 'DELETE',
            success: function (res) {
                if (res.success) {
                    $('#cart-row-' + cartId).fadeOut(300, function () {
                        $(this).remove();
                        if ($('#cart-table tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                    $('#cart-subtotal').text(res.subtotal);
                    $('#cart-count').text(res.cart_count);
                    showToast(res.message);
                }
            }
        });
    });
</script>
@endpush