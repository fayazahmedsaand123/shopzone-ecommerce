@extends('layouts.app')
@section('title', $product->name . ' — ShopZone')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            @if($product->category)
            <li class="breadcrumb-item">
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            </li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
        </ol>
    </nav>

    @php
        $avg = round($product->average_rating, 1);
        $disc = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
    @endphp

    {{-- Product Main Section --}}
    <div class="row g-4 mb-5">

        {{-- Images --}}
        <div class="col-lg-5">
            <div class="panel panel-pad">
                <div class="gallery-main mb-3">
                    <img id="main-product-img"
                        src="{{ $product->image_url }}"
                        alt="{{ $product->name }}"
                        onclick="openLightbox(this.src)">
                </div>

                {{-- Gallery Thumbnails --}}
                <div class="d-flex gap-2 flex-wrap">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="thumb-img active" onclick="switchImage(this)">
                    @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->image) }}"
                        alt="{{ $product->name }}"
                        class="thumb-img" onclick="switchImage(this)">
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-7">
            <div class="panel panel-pad h-100">

                {{-- Category & Brand --}}
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    @if($product->category)
                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                    @endif
                    @if($product->brand)
                    <span class="badge bg-secondary">{{ $product->brand->name }}</span>
                    @endif
                    @if($product->is_featured)
                    <span class="badge bg-warning">Featured</span>
                    @endif
                </div>

                <h1 class="mb-2" style="font-size:clamp(1.5rem,2.6vw,2rem);font-weight:800;">{{ $product->name }}</h1>

                {{-- Rating Summary --}}
                <div class="d-flex align-items-center gap-2 mb-4 flex-wrap" style="font-size:.8rem;">
                    <div class="d-inline-flex align-items-center" style="gap:2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $avg ? '-fill' : '' }}"
                               style="color:{{ $i <= $avg ? 'var(--accent)' : 'rgba(255,255,255,.16)' }};"></i>
                        @endfor
                    </div>
                    <span class="text-muted">{{ number_format($avg, 1) }}/5 ({{ $product->reviews->count() }} reviews)</span>
                    <span class="text-muted">·</span>
                    <span class="text-muted">SKU: {{ $product->sku }}</span>
                </div>

                {{-- Price --}}
                <div class="d-flex align-items-end gap-3 mb-4 pb-4" style="border-bottom:1px solid var(--line);">
                    @if($product->sale_price)
                        <span class="detail-price">PKR {{ number_format($product->sale_price) }}</span>
                        <span class="detail-old">PKR {{ number_format($product->price) }}</span>
                        <span class="badge bg-danger">-{{ $disc }}% OFF</span>
                    @else
                        <span class="detail-price">PKR {{ number_format($product->price) }}</span>
                    @endif
                </div>

                {{-- Short Description --}}
                @if($product->short_description)
                <p class="text-muted mb-3" style="font-size:.88rem;line-height:1.75;">{{ $product->short_description }}</p>
                @endif

                {{-- Stock Status --}}
                <div class="mb-3" style="font-size:.84rem;">
                    @if($product->stock_quantity > 0)
                        <span class="text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            In stock — {{ $product->stock_quantity }} available
                        </span>
                    @else
                        <span class="text-danger fw-semibold">
                            <i class="bi bi-x-circle-fill me-1"></i>Out of stock
                        </span>
                    @endif
                </div>

                {{-- Quantity + Add to Cart --}}
                @if($product->stock_quantity > 0)
                <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                    <div class="qty-stepper">
                        <button type="button" id="qty-minus" aria-label="Decrease quantity">−</button>
                        <span class="value" id="detail-qty">1</span>
                        <button type="button" id="qty-plus" data-max="{{ $product->stock_quantity }}" aria-label="Increase quantity">+</button>
                    </div>
                    <button class="btn btn-primary btn-lg flex-grow-1" style="min-width:200px;"
                        id="detail-add-cart" data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                    </button>
                </div>
                @endif

                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-outline-danger wishlist-btn flex-grow-1" id="detail-wishlist"
                        data-product-id="{{ $product->id }}">
                        <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                        <span class="wishlist-label">{{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}</span>
                    </button>
                </div>

                {{-- Trust notes --}}
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="pay-chip"><i class="bi bi-truck"></i>Free delivery over PKR 5,000</span>
                    <span class="pay-chip"><i class="bi bi-arrow-repeat"></i>7-day returns</span>
                    <span class="pay-chip"><i class="bi bi-shield-check"></i>Secure checkout</span>
                </div>

                {{-- Product Details --}}
                <div style="border-top:1px solid var(--line);padding-top:1.2rem;">
                    <div class="meta-grid">
                        @if($product->brand)
                        <div><span class="k">Brand</span><span class="v">{{ $product->brand->name }}</span></div>
                        @endif
                        @if($product->category)
                        <div><span class="k">Category</span><span class="v">{{ $product->category->name }}</span></div>
                        @endif
                        @if($product->weight)
                        <div><span class="k">Weight</span><span class="v">{{ $product->weight }} kg</span></div>
                        @endif
                        @if($product->dimensions)
                        <div><span class="k">Dimensions</span><span class="v">{{ $product->dimensions }}</span></div>
                        @endif
                        <div><span class="k">Views</span><span class="v">{{ number_format($product->views_count) }}</span></div>
                        <div><span class="k">Availability</span><span class="v">{{ $product->stock_quantity > 0 ? 'In stock' : 'Out of stock' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Description & Reviews Tabs --}}
    <div class="panel mb-5">
        <ul class="nav nav-tabs px-3 pt-2">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                    Reviews ({{ $product->reviews->count() }})
                </a>
            </li>
        </ul>

        <div class="tab-content p-4">
            {{-- Description --}}
            <div class="tab-pane fade show active" id="description">
                @if($product->description)
                    <div style="font-size:.9rem;line-height:1.85;color:var(--muted);">{{ $product->description }}</div>
                @else
                    <p class="text-muted mb-0">No description available.</p>
                @endif
            </div>

            {{-- Reviews --}}
            <div class="tab-pane fade" id="reviews">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="rating-summary">
                            <div class="big">{{ number_format($avg, 1) }}</div>
                            <div class="my-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $avg ? '-fill' : '' }}"
                                       style="color:{{ $i <= $avg ? 'var(--accent)' : 'rgba(255,255,255,.16)' }};"></i>
                                @endfor
                            </div>
                            <div class="text-muted" style="font-size:.78rem;">{{ $product->reviews->count() }} reviews</div>
                        </div>

                        {{-- Write Review --}}
                        @auth
                        <div class="panel-soft p-3 mt-3">
                            <h6 class="fw-bold mb-3">Write a Review</h6>
                            <div class="mb-2">
                                <label class="form-label">Rating *</label>
                                <div class="star-rating" id="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star fs-4 text-muted" data-rating="{{ $i }}"
                                            style="cursor:pointer;" id="star-{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" id="rating-value" value="0">
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm" id="review-title" placeholder="Review title">
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control form-control-sm" id="review-comment" rows="3" placeholder="Your review..."></textarea>
                            </div>
                            <button class="btn btn-primary btn-sm w-100" id="submit-review"
                                data-url="{{ route('products.review', $product->slug) }}">
                                Submit Review
                            </button>
                            <div id="review-result" class="mt-2"></div>
                        </div>
                        @else
                        <div class="panel-soft p-3 mt-3 text-center">
                            <p class="text-muted mb-2" style="font-size:.82rem;">Share your experience with this product</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                Login to Write a Review
                            </a>
                        </div>
                        @endauth
                    </div>

                    <div class="col-lg-8">
                        @forelse($product->reviews as $review)
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $review->user->name }}</div>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"
                                               style="font-size:.78rem;color:{{ $i <= $review->rating ? 'var(--accent)' : 'rgba(255,255,255,.16)' }};"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-muted" style="font-size:.72rem;">
                                    {{ $review->created_at->format('d M Y') }}
                                </div>
                            </div>
                            @if($review->title)
                            <div class="fw-semibold mt-2" style="font-size:.88rem;">{{ $review->title }}</div>
                            @endif
                            @if($review->comment)
                            <p class="text-muted mt-1 mb-0" style="font-size:.84rem;line-height:1.7;">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @empty
                        <div class="empty-state" style="padding:40px 20px;">
                            <div class="icon" style="width:60px;height:60px;font-size:1.5rem;"><i class="bi bi-chat-square-text"></i></div>
                            <h4 style="font-size:1rem;">No reviews yet</h4>
                            <p class="mb-0" style="font-size:.84rem;">Be the first to review this product.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mb-4">
        <div class="section-head">
            <div>
                <div class="eyebrow">You may also like</div>
                <h2 class="section-title">Related Products</h2>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-md-4 g-3 g-lg-4">
            @foreach($related as $rp)
            <div class="col">
                <x-product-card :product="$rp" />
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;cursor:zoom-out;align-items:center;justify-content:center;">
    <img id="lightbox-img" style="max-width:90%;max-height:90vh;border-radius:12px;object-fit:contain;">
</div>
@endsection

@push('scripts')
<script>
// Image switcher
function switchImage(el) {
    document.getElementById('main-product-img').src = el.src;
    document.querySelectorAll('.thumb-img').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// Lightbox
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}

// Quantity control
let qty = 1;
const maxQty = {{ $product->stock_quantity }};

$('#qty-minus').on('click', function() {
    if (qty > 1) { qty--; $('#detail-qty').text(qty); }
});
$('#qty-plus').on('click', function() {
    if (qty < maxQty) { qty++; $('#detail-qty').text(qty); }
    else showToast('Max stock reached.', 'error');
});

// Add to cart from detail page
$('#detail-add-cart').on('click', function() {
    const productId = $(this).data('product-id');
    const btn = $(this);

    @auth
    btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Adding...');
    $.ajax({
        url: '{{ route("customer.cart.add") }}',
        method: 'POST',
        data: { product_id: productId, quantity: qty },
        dataType: 'json',
        headers: { 'Accept': 'application/json' }
    }).done(function(res) {
        if (!res || !res.success) {
            showToast((res && res.message) || 'Could not add to cart.', 'error');
            btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-2"></i>Add to Cart');
            return;
        }

        $('#cart-count').text(res.cart_count);
        showToast(res.message);
        btn.html('<i class="bi bi-check-lg me-1"></i>Added to Cart!');
        setTimeout(() => {
            btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-2"></i>Add to Cart');
        }, 2000);
    }).fail(function(xhr) {
        btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-2"></i>Add to Cart');
        handleAccountFailure(xhr, 'Could not add to cart. Please try again.');
    });
    @else
    showToast('Please login first.', 'error');
    setTimeout(() => window.location.href = '{{ route("login") }}', 1000);
    @endauth
});

// Star rating
$('#star-rating i').on('click', function() {
    const r = $(this).data('rating');
    $('#rating-value').val(r);
    for (let i = 1; i <= 5; i++) {
        const star = $('#star-' + i);
        star.removeClass('bi-star bi-star-fill text-warning text-muted');
        if (i <= r) {
            star.addClass('bi-star-fill text-warning');
        } else {
            star.addClass('bi-star text-muted');
        }
    }
}).on('mouseenter', function() {
    const r = $(this).data('rating');
    for (let i = 1; i <= r; i++) {
        $('#star-' + i).removeClass('bi-star text-muted').addClass('bi-star-fill text-warning');
    }
}).on('mouseleave', function() {
    const current = parseInt($('#rating-value').val());
    for (let i = 1; i <= 5; i++) {
        const star = $('#star-' + i);
        star.removeClass('bi-star bi-star-fill text-warning text-muted');
        if (i <= current) {
            star.addClass('bi-star-fill text-warning');
        } else {
            star.addClass('bi-star text-muted');
        }
    }
});

// Submit review
$('#submit-review').on('click', function() {
    const rating = $('#rating-value').val();
    if (!rating || rating == 0) { showToast('Please select a rating.', 'error'); return; }

    const btn = $(this);
    btn.prop('disabled', true).text('Submitting...');

    $.post($(this).data('url'), {
        rating:  rating,
        title:   $('#review-title').val(),
        comment: $('#review-comment').val(),
    }, function(res) {
        if (res.success) {
            showToast(res.message);
            $('#review-result').html('<div class="alert alert-success py-2 mb-0">' + res.message + '</div>');
            $('#review-title, #review-comment').val('');
            $('#rating-value').val(0);
            $('[id^=star-]').removeClass('bi-star-fill text-warning').addClass('bi-star text-muted');
        } else {
            showToast(res.message, 'error');
        }
    }).always(function() {
        btn.prop('disabled', false).text('Submit Review');
    });
});
</script>
@endpush
