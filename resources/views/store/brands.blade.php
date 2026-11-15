@extends('layouts.app')
@section('title', 'All Brands — ShopZone')

@section('content')
<div class="container">
    <div class="page-head text-center">
        <span class="eyebrow"><i class="bi bi-award"></i>Brands</span>
        <h1 class="page-title mt-2">All brands</h1>
        <p class="text-muted mb-0">Discover products from your favourite brands.</p>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 pb-5">
        @forelse($brands as $brand)
        <div class="col">
            <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="brand-logo-card">
                @if($brand->logo)
                    <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" height="54" class="mb-3" style="object-fit:contain;">
                    <div class="fw-semibold">{{ $brand->name }}</div>
                @else
                    <div class="fs-4 fw-bold text-primary mb-1">{{ $brand->name }}</div>
                @endif
                <div class="text-muted small">{{ $brand->products_count }} products</div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="icon"><i class="bi bi-award"></i></div>
                <h4>No brands yet</h4>
                <p>Brands will appear here as soon as products are added.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
