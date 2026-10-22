@extends('layouts.app')
@section('title', 'All Products — ShopZone')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                @if(request('search'))
                    Search: "{{ request('search') }}"
                @elseif(request('category'))
                    {{ ucfirst(request('category')) }}
                @else
                    All Products
                @endif
            </h4>
            <small class="text-muted">{{ $products->total() }} products found</small>
        </div>
        {{-- Sort --}}
        <div class="d-flex align-items-center gap-2">
            <label class="text-muted" style="font-size:13px;white-space:nowrap;">Sort by:</label>
            <select class="form-select form-select-sm" style="width:180px;" id="sort-select">
                <option value="newest"     {{ request('sort','newest') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                <option value="price_asc"  {{ request('sort') == 'price_asc'           ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') == 'price_desc'          ? 'selected' : '' }}>Price: High to Low</option>
                <option value="popular"    {{ request('sort') == 'popular'             ? 'selected' : '' }}>Most Popular</option>
            </select>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Sidebar Filters ── --}}
        <div class="col-lg-3">
            <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort"   value="{{ request('sort', 'newest') }}">

                {{-- Categories --}}
                <div class="bg-white rounded-3 border p-3 mb-3">
                    <h6 class="fw-bold mb-3">Categories</h6>
                    @foreach($categories as $cat)
                    <div class="form-check mb-1">
                        <input class="form-check-input filter-input" type="radio"
                            name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}"
                            {{ request('category') == $cat->slug ? 'checked' : '' }}>
                        <label class="form-check-label d-flex justify-content-between" for="cat-{{ $cat->id }}" style="font-size:13px;">
                            {{ $cat->name }}
                            <span class="badge bg-light text-muted">{{ $cat->products_count }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>

                {{-- Brands --}}
                <div class="bg-white rounded-3 border p-3 mb-3">
                    <h6 class="fw-bold mb-3">Brands</h6>
                    @foreach($brands as $brand)
                    <div class="form-check mb-1">
                        <input class="form-check-input filter-input" type="radio"
                            name="brand" value="{{ $brand->slug }}" id="brand-{{ $brand->id }}"
                            {{ request('brand') == $brand->slug ? 'checked' : '' }}>
                        <label class="form-check-label" for="brand-{{ $brand->id }}" style="font-size:13px;">
                            {{ $brand->name }}
                        </label>
                    </div>
                    @endforeach
                </div>

                {{-- Price Range --}}
                <div class="bg-white rounded-3 border p-3 mb-3">
                    <h6 class="fw-bold mb-3">Price Range (PKR)</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" name="min_price" class="form-control form-control-sm filter-input"
                                placeholder="Min" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-6">
                            <input type="number" name="max_price" class="form-control form-control-sm filter-input"
                                placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>
                </div>

                {{-- Availability --}}
                <div class="bg-white rounded-3 border p-3 mb-3">
                    <h6 class="fw-bold mb-3">Availability</h6>
                    <div class="form-check">
                        <input class="form-check-input filter-input" type="checkbox"
                            name="in_stock" value="1" id="in-stock"
                            {{ request('in_stock') ? 'checked' : '' }}>
                        <label class="form-check-label" for="in-stock" style="font-size:13px;">
                            In Stock Only
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Clear All</a>
                </div>
            </form>
        </div>

        {{-- ── Products Grid ── --}}
        <div class="col-lg-9">
            @if($products->count())
                <div class="row row-cols-2 row-cols-md-3 g-3" id="products-grid">
                    @foreach($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5 bg-white rounded-3 border">
                    <i class="bi bi-search" style="font-size:48px;color:#ddd;"></i>
                    <h5 class="mt-3 text-muted">No products found</h5>
                    <p class="text-muted">Try different filters or search terms.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-submit on sort change
$('#sort-select').on('change', function() {
    $('input[name="sort"]').val($(this).val());
    $('#filter-form').submit();
});
</script>
@endpush