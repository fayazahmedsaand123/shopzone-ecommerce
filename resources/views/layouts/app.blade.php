<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        /* Theme System -- prevents flash of wrong theme */
        (function () {
            var saved = localStorage.getItem('shopzone-theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = saved || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'ShopZone — Pakistan\'s premium online store. Shop phones, laptops, fashion, home, beauty and more with fast delivery and secure payment.')">
    <title>@yield('title', 'ShopZone — Pakistan\'s Online Store')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Our CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="store-body">

    @include('layouts.partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash success">
            <div class="container">
                <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="flash error">
            <div class="container">
                <i class="bi bi-exclamation-circle-fill"></i>{{ session('error') }}
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
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3">
                        <span class="brand-mark">S</span>
                        <span class="navbar-brand-text">Shop<span>Zone</span></span>
                    </a>
                    <p>
                        Pakistan's trusted online shopping destination. Authentic products from
                        verified brands, fast delivery nationwide and secure payments — all in one place.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <span class="pay-chip"><i class="bi bi-cash-coin"></i>Cash on Delivery</span>
                        <span class="pay-chip"><i class="bi bi-phone"></i>JazzCash</span>
                        <span class="pay-chip"><i class="bi bi-phone-vibrate"></i>Easypaisa</span>
                        <span class="pay-chip"><i class="bi bi-bank"></i>Bank Transfer</span>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Shop</h6>
                    <a href="{{ route('products.index') }}">All Products</a>
                    <a href="{{ route('new-arrivals') }}">New Arrivals</a>
                    <a href="{{ route('best-sellers') }}">Best Sellers</a>
                    <a href="{{ route('brands.index') }}">Brands</a>
                    <a href="{{ route('products.index', ['sort' => 'popular']) }}">Top Rated</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>My Account</h6>
                    @auth
                        <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                        <a href="{{ route('customer.orders.index') }}">My Orders</a>
                        <a href="{{ route('customer.wishlist.index') }}">Wishlist</a>
                        <a href="{{ route('customer.cart.index') }}">Shopping Cart</a>
                        <a href="{{ route('customer.profile.edit') }}">Profile Settings</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Create Account</a>
                        <a href="{{ route('customer.wishlist.index') }}">Wishlist</a>
                        <a href="{{ route('customer.cart.index') }}">Shopping Cart</a>
                        <a href="{{ route('contact') }}">Help Center</a>
                    @endauth
                </div>

                <div class="col-lg-4">
                    <h6>Get in Touch</h6>
                    <div class="footer-contact"><i class="bi bi-geo-alt"></i>Naseem Nagar, Qasimabad, Hyderabad</div>
                    <div class="footer-contact"><i class="bi bi-telephone"></i>0349-9050580</div>
                    <div class="footer-contact"><i class="bi bi-envelope"></i>support@shopzone.pk</div>
                    <div class="footer-contact"><i class="bi bi-clock"></i>Mon–Sat, 9:00 AM – 6:00 PM</div>

                    <form method="POST" action="{{ route('newsletter.store') }}" class="mt-3">
                        @csrf
                        <div class="newsletter-form">
                            <input type="email" name="email" placeholder="Email for exclusive deals" required>
                            <button class="btn btn-primary btn-sm px-3" type="submit">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <span>&copy; {{ date('Y') }} ShopZone. All rights reserved.</span>
                <span class="d-flex align-items-center gap-1">
                    Made with <i class="bi bi-heart-fill" style="color:var(--danger);"></i> in Pakistan
                </span>
            </div>
        </div>
    </footer>

    {{-- Toast Notification --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="main-toast" class="toast align-items-center text-white border-0" role="alert" style="border-radius:14px;">
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

        // CSRF Setup
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        const loginUrl = '{{ route("login") }}';

        function handleAccountFailure(xhr, fallbackMessage) {
            const res = xhr.responseJSON || {};
            const message = res.message || fallbackMessage;

            showToast(message, 'error');

            if (xhr.status === 401 || (res.redirect && !window.location.pathname.startsWith('/admin'))) {
                setTimeout(() => window.location.href = res.redirect || loginUrl, 1200);
            }
        }

        // Add to Cart
        $(document).on('click', '.btn-add-cart:not(:disabled)', function () {
            const productId = $(this).data('product-id');
            const btn = $(this);

            @auth
            btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Adding...');

            $.ajax({
                url: '{{ route("customer.cart.add") }}',
                method: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                headers: { 'Accept': 'application/json' }
            }).done(function (res) {
                if (!res || !res.success) {
                    showToast((res && res.message) || 'Could not add to cart.', 'error');
                    btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i>Add to Cart');
                    return;
                }

                $('#cart-count').text(res.cart_count);
                showToast(res.message);
                btn.html('<i class="bi bi-check-lg me-1"></i>Added!');
                setTimeout(() => btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i>Add to Cart'), 1500);
            }).fail(function (xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-cart-plus me-1"></i>Add to Cart');
                handleAccountFailure(xhr, 'Could not add to cart. Please try again.');
            });
            @else
            showToast('Please login to add items to cart.', 'error');
            setTimeout(() => window.location.href = loginUrl, 1000);
            @endauth
        });

        // Wishlist Toggle
        $(document).on('click', '.wishlist-btn', function () {
            const productId = $(this).data('product-id');
            const btn = $(this);

            @auth
            $.ajax({
                url: '{{ route("customer.wishlist.toggle") }}',
                method: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                headers: { 'Accept': 'application/json' }
            }).done(function (res) {
                if (!res || !res.success) {
                    showToast((res && res.message) || 'Could not update wishlist.', 'error');
                    return;
                }

                $('#wishlist-count').text(res.wishlist_count);
                showToast(res.message);

                const label = btn.find('.wishlist-label');
                if (res.action === 'added') {
                    btn.find('i').removeClass('bi-heart').addClass('bi-heart-fill');
                    label.text('In Wishlist');
                    btn.data('wishlisted', true);
                } else {
                    btn.find('i').removeClass('bi-heart-fill').addClass('bi-heart');
                    label.text('Add to Wishlist');
                    btn.data('wishlisted', false);

                    if (window.location.pathname.endsWith('/wishlist')) {
                        setTimeout(() => window.location.reload(), 600);
                    }
                }
            }).fail(function (xhr) {
                handleAccountFailure(xhr, 'Could not update wishlist. Please try again.');
            });
            @else
            showToast('Please login to use wishlist.', 'error');
            setTimeout(() => window.location.href = loginUrl, 1000);
            @endauth
        });

        // Toast Helper
        function showToast(message, type = 'success') {
            const toast = $('#main-toast');
            toast.removeClass('bg-success bg-danger bg-warning');
            toast.addClass(type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-warning');
            $('#toast-message').text(message);
            new bootstrap.Toast(toast[0], { delay: 3000 }).show();
        }

        // AJAX Live Search
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
                                <div style="font-size:11px;color:#6f788c;">${p.category}</div>
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

        // Mobile search
        $('#mobile-search-btn').on('click', function () {
            const q = $('#mobile-search-input').val().trim();
            if (q.length > 0) {
                window.location.href = '{{ route("products.index") }}?search=' + encodeURIComponent(q);
            }
        });

        $('#mobile-search-input').on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                $('#mobile-search-btn').trigger('click');
            }
        });

    </script>

    <script>
        /* ── Theme Toggle Handler ───────────────────── */
        (function () {
            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('shopzone-theme', theme);
                var icon = document.getElementById('theme-toggle-icon');
                if (icon) icon.textContent = theme === 'dark' ? '\u2600\ufe0f' : '\uD83C\uDF19';
            }

            var btn = document.getElementById('theme-toggle-btn');
            if (btn) {
                btn.addEventListener('click', function () {
                    var current = document.documentElement.getAttribute('data-theme') || 'dark';
                    applyTheme(current === 'dark' ? 'light' : 'dark');
                });
            }

            // Set correct icon on load
            var currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            var icon = document.getElementById('theme-toggle-icon');
            if (icon) icon.textContent = currentTheme === 'dark' ? '\u2600\ufe0f' : '\uD83C\uDF19';
        })();
    </script>
    @stack('scripts')
</body>
</html>
