@props(['product'])

@php
    $currentPrice = $product->sale_price ?? $product->price;
    $discount = $product->sale_price
        ? round((($product->price - $product->sale_price) / $product->price) * 100)
        : 0;
    $rating = round($product->average_rating, 1);
@endphp

<div class="product-card">
    <div class="product-img-wrap">

        {{-- Badges --}}
        <div class="product-badges">
            @if($discount > 0)
                <span class="badge-sale">-{{ $discount }}%</span>
            @endif
            @if($product->is_featured)
                <span class="badge-featured">Featured</span>
            @endif
            @if($product->stock_quantity <= 0)
                <span class="badge-out">Out of stock</span>
            @endif
        </div>

        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img" loading="lazy">
        </a>

        {{-- Hover Actions --}}
        <div class="product-actions">
            <button class="action-btn wishlist-btn" title="Add to wishlist" aria-label="Add to wishlist"
                data-product-id="{{ $product->id }}">
                <i class="bi bi-heart"></i>
            </button>
            <a href="{{ route('products.show', $product->slug) }}" class="action-btn" title="View details" aria-label="View details">
                <i class="bi bi-arrow-up-right"></i>
            </a>
        </div>
    </div>

    <div class="product-info">
        @if($product->category)
            <div class="product-category">{{ $product->category->name }}</div>
        @endif

        <h6 class="product-name">
            <a href="{{ route('products.show', $product->slug) }}">
                {{ Str::limit($product->name, 50) }}
            </a>
        </h6>

        {{-- Rating --}}
        <div class="product-rating">
            <span class="d-inline-flex align-items-center" style="gap:1px;">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($rating) ? '-fill' : '' }}"
                       style="color:{{ $i <= round($rating) ? 'var(--accent)' : 'rgba(255,255,255,.16)' }};"></i>
                @endfor
            </span>
            <span>{{ $rating > 0 ? number_format($rating, 1) : 'New' }}</span>
        </div>

        {{-- Price --}}
        <div class="product-price">
            <span class="current-price">PKR {{ number_format($currentPrice) }}</span>
            @if($product->sale_price)
                <span class="old-price">PKR {{ number_format($product->price) }}</span>
            @endif
        </div>

        {{-- Add to Cart --}}
        <button class="btn-add-cart {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}"
            data-product-id="{{ $product->id }}"
            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
            <i class="bi bi-cart-plus"></i>
            {{ $product->stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
    </div>
</div>
