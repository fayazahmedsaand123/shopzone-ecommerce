@extends('layouts.app')
@section('title', 'ShopZone — Pakistan\'s #1 Online Store')

@php
    $catIcons = [
        'mobile-phones'      => 'bi-phone',
        'electronics'        => 'bi-tv',
        'laptops-computers'  => 'bi-laptop',
        'gaming'             => 'bi-controller',
        'cameras'            => 'bi-camera',
        'audio'              => 'bi-headphones',
        'fashion'            => 'bi-bag',
        'footwear'           => 'bi-box-seam',
        'watches'            => 'bi-smartwatch',
        'home-living'        => 'bi-house',
        'sports'             => 'bi-bicycle',
        'health-beauty'      => 'bi-heart-pulse',
        'books'              => 'bi-book',
        'toys-kids'          => 'bi-robot',
    ];
    $heroProduct = $hero_product ?? $featured_products->first() ?? $new_arrivals->first();
@endphp

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge fade-up">
                    <i class="bi bi-lightning-charge-fill"></i>New season · 2026 collection
                </div>
                <h1 class="hero-title fade-up d1">
                    Shop smarter.<br>
                    Live <span class="grad">better.</span>
                </h1>
                <p class="hero-subtitle fade-up d2">
                    A curated marketplace of {{ number_format($stats['products']) }} products across
                    {{ $stats['categories'] }} categories — from the latest tech to everyday essentials,
                    delivered anywhere in Pakistan.
                </p>
                <div class="d-flex gap-2 flex-wrap fade-up d3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag-fill me-2"></i>Shop Now
                    </a>
                    <a href="#categories" class="btn btn-outline-light btn-lg">
                        Browse Categories
                        <i class="bi bi-arrow-down-right ms-1"></i>
                    </a>
                </div>
                <div class="hero-stats fade-up d3">
                    <div class="hero-stat">
                        <div class="num">{{ number_format($stats['products']) }}+</div>
                        <div class="lbl">Products</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num">{{ number_format($stats['brands']) }}+</div>
                        <div class="lbl">Brands</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num">4.9/5</div>
                        <div class="lbl">Customer rating</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-stage fade-up d2">
                    @if($heroProduct)
                        <a href="{{ route('products.show', $heroProduct->slug) }}" class="hero-img-wrap d-block">
                            <img src="{{ $heroProduct->image_url }}" alt="{{ $heroProduct->name }}" class="hero-img">
                        </a>
                        <div class="hero-float top">
                            <span class="icon"><i class="bi bi-truck"></i></span>
                            <div>
                                <div class="t">Free delivery</div>
                                <div class="v">Nationwide</div>
                            </div>
                        </div>
                        <div class="hero-float bottom">
                            <span class="icon"><i class="bi bi-stars"></i></span>
                            <div>
                                <div class="t">Top pick this week</div>
                                <div class="v">PKR {{ number_format($heroProduct->current_price) }}</div>
                            </div>
                        </div>
                    @else
                        <div class="hero-img-wrap d-flex align-items-center justify-content-center">
                            <i class="bi bi-bag-heart" style="font-size:5rem;color:rgba(255,255,255,.15);"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TRUST STRIP --}}
<div class="trust-strip">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <span class="icon"><i class="bi bi-truck"></i></span>
                    <div>
                        <div class="t">Free Shipping</div>
                        <div class="s">On orders over PKR 5,000</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <span class="icon"><i class="bi bi-arrow-repeat"></i></span>
                    <div>
                        <div class="t">Easy Returns</div>
                        <div class="s">7-day return policy</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <span class="icon"><i class="bi bi-shield-check"></i></span>
                    <div>
                        <div class="t">Secure Payment</div>
                        <div class="s">100% protected checkout</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="trust-item">
                    <span class="icon"><i class="bi bi-headset"></i></span>
                    <div>
                        <div class="t">24/7 Support</div>
                        <div class="s">Always here for you</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CATEGORIES --}}
<section class="section-block" id="categories">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Explore</div>
                <h2 class="section-title">Shop by Category</h2>
                <p class="section-subtitle">Find exactly what you're looking for</p>
            </div>
            <a href="{{ route('products.index') }}" class="link-arrow d-none d-md-inline-flex">
                View all products <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-6 g-3">
            @forelse($categories as $category)
            <div class="col">
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
                    <div class="category-icon-wrap">
                        <i class="bi {{ $catIcons[$category->slug] ?? 'bi-grid' }}"></i>
                    </div>
                    <div class="category-card-name">{{ $category->name }}</div>
                    <div class="category-card-count">{{ $category->products_count }} items</div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">No categories yet.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featured_products->count())
<section class="section-block tight">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Handpicked</div>
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Selected by our team for quality and value</p>
            </div>
            <a href="{{ route('products.index') }}" class="link-arrow d-none d-md-inline-flex">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4">
            @foreach($featured_products as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- PROMO BANNERS --}}
<section class="section-block tight">
    <div class="container">
        <div class="row g-3 g-lg-4">
            <div class="col-md-6">
                <div class="promo-banner">
                    <span class="promo-glow"></span>
                    <div class="position-relative">
                        <div class="promo-eyebrow">Limited time offer</div>
                        <h4>Up to 30% off<br>all electronics</h4>
                        <a href="{{ route('products.index', ['category' => 'electronics']) }}" class="btn btn-light btn-sm fw-semibold">
                            Shop Electronics <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <i class="bi bi-laptop promo-icon"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-banner warm">
                    <span class="promo-glow"></span>
                    <div class="position-relative">
                        <div class="promo-eyebrow">New arrivals</div>
                        <h4>Fresh fashion<br>collection 2026</h4>
                        <a href="{{ route('products.index', ['category' => 'fashion']) }}" class="btn btn-light btn-sm fw-semibold">
                            Explore Fashion <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <i class="bi bi-bag promo-icon"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- NEW ARRIVALS --}}
@if($new_arrivals->count())
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Just landed</div>
                <h2 class="section-title">New Arrivals</h2>
                <p class="section-subtitle">Fresh products added every week</p>
            </div>
            <a href="{{ route('new-arrivals') }}" class="link-arrow d-none d-md-inline-flex">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4">
            @foreach($new_arrivals as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BRANDS --}}
@if($brands->count())
<section class="section-block tight">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Trusted partners</div>
                <h2 class="section-title">Top Brands</h2>
                <p class="section-subtitle">Official products from brands you know</p>
            </div>
            <a href="{{ route('brands.index') }}" class="link-arrow d-none d-md-inline-flex">
                All brands <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row row-cols-2 row-cols-sm-4 row-cols-lg-8 g-3">
            @foreach($brands as $brand)
            <div class="col">
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="brand-logo-card d-block">
                    @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" height="30" style="object-fit:contain;">
                    @else
                        {{ $brand->name }}
                    @endif
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BEST SELLERS --}}
@if($best_sellers->count())
<section class="section-block">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Most loved</div>
                <h2 class="section-title">Best Sellers</h2>
                <p class="section-subtitle">Most popular products this week</p>
            </div>
            <a href="{{ route('best-sellers') }}" class="link-arrow d-none d-md-inline-flex">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4">
            @foreach($best_sellers as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- NEWSLETTER --}}
<section class="section-block tight pb-5">
    <div class="container">
        <div class="newsletter-panel text-center">
            <div class="position-relative">
                <div class="eyebrow justify-content-center">Newsletter</div>
                <h3>Get exclusive deals in your inbox</h3>
                <p class="mx-auto mb-4" style="max-width:34rem;">
                    Join thousands of shoppers and be the first to know about new arrivals,
                    flash sales and limited-time offers.
                </p>
                <form method="POST" action="{{ route('newsletter.store') }}" class="newsletter-form mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email address" required>
                    <button type="submit" class="btn btn-primary">
                        Subscribe <i class="bi bi-send ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
