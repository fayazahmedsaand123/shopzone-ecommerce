@extends('layouts.app')
@section('title', 'About Us — ShopZone')

@section('content')
<div class="container">
    <div class="about-hero row align-items-center g-5">
        <div class="col-lg-6">
            <span class="eyebrow"><i class="bi bi-stars"></i>About ShopZone</span>
            <h1 class="section-title mt-3">Pakistan's most trusted online shopping destination</h1>
            <p class="about-lead mt-3">
                We started ShopZone with one simple goal — make quality products accessible to everyone
                across Pakistan at fair prices, backed by fast and reliable delivery.
            </p>
            <p class="text-muted">
                From electronics to fashion, home essentials to sports equipment, we bring you
                hundreds of products from trusted brands, all in one place.
            </p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-bag me-2"></i>Shop Now
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Talk to us</a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row g-3">
                <div class="col-6"><div class="stat-card"><div class="num">10K+</div><div class="lbl">Products</div></div></div>
                <div class="col-6"><div class="stat-card"><div class="num">50K+</div><div class="lbl">Happy customers</div></div></div>
                <div class="col-6"><div class="stat-card"><div class="num">100+</div><div class="lbl">Brands</div></div></div>
                <div class="col-6"><div class="stat-card"><div class="num">4.8</div><div class="lbl">Average rating</div></div></div>
            </div>
        </div>
    </div>

    <div class="section-block">
        <div class="section-head">
            <div>
                <span class="eyebrow"><i class="bi bi-patch-check"></i>Our promise</span>
                <h2 class="section-title">Why shop with us</h2>
            </div>
        </div>
        <div class="row g-3">
            @foreach([
                ['bi-shield-check','100% genuine products','We only sell authentic items sourced from verified suppliers and official brand distributors.'],
                ['bi-truck','Fast nationwide delivery','Orders reach you within 2–5 business days, with real-time tracking on every shipment.'],
                ['bi-headset','Support that cares','Our team is available six days a week to help with orders, returns and product questions.'],
                ['bi-arrow-repeat','Easy 7-day returns','Not happy with an item? Return it within 7 days for a refund, no complicated forms.'],
            ] as $value)
                <div class="col-md-6 col-xl-3">
                    <div class="value-card">
                        <div class="icon"><i class="bi {{ $value[0] }}"></i></div>
                        <h3 class="h6 fw-bold mb-2">{{ $value[1] }}</h3>
                        <p class="text-muted mb-0 small">{{ $value[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel panel-pad my-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="eyebrow"><i class="bi bi-geo-alt"></i>Made in Pakistan</span>
                <h2 class="section-title mt-2">Built by a small team in Hyderabad</h2>
                <p class="text-muted mb-0">
                    ShopZone is run by a dedicated team that handles everything from product sourcing
                    to packing and customer care. Every order is checked by hand before it leaves our warehouse.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('faq') }}" class="btn btn-outline-light text-start">
                        <i class="bi bi-question-circle me-2"></i>Read our FAQ
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light text-start">
                        <i class="bi bi-envelope me-2"></i>Contact the team
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
