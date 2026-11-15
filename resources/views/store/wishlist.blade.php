@extends('layouts.app')
@section('title', 'Wishlist — ShopZone')

@section('content')
<div class="container py-4">
    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Wishlist</li>
            </ol>
        </nav>
        <h1 class="page-title"><i class="bi bi-heart me-2"></i>My Wishlist</h1>
        <p class="page-sub">{{ $items->count() }} saved {{ Str::plural('product', $items->count()) }}</p>
    </div>

    @if($items->count())
    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-3 g-lg-4">
        @foreach($items as $item)
        <div class="col" id="wish-row-{{ $item->id }}">
            <x-product-card :product="$item->product" />
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="icon"><i class="bi bi-heart"></i></div>
        <h4>Your wishlist is empty</h4>
        <p>Save products you love and find them here later.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5 mt-1">Browse Products</a>
    </div>
    @endif
</div>
@endsection
