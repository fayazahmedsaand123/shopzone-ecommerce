@extends('layouts.app')
@section('title', 'About Us — ShopZone')

@section('content')
<div class="container py-5">

    {{-- Hero --}}
    <div class="row align-items-center mb-5 g-4">
        <div class="col-lg-6">
            <div class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">About ShopZone</div>
            <h2 class="fw-bold display-6">Pakistan's Most Trusted Online Shopping Destination</h2>
            <p class="text-muted mt-3" style="font-size:15px;line-height:1.8;">
                ShopZone was founded with a simple mission — to make quality products accessible
                to everyone across Pakistan at fair prices, with fast and reliable delivery.
            </p>
            <p class="text-muted" style="font-size:15px;line-height:1.8;">
                From electronics to fashion, home essentials to sports equipment, we bring
                you thousands of products from trusted brands, all in one place.
            </p>
            <a href="{{ route('products.index') }}" class="btn btn-primary px-5 mt-2">
                <i class="bi bi-bag me-2"></i>Shop Now
            </a>
        </div>
        <div class="col-lg-6">
            <div class="row g-3">
                <div class="col-6">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-4 text-center">
                        <div class="fw-bold fs-1 text-primary">10K+</div>
                        <div class="text-muted" style="font-size:13px;">Products</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-success bg-opacity-10 rounded-3 p-4 text-center">
                        <div class="fw-bold fs-1 text-success">50K+</div>
                        <div class="text-muted" style="font-size:13px;">Happy Customers</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-4 text-center">
                        <div class="fw-bold fs-1 text-warning">100+</div>
                        <div class="text-muted" style="font-size:13px;">Brands</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-4 text-center">
                        <div class="fw-bold fs-1 text-danger">5★</div>
                        <div class="text-muted" style="font-size:13px;">Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Values --}}
    <div class="row g-4 mb-5">
        <div class="col-12 text-center mb-2">
            <h3 class="fw-bold">Why Choose ShopZone?</h3>
        </div>
        @foreach([
            ['bi-shield-check','text-primary','100% Genuine Products','We only sell authentic products from verified suppliers and official brand distributors.'],
            ['bi-truck','text-success','Fast Delivery','We deliver across Pakistan within 2-5 business days with real-time order tracking.'],
            ['bi-headset','text-warning','24/7 Customer Support','Our support team is always available to help you with any questions or issues.'],
            ['bi-arrow-repeat','text-danger','Easy Returns','Not satisfied? Return within 7 days for a full refund, no questions asked.'],
        ] as $val)
        <div class="col-md-6 col-lg-3">
            <div class="bg-white rounded-3 border p-4 text-center h-100">
                <i class="bi {{ $val[0] }} {{ $val[1] }}" style="font-size:40px;"></i>
                <h6 class="fw-bold mt-3 mb-2">{{ $val[2] }}</h6>
                <p class="text-muted mb-0" style="font-size:13px;">{{ $val[3] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection