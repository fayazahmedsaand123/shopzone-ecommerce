@extends('layouts.app')
@section('title', $product->name . ' — ShopZone')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:13px;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            @if($product->category)
            <li class="breadcrumb-item">{{ $product->category->name }}</li>
            @endif
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
        </ol>
    </nav>

    {{-- Product Main Section --}}
    <div class="row g-4 mb-5">

        {{-- Images --}}
        <div class="col-lg-5">
            <div class="bg-white rounded-3 border p-3">
                <div class="mb-3" style="aspect-ratio:1;overflow:hidden;border-radius:10px;background:#f8f9fa;">
                    <img id="main-product-img"
                        src="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80' }}"
                        alt="{{ $product->name }}"
                        style="width:100%;height:100%;object-fit:cover;cursor:zoom-in;"
                        onclick="openLightbox(this.src)">
                </div>

                {{-- Gallery Thumbnails --}}
                @if($product->images->count())
                <div class="d-flex gap-2 flex-wrap">
                    <img src="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=80' }}"
                        class="thumb-img active" onclick="switchImage(this)"
                        style="width:60px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid var(--primary);">
                    @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->image) }}"
                        class="thumb-img" onclick="switchImage(this)"
                        style="width:60px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid transparent;">
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-7">
            <div class="bg-white rounded-3 border p-4">

                {{-- Category & Brand --}}
                <div class="d-flex gap-2 mb-2">
                    @if($product->category)
                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $product->category->name }}</span>
                    @endif
                    @if($product->brand)
                    <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $product->brand->name }}</span>
                    @endif
                    @if($product->is_featured)
                    <span class="badge bg-warning text-dark">Featured</span>
                    @endif
                </div>

                <h2 class="fw-bold mb-2" style="font-size:24px;">{{ $product->name }}</h2>

                {{-- Rating Summary --}}
                <div class="d-flex align-items-center gap-2 mb-3">
                    @php $avg = round($product->average_rating, 1); @endphp
                    <div>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $avg ? '-fill text-warning' : ' text-muted' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted" style="font-size:13px;">
                        {{ $avg }}/5 ({{ $product->reviews->count() }} reviews)
                    </span>
                    <span class="text-muted" style="font-size:13px;">| SKU: {{ $product->sku }}</span>
                </div>

                {{-- Price --}}
                <div class="mb-3 pb-3 border-bottom">
                    @if($product->sale_price)
                        <span style="font-size:32px;font-weight:900;color:var(--accent);">
                            PKR {{ number_format($product->sale_price) }}
                        </span>
                        <span class="text-muted ms-2" style="font-size:18px;text-decoration:line-through;">
                            PKR {{ number_format($product->price) }}
                        </span>
                        @php $disc = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                        <span class="badge bg-danger ms-2">-{{ $disc }}% OFF</span>
                    @else
                        <span style="font-size:32px;font-weight:900;color:var(--accent);">
                            PKR {{ number_format($product->price) }}
                        </span>
                    @endif
                </div>

                {{-- Short Description --}}
                @if($product->short_description)
                <p class="text-muted mb-3" style="font-size:14px;">{{ $product->short_description }}</p>
                @endif

                {{-- Stock Status --}}
                <div class="mb-3">
                    @if($product->stock_quantity > 0)
                        <span class="text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            In Stock ({{ $product->stock_quantity }} available)
                        </span>
                    @else
                        <span class="text-danger fw-semibold">
                            <i class="bi bi-x-circle-fill me-1"></i>Out of Stock
                        </span>
                    @endif
                </div>

                {{-- Quantity + Add to Cart --}}
                @if($product->stock_quantity > 0)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="d-flex align-items-center border rounded-3 overflow-hidden">
                        <button class="btn btn-light px-3 py-2" id="qty-minus">−</button>
                        <span class="px-4 fw-bold" id="detail-qty">1</span>
                        <button class="btn btn-light px-3 py-2" id="qty-plus"
                            data-max="{{ $product->stock_quantity }}">+</button>
                    </div>
                    <button class="btn btn-primary btn-lg px-5 fw-bold flex-grow-1"
                        id="detail-add-cart" data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                    </button>
                </div>
                @endif

                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-outline-danger wishlist-btn w-100"
                        data-product-id="{{ $product->id }}">
                        <i class="bi bi-heart me-2"></i>Add to Wishlist
                    </button>
                </div>

                {{-- Product Details --}}
                <div class="border-top pt-3">
                    <div class="row g-2" style="font-size:13px;">
                        @if($product->brand)
                        <div class="col-6">
                            <span class="text-muted">Brand:</span>
                            <span class="fw-semibold ms-1">{{ $product->brand->name }}</span>
                        </div>
                        @endif
                        @if($product->weight)
                        <div class="col-6">
                            <span class="text-muted">Weight:</span>
                            <span class="fw-semibold ms-1">{{ $product->weight }} kg</span>
                        </div>
                        @endif
                        @if($product->dimensions)
                        <div class="col-6">
                            <span class="text-muted">Dimensions:</span>
                            <span class="fw-semibold ms-1">{{ $product->dimensions }}</span>
                        </div>
                        @endif
                        <div class="col-6">
                            <span class="text-muted">Views:</span>
                            <span class="fw-semibold ms-1">{{ number_format($product->views_count) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Description & Reviews Tabs --}}
    <div class="bg-white rounded-3 border mb-5">
        <ul class="nav nav-tabs border-bottom px-3 pt-2">
            <li class="nav-item">
                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#description">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#reviews">
                    Reviews ({{ $product->reviews->count() }})
                </a>
            </li>
        </ul>

        <div class="tab-content p-4">
            {{-- Description --}}
            <div class="tab-pane fade show active" id="description">
                @if($product->description)
                    <div style="font-size:14px;line-height:1.8;">{{ $product->description }}</div>
                @else
                    <p class="text-muted">No description available.</p>
                @endif
            </div>

            {{-- Reviews --}}
            <div class="tab-pane fade" id="reviews">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="text-center p-3 bg-light rounded-3">
                            <div style="font-size:64px;font-weight:900;color:var(--primary);">{{ number_format($avg, 1) }}</div>
                            <div class="mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $avg ? '-fill text-warning' : ' text-muted' }} fs-5"></i>
                                @endfor
                            </div>
                            <div class="text-muted" style="font-size:13px;">{{ $product->reviews->count() }} reviews</div>
                        </div>

                        {{-- Write Review --}}
                        @auth
                        <div class="mt-3 p-3 border rounded-3">
                            <h6 class="fw-bold mb-3">Write a Review</h6>
                            <div class="mb-2">
                                <label class="form-label fw-semibold" style="font-size:13px;">Rating *</label>
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
                        <div class="mt-3 p-3 border rounded-3 text-center">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                Login to Write a Review
                            </a>
                        </div>
                        @endauth
                    </div>

                    <div class="col-lg-8">
                        @forelse($product->reviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $review->user->name }}</div>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"
                                               style="font-size:13px;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-muted" style="font-size:12px;">
                                    {{ $review->created_at->format('d M Y') }}
                                </div>
                            </div>
                            @if($review->title)
                            <div class="fw-semibold mt-1" style="font-size:14px;">{{ $review->title }}</div>
                            @endif
                            @if($review->comment)
                            <p class="text-muted mt-1 mb-0" style="font-size:13px;">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square fs-1 d-block mb-2" style="color:#ddd;"></i>
                            No reviews yet. Be the first to review!
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
        <h5 class="fw-bold mb-3">Related Products</h5>
        <div class="row row-cols-2 row-cols-md-4 g-3">
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
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.9);z-index:9999;cursor:zoom-out;align-items:center;justify-content:center;">
    <img id="lightbox-img" style="max-width:90%;max-height:90vh;border-radius:8px;object-fit:contain;">
</div>
@endsection

@push('scripts')
<script>
// Image switcher
function switchImage(el) {
    document.getElementById('main-product-img').src = el.src;
    document.querySelectorAll('.thumb-img').forEach(t => t.style.borderColor = 'transparent');
    el.style.borderColor = 'var(--primary)';
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
    $.post('{{ route("customer.cart.add") }}', { product_id: productId, quantity: qty }, function(res) {
        if (res.success) {
            $('#cart-count').text(res.cart_count);
            showToast(res.message);
            btn.html('<i class="bi bi-check-lg me-1"></i>Added to Cart!');
            setTimeout(() => {
                btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-2"></i>Add to Cart');
            }, 2000);
        } else {
            showToast(res.message, 'error');
            btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-2"></i>Add to Cart');
        }
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