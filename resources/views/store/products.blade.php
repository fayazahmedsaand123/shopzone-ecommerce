@extends('layouts.app')
@section('title', ($pageTitle ?? 'All Products') . ' — ShopZone')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $pageTitle ?? 'Products' }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h1 class="page-title">
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ $categories->firstWhere('slug', request('category'))->name ?? ucfirst(request('category')) }}
                    @else
                        {{ $pageTitle ?? 'All Products' }}
                    @endif
                </h1>
                <p class="page-sub d-flex align-items-center gap-2">
                    <span class="count-pill"><i class="bi bi-box-seam"></i>{{ $products->total() }} products</span>
                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="filter-reset">Clear search</a>
                    @endif
                </p>
            </div>
            {{-- Sort --}}
            <div class="d-flex align-items-center gap-2">
                <label class="text-muted mb-0" style="font-size:.78rem;white-space:nowrap;">Sort by</label>
                <select class="form-select form-select-sm" style="width:190px;" id="sort-select">
                    <option value="newest"     {{ request('sort','newest') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'           ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc'          ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular"    {{ request('sort') == 'popular'             ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Sidebar Filters --}}
        <div class="col-lg-3">
            <button class="btn btn-outline-secondary w-100 d-lg-none mb-3" type="button"
                data-bs-toggle="collapse" data-bs-target="#filtersPanel">
                <i class="bi bi-sliders me-1"></i>Filters & Sort
            </button>

            <div class="collapse d-lg-block" id="filtersPanel">
                <div class="panel mb-3">
                    <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="sort"   value="{{ request('sort', 'newest') }}">

                        <div class="d-flex justify-content-between align-items-center filter-block">
                            <span class="filter-title mb-0">Filters</span>
                            <a href="{{ route('products.index') }}" class="filter-reset">Reset</a>
                        </div>

                        {{-- Categories --}}
                        <div class="filter-block">
                            <div class="filter-title">Categories</div>
                            <div style="max-height:230px;overflow-y:auto;">
                                @foreach($categories as $cat)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="radio"
                                        name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}"
                                        {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex justify-content-between" for="cat-{{ $cat->id }}">
                                        {{ $cat->name }}
                                        <span class="filter-count">{{ $cat->products_count }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Brands --}}
                        <div class="filter-block">
                            <div class="filter-title">Brands</div>
                            <div style="max-height:230px;overflow-y:auto;">
                                @foreach($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="radio"
                                        name="brand" value="{{ $brand->slug }}" id="brand-{{ $brand->id }}"
                                        {{ request('brand') == $brand->slug ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brand-{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="filter-block">
                            <div class="filter-title">Price Range (PKR)</div>
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
                        <div class="filter-block">
                            <div class="filter-title">Availability</div>
                            <div class="form-check">
                                <input class="form-check-input filter-input" type="checkbox"
                                    name="in_stock" value="1" id="in-stock"
                                    {{ request('in_stock') ? 'checked' : '' }}>
                                <label class="form-check-label" for="in-stock">
                                    In stock only
                                </label>
                            </div>
                        </div>

                        <div class="filter-block">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Clear All</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="col-lg-9">
            @if($products->count())
                <div class="row row-cols-2 row-cols-md-3 g-3 g-lg-4" id="products-grid">
                    @foreach($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="icon"><i class="bi bi-search"></i></div>
                    <h4>No products found</h4>
                    <p>Try different filters or search terms.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">View All Products</a>
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
