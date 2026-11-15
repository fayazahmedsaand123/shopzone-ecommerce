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
    <meta name="theme-color" content="#0b0f19">
    <title>@yield('title', 'Admin') — ShopZone</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 264px;
            --brand: #7c5cff;
            --brand-2: #a855f7;
            --accent: #22d3ee;
            --bg: #0b0f19;
            --surface: #111827;
            --surface-2: #0f172a;
            --line: rgba(255, 255, 255, .075);
            --line-strong: rgba(255, 255, 255, .14);
            --text: #e9edf7;
            --muted: #8b93a7;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f5a524;
        }

        html, body { background: var(--bg); }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            color: var(--text);
            background-image:
                radial-gradient(1100px 520px at 100% -8%, rgba(124, 92, 255, .12), transparent 60%),
                radial-gradient(900px 480px at -5% 5%, rgba(34, 211, 238, .07), transparent 55%);
            background-attachment: fixed;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar ───────────────────────────── */
        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1045;
            width: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background: linear-gradient(180deg, #0d1322 0%, #0a0e18 100%);
            border-right: 1px solid var(--line);
            transition: transform .25s ease;
        }
        .admin-sidebar::-webkit-scrollbar { width: 6px; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 99px; }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 20px 20px 18px;
            border-bottom: 1px solid var(--line);
            text-decoration: none;
        }
        .brand-mark {
            width: 38px; height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            color: #fff;
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 10px 24px rgba(124, 92, 255, .35);
        }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: #fff;
            letter-spacing: .2px;
        }
        .brand-name span { color: var(--brand-2); }

        .sidebar-menu { padding: 10px 0 16px; }
        .sidebar-label {
            padding: 16px 24px 7px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .32);
        }
        .sidebar-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 2px 12px;
            padding: 10px 12px;
            border-radius: 11px;
            color: #a7afc2;
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: background .18s ease, color .18s ease, box-shadow .18s ease;
        }
        .sidebar-link i { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-link:hover { background: rgba(255, 255, 255, .05); color: #fff; }
        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(124, 92, 255, .26), rgba(124, 92, 255, .04));
            box-shadow: inset 0 0 0 1px rgba(124, 92, 255, .35);
        }
        .sidebar-link.active::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 9px;
            bottom: 9px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: linear-gradient(180deg, var(--brand), var(--brand-2));
        }
        .sidebar-footer { margin-top: auto; padding: 12px 0 16px; border-top: 1px solid var(--line); }

        /* ── Shell ─────────────────────────────── */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 13px 26px;
            background: rgba(11, 15, 25, .78);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
        }
        .topbar-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
        }
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 5px 14px 5px 5px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: rgba(255, 255, 255, .03);
            font-size: 13px;
            color: var(--text);
        }
        .user-chip .avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
        }
        .admin-content { padding: 26px; flex: 1; }

        .sidebar-toggle { display: none; }
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(4, 7, 13, .65);
            backdrop-filter: blur(2px);
            opacity: 0;
            visibility: hidden;
            transition: opacity .2s ease, visibility .2s ease;
        }
        .sidebar-backdrop.show { opacity: 1; visibility: visible; }

        /* ── Cards & chrome ────────────────────── */
        .stat-card {
            background: linear-gradient(180deg, rgba(255,255,255,.045), rgba(255,255,255,.015));
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover { border-color: rgba(124, 92, 255, .35); box-shadow: 0 14px 34px rgba(0,0,0,.35); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .admin-table { background: var(--surface); border: 1px solid var(--line); border-radius: 16px; overflow: hidden; }
        .admin-table .table {
            margin: 0;
            --bs-table-bg: transparent;
            --bs-table-color: var(--text);
            --bs-table-border-color: var(--line);
            --bs-table-hover-bg: rgba(255, 255, 255, .025);
            --bs-table-hover-color: #fff;
        }
        .admin-table .table thead th {
            background: rgba(255, 255, 255, .025);
            font-size: 11px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }
        .admin-table .table td { vertical-align: middle; font-size: 13.5px; border-color: var(--line); }

        .page-header { margin-bottom: 22px; }
        .page-header h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 22px;
            color: #fff;
            margin: 0;
            letter-spacing: -.01em;
        }
        .breadcrumb { margin: 0; font-size: 13px; --bs-breadcrumb-divider-color: rgba(255,255,255,.35); }
        .breadcrumb-item a { color: var(--muted); text-decoration: none; }
        .breadcrumb-item.active { color: #cfd5e4; }

        /* ── Forms & buttons ───────────────────── */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, .035);
            border: 1px solid var(--line);
            color: var(--text);
            border-radius: 10px;
        }
        .form-control::placeholder { color: rgba(255, 255, 255, .3); }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, .05);
            border-color: rgba(124, 92, 255, .7);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(124, 92, 255, .15);
        }
        .form-label { font-size: 12.5px; font-weight: 600; color: #c3c9d8; }
        .form-text, .text-muted { color: var(--muted) !important; }

        .btn { --bs-btn-font-weight: 600; border-radius: 10px; }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand), #9d5cff);
            border: 0;
            box-shadow: 0 8px 20px rgba(124, 92, 255, .28);
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background: linear-gradient(135deg, #8b6dff, #b26bff) !important;
            box-shadow: 0 10px 26px rgba(124, 92, 255, .38);
            color: #fff;
        }
        .btn-outline-primary {
            --bs-btn-color: #b9a5ff;
            --bs-btn-border-color: rgba(124, 92, 255, .5);
            --bs-btn-hover-bg: rgba(124, 92, 255, .15);
            --bs-btn-hover-border-color: rgba(124, 92, 255, .8);
            --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: rgba(124, 92, 255, .25);
        }
        .btn-outline-secondary {
            --bs-btn-color: #c3c9d8;
            --bs-btn-border-color: var(--line-strong);
            --bs-btn-hover-bg: rgba(255, 255, 255, .08);
            --bs-btn-hover-border-color: rgba(255, 255, 255, .25);
            --bs-btn-hover-color: #fff;
        }
        .btn-outline-danger {
            --bs-btn-color: #f87171;
            --bs-btn-border-color: rgba(239, 68, 68, .45);
            --bs-btn-hover-bg: rgba(239, 68, 68, .18);
            --bs-btn-hover-border-color: rgba(239, 68, 68, .8);
            --bs-btn-hover-color: #fff;
        }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); border: 0; }

        .dropdown-menu {
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: 12px;
        }
        .modal-content { background: var(--surface); border: 1px solid var(--line); border-radius: 16px; }

        .alert { border-radius: 12px; border-width: 1px; font-size: .9rem; }
        .pagination { --bs-pagination-bg: transparent; --bs-pagination-border-color: var(--line); --bs-pagination-color: var(--muted); --bs-pagination-hover-bg: rgba(255,255,255,.06); --bs-pagination-active-bg: var(--brand); --bs-pagination-active-border-color: var(--brand); }

        #main-toast { border-radius: 14px; }

        .surface-soft {
            background: rgba(255, 255, 255, .045);
            border: 1px solid var(--line);
        }

        @media (max-width: 991.98px) {
            .admin-sidebar { transform: translateX(-100%); box-shadow: 20px 0 50px rgba(0,0,0,.5); }
            .admin-sidebar.show { transform: none; }
            .admin-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; }
            .admin-content { padding: 18px; }
            .admin-topbar { padding: 12px 18px; }
            .user-chip .name { display: none; }
        }
        /* ── Admin Light Theme ──────────────────────────────── */
        [data-theme="light"] {
            --brand: #6244f5;
            --brand-2: #a855f7;
            --accent: #e07b00;
            --bg: #f4f6fb;
            --surface: #ffffff;
            --surface-2: #f0f2f9;
            --line: rgba(0, 0, 0, .08);
            --line-strong: rgba(0, 0, 0, .14);
            --text: #1a1d2e;
            --muted: #5a6482;
            --danger: #e02450;
            --success: #0fa968;
            --warning: #d47000;
        }
        [data-theme="light"] body { background: #f4f6fb; color: #1a1d2e; }
        [data-theme="light"] body {
            background-image:
                radial-gradient(1100px 520px at 100% -8%, rgba(98,68,245,.07), transparent 60%),
                radial-gradient(900px 480px at -5% 5%, rgba(74,110,248,.05), transparent 55%);
        }
        [data-theme="light"] .admin-sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fd 100%);
            border-right-color: rgba(0,0,0,.1);
        }
        [data-theme="light"] .sidebar-brand { border-bottom-color: rgba(0,0,0,.08); }
        [data-theme="light"] .brand-name { color: #1a1d2e; }
        [data-theme="light"] .sidebar-label { color: rgba(0,0,0,.35); }
        [data-theme="light"] .sidebar-link { color: #5a6482; }
        [data-theme="light"] .sidebar-link:hover { background: rgba(0,0,0,.04); color: #1a1d2e; }
        [data-theme="light"] .sidebar-link.active {
            color: var(--brand);
            background: linear-gradient(90deg, rgba(98,68,245,.12), rgba(98,68,245,.03));
            box-shadow: inset 0 0 0 1px rgba(98,68,245,.25);
        }
        [data-theme="light"] .sidebar-footer { border-top-color: rgba(0,0,0,.08); }
        [data-theme="light"] .admin-topbar {
            background: rgba(248,249,253,.9);
            border-bottom-color: rgba(0,0,0,.1);
        }
        [data-theme="light"] .topbar-title { color: #1a1d2e; }
        [data-theme="light"] .user-chip { border-color: rgba(0,0,0,.12); background: rgba(0,0,0,.03); color: #1a1d2e; }
        [data-theme="light"] .stat-card {
            background: linear-gradient(180deg, rgba(0,0,0,.025), rgba(0,0,0,.01));
            border-color: rgba(0,0,0,.1);
        }
        [data-theme="light"] .stat-card:hover { border-color: rgba(98,68,245,.3); box-shadow: 0 10px 24px rgba(0,0,0,.12); }
        [data-theme="light"] .admin-table { background: #fff; border-color: rgba(0,0,0,.1); }
        [data-theme="light"] .admin-table .table {
            --bs-table-color: #1a1d2e;
            --bs-table-border-color: rgba(0,0,0,.08);
            --bs-table-hover-bg: rgba(0,0,0,.025);
            --bs-table-hover-color: #1a1d2e;
        }
        [data-theme="light"] .admin-table .table thead th { background: rgba(0,0,0,.025); color: #5a6482; border-bottom-color: rgba(0,0,0,.08); }
        [data-theme="light"] .admin-table .table td { border-color: rgba(0,0,0,.08); }
        [data-theme="light"] .page-header h4 { color: #1a1d2e; }
        [data-theme="light"] .breadcrumb-item a { color: #5a6482; }
        [data-theme="light"] .breadcrumb-item.active { color: #3a4055; }
        [data-theme="light"] .form-control, [data-theme="light"] .form-select {
            background-color: #fff;
            border-color: rgba(0,0,0,.14);
            color: #1a1d2e;
        }
        [data-theme="light"] .form-control::placeholder { color: rgba(0,0,0,.35); }
        [data-theme="light"] .form-control:focus, [data-theme="light"] .form-select:focus {
            background-color: #fff;
            border-color: var(--brand);
            color: #1a1d2e;
            box-shadow: 0 0 0 4px rgba(98,68,245,.1);
        }
        [data-theme="light"] .form-label { color: #3a4055; }
        [data-theme="light"] .form-text { color: #5a6482 !important; }
        [data-theme="light"] .btn-outline-secondary {
            --bs-btn-color: #5a6482;
            --bs-btn-border-color: rgba(0,0,0,.18);
            --bs-btn-hover-bg: rgba(0,0,0,.07);
            --bs-btn-hover-border-color: rgba(0,0,0,.28);
            --bs-btn-hover-color: #1a1d2e;
        }
        [data-theme="light"] .dropdown-menu { background: #fff; border-color: rgba(0,0,0,.12); }
        [data-theme="light"] .modal-content { background: #fff; border-color: rgba(0,0,0,.12); }
        [data-theme="light"] .surface-soft { background: rgba(0,0,0,.03); border-color: rgba(0,0,0,.08); }
        [data-theme="light"] .sidebar-backdrop { background: rgba(0,0,0,.35); }

        /* ── Admin Theme Toggle Button ───────────────────────── */
        .admin-theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 999px;
            border: 1px solid var(--line-strong);
            background: rgba(255,255,255,.05);
            color: var(--muted);
            font-size: .78rem;
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease, color .2s ease;
            white-space: nowrap;
        }
        .admin-theme-toggle:hover { border-color: var(--brand); background: rgba(124,92,255,.12); color: #fff; }
        [data-theme="light"] .admin-theme-toggle { border-color: rgba(0,0,0,.14); background: rgba(0,0,0,.04); color: #5a6482; }
        [data-theme="light"] .admin-theme-toggle:hover { border-color: var(--brand); background: rgba(98,68,245,.1); color: var(--brand); }
        .admin-toggle-track {
            position: relative;
            width: 30px; height: 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            flex-shrink: 0;
        }
        [data-theme="light"] .admin-toggle-track { background: rgba(0,0,0,.08); border-color: rgba(0,0,0,.18); }
        .admin-toggle-thumb {
            position: absolute;
            top: 2px; left: 2px;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: var(--muted);
            transition: transform .22s cubic-bezier(.4,0,.2,1), background .2s ease;
        }
        [data-theme="light"] .admin-toggle-thumb { transform: translateX(14px); background: var(--brand); }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleSidebar()"></div>

{{-- Sidebar --}}
<aside class="admin-sidebar" id="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <span class="brand-mark">S</span>
        <span class="brand-name">Shop<span>Zone</span></span>
    </a>
    <div class="sidebar-menu">
        <div class="sidebar-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-label">Catalog</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Categories
        </a>
        <a href="{{ route('admin.brands.index') }}" class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="bi bi-award"></i> Brands
        </a>

        <div class="sidebar-label">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i> Orders
        </a>
        <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> Coupons
        </a>

        <div class="sidebar-label">Content</div>
        <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star"></i> Reviews
        </a>
        <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Messages
        </a>

        <div class="sidebar-label">System</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank" rel="noopener">
            <i class="bi bi-shop"></i> View Store
        </a>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="admin-main">
    <header class="admin-topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm sidebar-toggle" type="button" onclick="toggleSidebar()" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm d-none d-md-inline-flex">
                <i class="bi bi-box-arrow-up-right me-1"></i>Store
            </a>
            {{-- Theme Toggle --}}
            <button class="admin-theme-toggle" id="admin-theme-toggle-btn" aria-label="Toggle theme" title="Toggle light/dark theme">
                <span class="admin-toggle-track"><span class="admin-toggle-thumb"></span></span>
                <span id="admin-theme-icon">&#9728;&#65039;</span>
            </button>
            <span class="user-chip">
                <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="name">{{ auth()->user()->name }}</span>
            </span>
        </div>
    </header>

    <div class="admin-content">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

{{-- Toast --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="main-toast" class="toast align-items-center text-white border-0">
        <div class="d-flex">
            <div class="toast-body" id="toast-message"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    function toggleSidebar() {
        document.getElementById('admin-sidebar').classList.toggle('show');
        document.getElementById('sidebar-backdrop').classList.toggle('show');
    }

    function showToast(message, type = 'success') {
        const toast = $('#main-toast');
        toast.removeClass('bg-success bg-danger');
        toast.addClass(type === 'success' ? 'bg-success' : 'bg-danger');
        $('#toast-message').text(message);
        new bootstrap.Toast(toast[0], { delay: 3000 }).show();
    }

    function confirmDelete(url, rowId) {
        if (!confirm('Are you sure you want to delete this item?')) return;
        $.ajax({
            url: url, type: 'DELETE',
            success: function(res) {
                if (res.success) {
                    $(rowId).fadeOut(300, function() { $(this).remove(); });
                    showToast(res.message);
                } else {
                    showToast(res.message, 'error');
                }
            },
            error: function() { showToast('Something went wrong.', 'error'); }
        });
    }
</script>
    <script>
        /* ── Admin Theme Toggle ─────────────────────────── */
        (function () {
            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                document.documentElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('shopzone-theme', theme);
                var icon = document.getElementById('admin-theme-icon');
                if (icon) icon.textContent = theme === 'dark' ? '\u2600\ufe0f' : '\uD83C\uDF19';
            }
            var btn = document.getElementById('admin-theme-toggle-btn');
            if (btn) {
                btn.addEventListener('click', function () {
                    var current = document.documentElement.getAttribute('data-theme') || 'dark';
                    applyTheme(current === 'dark' ? 'light' : 'dark');
                });
            }
            var currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            var icon = document.getElementById('admin-theme-icon');
            if (icon) icon.textContent = currentTheme === 'dark' ? '\u2600\ufe0f' : '\uD83C\uDF19';
        })();
    </script>
@stack('scripts')
</body>
</html>
