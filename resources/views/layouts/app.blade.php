<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopZone — Pakistan\'s Online Store')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Our CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    @include('layouts.partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h5 class="navbar-brand-text mb-3">Shop<span style="color:var(--accent)">Zone</span></h5>
                    <p style="font-size:13px;">Pakistan's trusted online shopping destination. Quality products, great prices.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Quick Links</h6>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="#">All Products</a>
                    <a href="#">New Arrivals</a>
                    <a href="#">Best Sellers</a>
                    <a href="#">Deals & Offers</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Customer Service</h6>
                    <a href="#">My Account</a>
                    <a href="#">Order History</a>
                    <a href="#">Track Order</a>
                    <a href="#">Returns & Refunds</a>
                    <a href="#">Help & Contact</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>Policies</h6>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Shipping Policy</a>
                    <a href="#">FAQ</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>Newsletter</h6>
                    <p style="font-size:13px;">Get the latest deals and offers.</p>
                    <div class="input-group mt-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Your email">
                        <button class="btn btn-primary btn-sm">Subscribe</button>
                    </div>
                    <div class="mt-3">
                        <small><i class="bi bi-telephone me-1"></i>0300-0000000</small><br>
                        <small><i class="bi bi-envelope me-1"></i>support@shopzone.pk</small>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} ShopZone. All rights reserved. | Made with <i class="bi bi-heart-fill text-danger"></i> in Pakistan</p>
            </div>
        </div>
    </footer>

    {{-- Toast Notification --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="main-toast" class="toast align-items-center text-white border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toast-message"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

    // ── CSRF Setup ────────────────────────────
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// ── Add to Cart ───────────────────────────
$(document).on('click', '.btn-add-cart:not(:disabled)', function () {
    const productId = $(this).data('product-id');
    const btn = $(this);

    @auth
    btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Adding...');

    $.post('{{ route("customer.cart.add") }}', { product_id: productId }, function (res) {
        if (res.success) {
            $('#cart-count').text(res.cart_count);
            showToast(res.message);
            btn.html('<i class="bi bi-check-lg me-1"></i>Added!');
            setTimeout(() => btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i>Add to Cart'), 1500);
        } else {
            showToast(res.message, 'error');
            btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i>Add to Cart');
            if (res.redirect) window.location.href = res.redirect;
        }
    });
    @else
    showToast('Please login to add items to cart.', 'error');
    setTimeout(() => window.location.href = '{{ route("login") }}', 1000);
    @endauth
});

// ── Wishlist Toggle ───────────────────────
$(document).on('click', '.wishlist-btn', function () {
    const productId = $(this).data('product-id');
    const btn = $(this);

    @auth
    $.post('{{ route("customer.wishlist.toggle") }}', { product_id: productId }, function (res) {
        if (res.success) {  
            $('#wishlist-count').text(res.wishlist_count);
            showToast(res.message);
            if (res.action === 'added') {
                btn.find('i').removeClass('bi-heart').addClass('bi-heart-fill text-danger');
            } else {
                btn.find('i').removeClass('bi-heart-fill text-danger').addClass('bi-heart');
            }
        }
    });
    @else
    showToast('Please login to use wishlist.', 'error');
    setTimeout(() => window.location.href = '{{ route("login") }}', 1000);
    @endauth
});

// ── Toast Helper ──────────────────────────
function showToast(message, type = 'success') {
    const toast = $('#main-toast');
    toast.removeClass('bg-success bg-danger bg-warning');
    toast.addClass(type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-warning');
    $('#toast-message').text(message);
    new bootstrap.Toast(toast[0], { delay: 3000 }).show();
}

// ── AJAX Live Search ──────────────────────
let searchTimer;
$('#search-input').on('input', function () {
    clearTimeout(searchTimer);
    const query = $(this).val().trim();
    const box   = $('#search-suggestions');

    if (query.length < 2) { box.hide(); return; }

    box.html('<div class="suggestion-empty"><i class="bi bi-hourglass-split me-1"></i>Searching...</div>').show();

    searchTimer = setTimeout(function () {
        $.get('{{ route("products.search") }}', { q: query }, function (data) {
            if (!data.length) {
                box.html('<div class="suggestion-empty"><i class="bi bi-inbox me-1"></i>No products found.</div>');
                return;
            }
            let html = '';
            data.forEach(function (p) {
                html += `
                <div class="suggestion-item" onclick="window.location='${p.url}'">
                    <img src="${p.image}" alt="${p.name}">
                    <div>
                        <div class="s-name">${p.name}</div>
                        <div class="s-price">PKR ${p.price}</div>
                        <div style="font-size:11px;color:#999;">${p.category}</div>
                    </div>
                </div>`;
            });
            html += `<div class="suggestion-item justify-content-center text-primary fw-semibold"
                onclick="window.location='{{ route('products.index') }}?search=${encodeURIComponent(query)}'">
                <i class="bi bi-search me-2"></i>See all results for "${query}"
            </div>`;
            box.html(html);
        });
    }, 300);
});

// Hide suggestions on outside click
$(document).on('click', function (e) {
    if (!$(e.target).closest('#search-container').length) {
        $('#search-suggestions').hide();
    }
});

// Search button
$('#search-btn').on('click', function () {
    const q = $('#search-input').val().trim();
    if (q.length > 0) {
        window.location.href = '{{ route("products.index") }}?search=' + encodeURIComponent(q);
    }
});

// Enter key search
$('#search-input').on('keydown', function (e) {
    if (e.key === 'Enter') {
        const q = $(this).val().trim();
        if (q.length > 0) {
            window.location.href = '{{ route("products.index") }}?search=' + encodeURIComponent(q);
        }
    }
});

// Mobile menu
$('#mobile-menu-btn').on('click', function () {
    $('#mobile-search-bar').slideToggle(200);
});

    </script>

    @stack('scripts')
</body>
</html>