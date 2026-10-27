{{-- TOP UTILITY BAR --}}
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <span><i class="bi bi-truck me-1"></i>Free shipping over PKR 5,000</span>
                <a href="{{ route('home') }}">Daily Deals</a>
                <a href="#">Help & Contact</a>
            </div>
            <div class="d-flex gap-3 align-items-center">
                @auth
                    <span>Welcome, {{ auth()->user()->name }}</span>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:#ccc;cursor:pointer;font-size:12px;padding:0;">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- MAIN NAVBAR --}}
<nav class="main-navbar">
    <div class="container">
        <div class="d-flex align-items-center gap-3">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="navbar-brand-text me-3">
                Shop<span>Zone</span>
            </a>

            {{-- Category Dropdown --}}
            <div class="dropdown category-dropdown d-none d-lg-block">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-grid me-1"></i>Categories
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-laptop me-2"></i>Electronics</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-phone me-2"></i>Mobile Phones</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-house me-2"></i>Home & Living</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-bag me-2"></i>Fashion</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-primary" href="#">View All Categories</a></li>
                </ul>
            </div>

            {{-- Search Bar --}}
            <div class="flex-grow-1 position-relative" id="search-container">
                <div class="search-wrapper">
                    <select class="search-category d-none d-md-block" id="search-category-select">
                        <option value="">All Categories</option>
                        <option>Electronics</option>
                        <option>Fashion</option>
                        <option>Home & Living</option>
                        <option>Mobiles</option>
                    </select>
                    <input
                        type="text"
                        class="search-input"
                        id="search-input"
                        placeholder="Search for products, brands..."
                        autocomplete="off"
                    >
                    <button class="search-btn" id="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                {{-- AJAX Suggestions --}}
                <div class="search-suggestions" id="search-suggestions"></div>
            </div>

            {{-- Right Icons --}}
            <div class="d-flex align-items-center gap-1 ms-2">

                {{-- Wishlist --}}
                <a href="{{ auth()->check() ? route('customer.wishlist.index') : route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-heart"></i>
                    <span class="nav-badge" id="wishlist-count">
                        {{ auth()->check() ? auth()->user()->wishlist()->count() : 0 }}
                    </span>
                    <span class="d-none d-lg-block">Wishlist</span>
                </a>

                {{-- Cart --}}
                <a href="{{ auth()->check() ? route('customer.cart.index') : route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-cart3"></i>
                    <span class="nav-badge" id="cart-count">
                        {{ auth()->check() ? auth()->user()->cart()->sum('quantity') : 0 }}
                    </span>
                    <span class="d-none d-lg-block">Cart</span>
                </a>

                {{-- Account --}}
                @auth
                <div class="dropdown">
                    <a href="#" class="nav-icon-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-lg-block">Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                        <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-heart me-2"></i>Wishlist</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="nav-icon-btn">
                    <i class="bi bi-person"></i>
                    <span class="d-none d-lg-block">Login</span>
                </a>
                @endauth

                {{-- Mobile Menu Toggle --}}
                <button class="btn btn-sm btn-outline-primary d-lg-none ms-1" id="mobile-menu-btn">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- MOBILE SEARCH BAR --}}
<div class="mobile-search-bar" id="mobile-search-bar">
    <div class="search-wrapper">
        <input type="text" class="search-input" placeholder="Search products...">
        <button class="search-btn"><i class="bi bi-search"></i></button>
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
                <a class="nav-link" href="{{ route('products.index') }}">All Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">New Arrivals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Best Sellers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" style="color:#ffd700 !important; font-weight:700;">
                    <i class="bi bi-lightning-fill me-1"></i>Deals & Offers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Brands</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
            </li>
        </ul>
    </div>
</div>