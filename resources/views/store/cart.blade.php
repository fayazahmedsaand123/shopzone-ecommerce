@extends('layouts.app')
@section('title', 'Shopping Cart — ShopZone')

@section('content')
<div class="container py-4">
    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Shopping Cart</li>
            </ol>
        </nav>
        <h1 class="page-title"><i class="bi bi-cart3 me-2"></i>Shopping Cart</h1>
        <p class="page-sub">{{ $items->sum('quantity') }} {{ Str::plural('item', $items->sum('quantity')) }} in your cart</p>
    </div>

    @if($items->count())
    <div class="row g-4">

        {{-- Cart Items --}}
        <div class="col-lg-8">
            <div class="panel overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle" id="cart-table">
                        <thead>
                            <tr>
                                <th colspan="2">Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
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
                                <td style="width:84px;">
                                    <img src="{{ $item->product->image_url }}"
                                        alt="{{ $item->product->name }}" class="cart-thumb">
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $item->product->slug) }}"
                                       class="fw-semibold" style="font-size:.88rem;color:var(--text);">
                                        {{ $item->product->name }}
                                    </a>
                                    <div class="text-muted" style="font-size:.74rem;">{{ $item->product->category->name ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="fw-semibold" style="color:var(--accent);">PKR {{ number_format($price) }}</span>
                                </td>
                                <td>
                                    <div class="qty-stepper">
                                        <button type="button" class="qty-btn"
                                            data-cart-id="{{ $item->id }}"
                                            data-action="decrease">−</button>
                                        <span class="value cart-qty" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                        <button type="button" class="qty-btn"
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
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger remove-btn"
                                        data-cart-id="{{ $item->id }}" title="Remove item">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                </a>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="panel panel-pad sticky-top" style="top:110px;">
                <h6 class="panel-title mb-3 pb-3" style="border-bottom:1px solid var(--line);">
                    <i class="bi bi-receipt"></i>Order Summary
                </h6>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span class="v" id="cart-subtotal">PKR {{ number_format($subtotal) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="v {{ $subtotal >= 5000 ? 'text-success' : '' }}" id="cart-shipping">
                        {{ $subtotal >= 5000 ? 'FREE' : 'PKR 200' }}
                    </span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span class="v" id="cart-total">
                        PKR {{ number_format($subtotal >= 5000 ? $subtotal : $subtotal + 200) }}
                    </span>
                </div>

                <a href="{{ route('customer.checkout') }}" class="btn btn-primary w-100 btn-lg mt-4">
                    <i class="bi bi-lock me-2"></i>Proceed to Checkout
                </a>

                <div class="text-center mt-3">
                    <small class="text-muted" style="font-size:.74rem;">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Secure SSL encrypted checkout
                    </small>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- Empty Cart --}}
    <div class="empty-state">
        <div class="icon"><i class="bi bi-cart-x"></i></div>
        <h4>Your cart is empty</h4>
        <p>Looks like you haven't added anything yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5 mt-1">
            <i class="bi bi-bag me-2"></i>Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function refreshCartSummary(subtotalText) {
        const value = parseInt(String(subtotalText).replace(/[^\d]/g, ''), 10) || 0;
        const freeShipping = value >= 5000;

        $('#cart-shipping')
            .text(freeShipping ? 'FREE' : 'PKR 200')
            .toggleClass('text-success', freeShipping);
        $('#cart-total').text('PKR ' + (freeShipping ? value : value + 200).toLocaleString('en-US'));
    }

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
                    refreshCartSummary(res.subtotal);
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
                    refreshCartSummary(res.subtotal);
                    $('#cart-count').text(res.cart_count);
                    showToast(res.message);
                }
            }
        });
    });
</script>
@endpush
