@php
    $catIcons = [
        'mobile-phones'      => 'bi-phone',
        'electronics'        => 'bi-tv',
        'laptops-computers'  => 'bi-laptop',
        'gaming'             => 'bi-controller',
        'cameras'            => 'bi-camera',
        'audio'              => 'bi-headphones',
        'fashion'            => 'bi-bag',
        'footwear'           => 'bi-box-seam',
        'watches'            => 'bi-smartwatch',
        'home-living'        => 'bi-house',
        'sports'             => 'bi-bicycle',
        'health-beauty'      => 'bi-heart-pulse',
        'books'              => 'bi-book',
        'toys-kids'          => 'bi-robot',
    ];
@endphp

{{-- TOP UTILITY BAR --}}
<div class="topbar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex gap-4">
            <span class="topbar-item"><i class="bi bi-truck"></i>Free delivery over PKR 5,000</span>
            <span class="topbar-item"><i class="bi bi-arrow-repeat"></i>7-day easy returns</span>
        </div>
        <div class="d-flex gap-4 align-items-center">
            <a href="tel:03499050580" class="topbar-item"><i class="bi bi-telephone"></i>0349-9050580</a>
            <a href="{{ route('contact') }}" class="topbar-item"><i class="bi bi-headset"></i>Help Center</a>
            @auth
                <span class="topbar-item"><i class="bi bi-person-check"></i>{{ auth()->user()->name }}</span>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</div>

{{-- MAIN HEADER --}}
<header class="site-header">
    <nav class="main-navbar">
        <div class="container d-flex align-items-center gap-3">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 me-2">
                <span class="brand-mark">S</span>
                <span class="navbar-brand-text d-none d-sm-inline">Shop<span>Zone</span></span>
            </a>

            {{-- Category Dropdown --}}
            <div class="dropdown category-dropdown d-none d-lg-block">
                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-grid-3x3-gap me-1"></i>Categories
                </button>
                <ul class="dropdown-menu">
                    @foreach($navCategories ?? [] as $cat)
                    <li>
                        <a class="dropdown-item" href="{{ route('products.index', ['category' => $cat->slug]) }}">
                            <i class="bi {{ $catIcons[$cat->slug] ?? 'bi-grid' }} me-2 text-primary"></i>{{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('products.index') }}">
                        <i class="bi bi-collection me-2 text-primary"></i>Browse All Products
                    </a></li>
                </ul>
            </div>

            {{-- Search Bar --}}
            <div class="flex-grow-1 position-relative" id="search-container">
                <div class="search-wrapper">
                    <input
                        type="text"
                        class="search-input"
                        id="search-input"
                        placeholder="Search products, brands and more..."
                        autocomplete="off"
                    >
                    <button class="search-btn" id="search-btn" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                {{-- AJAX Suggestions --}}
                <div class="search-suggestions" id="search-suggestions"></div>
            </div>

            {{-- Right Icons --}}
            <div class="d-flex align-items-center gap-1">

                {{-- Wishlist --}}
                <a href="{{ auth()->check() ? route('customer.wishlist.index') : route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-heart"></i>
                    <span class="nav-badge" id="wishlist-count">
                        {{ auth()->check() ? auth()->user()->wishlist()->count() : 0 }}
                    </span>
                    <span class="d-none d-xl-block">Wishlist</span>
                </a>

                {{-- Cart --}}
                <a href="{{ auth()->check() ? route('customer.cart.index') : route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-cart3"></i>
                    <span class="nav-badge" id="cart-count">
                        {{ auth()->check() ? auth()->user()->cart()->sum('quantity') : 0 }}
                    </span>
                    <span class="d-none d-xl-block">Cart</span>
                </a>

                {{-- Account --}}
                @auth
                <div class="dropdown">
                    <a href="#" class="nav-icon-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-xl-block">Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                        @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-grid me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                        <li><a class="dropdown-item" href="{{ route('customer.wishlist.index') }}"><i class="bi bi-heart me-2"></i>Wishlist</a></li>
                        <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit" style="color:#ff9db0;">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-person"></i>
                    <span class="d-none d-xl-block">Login</span>
                </a>
                @endauth

                {{-- Theme Toggle --}}
                <button class="theme-toggle-btn ms-1" id="theme-toggle-btn" aria-label="Toggle theme" title="Toggle light/dark theme">
                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                    <span class="toggle-icon" id="theme-toggle-icon">&#9728;&#65039;</span>
                </button>

                {{-- Mobile Menu Toggle --}}
                <button class="btn btn-outline-secondary btn-sm d-lg-none ms-1" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>

    {{-- MOBILE SEARCH --}}
    <div class="mobile-search-bar d-lg-none">
        <div class="search-wrapper">
            <input type="text" class="search-input" id="mobile-search-input" placeholder="Search products...">
            <button class="search-btn" id="mobile-search-btn" aria-label="Search"><i class="bi bi-search"></i></button>
        </div>
    </div>

    {{-- MOBILE NAV --}}
    <div class="collapse d-lg-none" id="mobileNav">
        <div class="container py-3" style="border-top:1px solid var(--line);">
            <div class="row g-1">
                <div class="col-6"><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-house me-2"></i>Home</a></div>
                <div class="col-6"><a class="dropdown-item" href="{{ route('products.index') }}"><i class="bi bi-collection me-2"></i>All Products</a></div>
                <div class="col-6"><a class="dropdown-item" href="{{ route('new-arrivals') }}"><i class="bi bi-stars me-2"></i>New Arrivals</a></div>
                <div class="col-6"><a class="dropdown-item" href="{{ route('best-sellers') }}"><i class="bi bi-fire me-2"></i>Best Sellers</a></div>
                <div class="col-6"><a class="dropdown-item" href="{{ route('brands.index') }}"><i class="bi bi-award me-2"></i>Brands</a></div>
                <div class="col-6"><a class="dropdown-item" href="{{ route('contact') }}"><i class="bi bi-headset me-2"></i>Contact</a></div>
            </div>
            <div class="filter-title mt-3">Categories</div>
            <div class="row g-1">
                @foreach($navCategories ?? [] as $cat)
                <div class="col-6">
                    <a class="dropdown-item" href="{{ route('products.index', ['category' => $cat->slug]) }}">
                        <i class="bi {{ $catIcons[$cat->slug] ?? 'bi-grid' }} me-2 text-primary"></i>{{ $cat->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SECONDARY NAV --}}
    <div class="secondary-nav d-none d-lg-block">
        <div class="container">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                       href="{{ route('products.index') }}">All Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('new-arrivals') ? 'active' : '' }}"
                       href="{{ route('new-arrivals') }}">New Arrivals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('best-sellers') ? 'active' : '' }}"
                       href="{{ route('best-sellers') }}">Best Sellers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link deal-link" href="{{ route('products.index', ['sort' => 'price_asc']) }}">
                        <i class="bi bi-lightning-charge-fill me-1"></i>Deals & Offers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('brands.index') ? 'active' : '' }}"
                       href="{{ route('brands.index') }}">Brands</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">Contact Us</a>
                </li>
                <li class="nav-item ms-auto">
                    <a class="nav-link" href="{{ route('faq') }}"><i class="bi bi-question-circle me-1"></i>FAQ</a>
                </li>
            </ul>
        </div>
    </div>
</header>
