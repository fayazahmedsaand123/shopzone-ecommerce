<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — ShopZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 250px; --primary: #0d6efd; --dark: #1a1a2e; }
        body { background: #f0f2f5; }

        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--dark);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: block;
        }
        .sidebar-brand span { color: #ff6b35; }
        .sidebar-menu { padding: 12px 0; }
        .sidebar-label {
            color: rgba(255,255,255,.4);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 14px 20px 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.75);
            text-decoration: none;
            padding: 10px 20px;
            font-size: 13.5px;
            transition: all .2s;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,.08);
            border-left-color: var(--primary);
        }
        .sidebar-link i { font-size: 16px; width: 20px; }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .admin-topbar {
            background: #fff;
            padding: 14px 24px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .admin-content { padding: 24px; }

        /* Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e9ecef;
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Table */
        .admin-table { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e9ecef; }
        .admin-table .table { margin: 0; }
        .admin-table .table th { background: #f8f9fa; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; font-weight: 700; border-bottom: 2px solid #e9ecef; }
        .admin-table .table td { vertical-align: middle; font-size: 13.5px; }

        /* Page Header */
        .page-header { margin-bottom: 24px; }
        .page-header h4 { font-weight: 700; color: #1a1a2e; margin: 0; }
        .breadcrumb { margin: 0; font-size: 13px; }

        @media(max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <i class="bi bi-shop me-2"></i>Shop<span>Zone</span>
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
        <a href="#" class="sidebar-link">
            <i class="bi bi-people"></i> Customers
        </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-tag"></i> Coupons
        </a>

        <div class="sidebar-label">Content</div>
        <a href="#" class="sidebar-link">
            <i class="bi bi-star"></i> Reviews
        </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-envelope"></i> Messages
        </a>

        <div class="sidebar-label">System</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-shop"></i> View Store
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

{{-- Main --}}
<div class="admin-main">
    <div class="admin-topbar">
        <div>
            <span class="fw-semibold text-dark">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:13px;">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            </span>
        </div>
    </div>

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
@stack('scripts')
</body>
</html>