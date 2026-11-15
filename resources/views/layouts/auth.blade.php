<!DOCTYPE html>
<html lang="en">
<head>
    <script>
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
    <title>@yield('title', 'Account') — ShopZone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">
<div class="auth-shell">

    <aside class="auth-aside">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-mark">S</span>
            <span class="navbar-brand-text">Shop<span>Zone</span></span>
        </a>

        <div>
            <h2>Everything you love, delivered <span>across Pakistan.</span></h2>
            <div class="auth-feature"><i class="bi bi-check-circle-fill"></i>Authentic products from verified brands</div>
            <div class="auth-feature"><i class="bi bi-truck"></i>Fast nationwide delivery in 2–5 days</div>
            <div class="auth-feature"><i class="bi bi-shield-check"></i>Secure checkout with COD &amp; mobile wallets</div>
            <div class="auth-feature"><i class="bi bi-arrow-repeat"></i>7-day easy returns, no questions asked</div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <span class="pay-chip"><i class="bi bi-cash-coin"></i>Cash on Delivery</span>
            <span class="pay-chip"><i class="bi bi-phone"></i>JazzCash</span>
            <span class="pay-chip"><i class="bi bi-phone-vibrate"></i>Easypaisa</span>
            <span class="pay-chip"><i class="bi bi-bank"></i>Bank Transfer</span>
        </div>
    </aside>

    <main class="auth-main">
        <div class="auth-card">
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
