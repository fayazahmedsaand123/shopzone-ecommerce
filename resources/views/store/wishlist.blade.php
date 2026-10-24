@extends('layouts.app')
@section('title', 'Wishlist — ShopZone')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-heart me-2"></i>My Wishlist</h4>

    @if($items->count())
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach($items as $item)
        <div class="col" id="wish-row-{{ $item->id }}">
            <x-product-card :product="$item->product" />
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5 bg-white rounded-3 border">
        <i class="bi bi-heart" style="font-size:64px;color:#ddd;"></i>
        <h4 class="mt-3 text-muted">Your wishlist is empty</h4>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-5">Browse Products</a>
    </div>
    @endif
</div>
@endsection