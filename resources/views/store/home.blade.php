@extends('layouts.app')
@section('title', 'ShopZone — Pakistan\'s #1 Online Store')

@section('content')

{{-- ── HERO BANNER ──────────────────────────── --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-6 py-5">
                <div class="hero-badge"><i class="bi bi-lightning-fill me-1"></i>New Arrivals 2026</div>
                <h1 class="hero-title">
                    Shop the <span>Best Deals</span><br>in Pakistan
                </h1>
                <p class="hero-subtitle">
                    Discover thousands of products at unbeatable prices.<br>
                    Fast delivery across Pakistan.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#featured" class="btn btn-lg px-5 fw-bold" style="background:var(--accent);color:#fff;border-radius:50px;">
                        <i class="bi bi-bag-fill me-2"></i>Shop Now
                    </a>
                    <a href="#categories" class="btn btn-lg btn-outline-light px-5" style="border-radius:50px;">
                        Browse Categories
                    </a>
                </div>
                <div class="d-flex gap-4 mt-4">
                    <div class="text-white">
                        <div class="fw-bold fs-5">10K+</div>
                        <div style="font-size:12px;opacity:.7;">Products</div>
                    </div>
                    <div class="text-white">
                        <div class="fw-bold fs-5">50K+</div>
                        <div style="font-size:12px;opacity:.7;">Customers</div>
                    </div>
                    <div class="text-white">
                        <div class="fw-bold fs-5">100%</div>
                        <div style="font-size:12px;opacity:.7;">Secure</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="https://placehold.co/500x380/1a1a2e/ff6b35?text=ShopZone+Deals"
                     alt="Hero" class="hero-img img-fluid">
            </div>
        </div>
    </div>
</section>

{{-- ── TRUST BAR ────────────────────────────── --}}
<div style="background:#fff;border-bottom:1px solid #e9ecef;">
    <div class="container">
        <div class="row text-center py-3">
            <div class="col-6 col-md-3 border-end">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-truck fs-4 text-primary"></i>
                    <div class="text-start">
                        <div style="font-size:13px;font-weight:700;">Free Shipping</div>
                        <div style="font-size:11px;color:#999;">Orders over PKR 5,000</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 border-end">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-arrow-repeat fs-4 text-success"></i>
                    <div class="text-start">
                        <div style="font-size:13px;font-weight:700;">Easy Returns</div>
                        <div style="font-size:11px;color:#999;">7 day return policy</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 border-end">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-shield-check fs-4 text-warning"></i>
                    <div class="text-start">
                        <div style="font-size:13px;font-weight:700;">Secure Payment</div>
                        <div style="font-size:11px;color:#999;">100% protected</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-headset fs-4 text-danger"></i>
                    <div class="text-start">
                        <div style="font-size:13px;font-weight:700;">24/7 Support</div>
                        <div style="font-size:11px;color:#999;">Always here for you</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── CATEGORIES ───────────────────────────── --}}
<section class="py-5" id="categories" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end">
            <div>
                <h2 class="section-title">Shop by Category</h2>
                <p class="section-subtitle">Find exactly what you're looking for</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm d-none d-md-block">View All</a>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-8 g-3">
            @php
            $icons = ['bi-laptop','bi-phone','bi-bag','bi-house','bi-bicycle','bi-book','bi-controller','bi-heart-pulse'];
            @endphp
            @forelse($categories as $i => $category)
            <div class="col">
                <a href="#" class="category-card">
                    <div class="category-icon-wrap">
                        <i class="bi {{ $icons[$i % count($icons)] }}"></i>
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

{{-- ── FEATURED PRODUCTS ────────────────────── --}}
@if($featured_products->count())
<section class="py-5" id="featured">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end">
            <div>
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Handpicked by our team for you</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm d-none d-md-block">View All</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($featured_products as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── PROMO BANNERS ────────────────────────── --}}
<section class="py-4" style="background:#f8f9fa;">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="promo-banner" style="background:linear-gradient(135deg,#0d6efd,#0a58ca);">
                    <div>
                        <div class="text-white opacity-75 mb-1" style="font-size:13px;">Limited Time</div>
                        <h4 class="text-white">Up to 30% OFF<br>Electronics</h4>
                        <a href="#" class="btn btn-light btn-sm mt-2 fw-bold">Shop Now <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <i class="bi bi-laptop position-absolute" style="font-size:100px;right:20px;bottom:-10px;opacity:.15;color:#fff;"></i>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-banner" style="background:linear-gradient(135deg,#ff6b35,#e55527);">
                    <div>
                        <div class="text-white opacity-75 mb-1" style="font-size:13px;">New Arrivals</div>
                        <h4 class="text-white">Fresh Fashion<br>Collection 2026</h4>
                        <a href="#" class="btn btn-light btn-sm mt-2 fw-bold">Explore <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <i class="bi bi-bag position-absolute" style="font-size:100px;right:20px;bottom:-10px;opacity:.15;color:#fff;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── NEW ARRIVALS ──────────────────────────── --}}
@if($new_arrivals->count())
<section class="py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end">
            <div>
                <h2 class="section-title">New Arrivals</h2>
                <p class="section-subtitle">Just landed — fresh products every week</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm d-none d-md-block">View All</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($new_arrivals as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── BRANDS ───────────────────────────────── --}}
@if($brands->count())
<section class="py-5" style="background:#f8f9fa;">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="section-title d-inline-block">Top Brands</h2>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-8 g-3">
            @foreach($brands as $brand)
            <div class="col">
                <div class="brand-logo-card">
                    @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" height="36" style="object-fit:contain;">
                    @else
                        {{ $brand->name }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── BEST SELLERS ──────────────────────────── --}}
@if($best_sellers->count())
<section class="py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end">
            <div>
                <h2 class="section-title">Best Sellers</h2>
                <p class="section-subtitle">Most popular products this week</p>
            </div>
            <a href="#" class="btn btn-outline-primary btn-sm d-none d-md-block">View All</a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($best_sellers as $product)
            <div class="col">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── NEWSLETTER ───────────────────────────── --}}
<section class="py-5" style="background:linear-gradient(135deg,#1a1a2e,#0d6efd);">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-envelope-heart fs-1 text-white mb-3 d-block"></i>
                <h3 class="text-white fw-bold">Subscribe for Exclusive Deals</h3>
                <p class="text-white opacity-75 mb-4">Get notified about the best offers and new arrivals directly in your inbox.</p>
                <div class="input-group input-group-lg" style="border-radius:50px;overflow:hidden;">
                    <input type="email" class="form-control border-0" placeholder="Enter your email address">
                    <button class="btn px-4 fw-bold" style="background:var(--accent);color:#fff;">
                        Subscribe <i class="bi bi-send ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection