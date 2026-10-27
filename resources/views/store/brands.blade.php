@extends('layouts.app')
@section('title', 'All Brands — ShopZone')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">All Brands</h2>
        <p class="text-muted">Discover products from your favourite brands</p>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($brands as $brand)
        <div class="col">
            <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
               class="text-decoration-none">
                <div class="bg-white rounded-3 border p-4 text-center h-100 brand-logo-card"
                     style="transition:all .25s;cursor:pointer;">
                    @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}"
                            height="60" class="mb-3" style="object-fit:contain;">
                    @else
                        <div class="fw-bold fs-4 text-primary mb-2">{{ $brand->name }}</div>
                    @endif
                    <div class="fw-semibold text-dark">{{ $brand->name }}</div>
                    <div class="text-muted" style="font-size:12px;">
                        {{ $brand->products_count }} Products
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">No brands found.</div>
        @endforelse
    </div>
</div>
@endsection