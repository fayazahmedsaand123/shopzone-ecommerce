@props(['product'])

@php
    $image = $product->main_image
        ? asset('storage/' . $product->main_image)
        : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&q=80';
    $currentPrice = $product->sale_price ?? $product->price;
    $discount = $product->sale_price
        ? round((($product->price - $product->sale_price) / $product->price) * 100)
        : 0;
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
                <span class="badge-out">Out of Stock</span>
            @endif
        </div>

        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $image }}" alt="{{ $product->name }}" class="product-img" loading="lazy">
        </a>

        {{-- Hover Actions --}}
        <div class="product-actions">
            <button class="action-btn wishlist-btn" title="Add to Wishlist"
                data-product-id="{{ $product->id }}">
                <i class="bi bi-heart"></i>
            </button>
            <button class="action-btn" title="Quick View">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <div class="product-info">
        @if($product->category)
            <div class="product-category">{{ $product->category->name }}</div>
        @endif

        <h6 class="product-name">
            <a href="{{ route('products.show', $product->slug) }}"
            style="text-decoration:none;color:inherit;">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Rating --}}
        <div class="product-rating">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star{{ $i <= round($product->average_rating) ? '-fill text-warning' : ' text-muted' }}"
                   style="font-size:12px;"></i>
            @endfor
        </div>

        {{-- Price --}}
        <div class="product-price">
            <span class="current-price">PKR {{ number_format($currentPrice) }}</span>
            @if($product->sale_price)
                <span class="old-price">PKR {{ number_format($product->price) }}</span>
            @endif
        </div>

        {{-- Single Add to Cart Button --}}
        <button class="btn-add-cart {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}"
            data-product-id="{{ $product->id }}"
            {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
            <i class="bi bi-cart-plus me-1"></i>
            {{ $product->stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
    </div>
</div>