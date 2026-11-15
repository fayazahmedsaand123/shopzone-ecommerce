@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@php
$statusMeta = [
    ['label' => 'Pending',    'color' => '#f5a524'],
    ['label' => 'Confirmed',  'color' => '#22d3ee'],
    ['label' => 'Processing', 'color' => '#7c5cff'],
    ['label' => 'Shipped',    'color' => '#a855f7'],
    ['label' => 'Delivered',  'color' => '#22c55e'],
    ['label' => 'Cancelled',  'color' => '#ef4444'],
];
$totalStatus = array_sum($orderStatusData);
$adminName = auth()->user()->name;
@endphp

@push('styles')
<style>
    /* ── Page head ─────────────────────────── */
    .dash-head {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-bottom: 22px;
    }
    .eyebrow {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--brand);
        font-weight: 800;
        margin-bottom: 7px;
    }
    .dash-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 26px;
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: -.02em;
    }
    .dash-sub { color: var(--muted); font-size: 13.5px; margin: 7px 0 0; }
    .live-dot {
        display: inline-block;
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--success);
        box-shadow: 0 0 0 4px rgba(34, 197, 94, .15);
        margin-right: 7px;
        vertical-align: middle;
    }

    .attention {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        padding: 13px 18px;
        margin-bottom: 20px;
        border-radius: 14px;
        font-size: 13px;
        color: #f7c66b;
        background: linear-gradient(90deg, rgba(245, 165, 36, .14), rgba(245, 165, 36, .03));
        border: 1px solid rgba(245, 165, 36, .3);
    }
    .attention .btn { --bs-btn-padding-y: .3rem; --bs-btn-padding-x: .9rem; --bs-btn-font-size: 12px; }

    /* ── KPI cards ─────────────────────────── */
    .kpi {
        position: relative;
        overflow: hidden;
        height: 100%;
        padding: 20px;
        border-radius: 18px;
        border: 1px solid var(--line);
        background: linear-gradient(180deg, rgba(255, 255, 255, .045), rgba(255, 255, 255, .015));
        transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;
    }
    .kpi::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(420px 130px at 100% 0%, rgba(124, 92, 255, .16), transparent 70%);
        opacity: 0;
        transition: opacity .25s ease;
        pointer-events: none;
    }
    .kpi:hover { transform: translateY(-3px); border-color: rgba(124, 92, 255, .4); box-shadow: 0 18px 42px rgba(0, 0, 0, .38); }
    .kpi:hover::after { opacity: 1; }
    .kpi-label { font-size: 11px; letter-spacing: 1.2px; text-transform: uppercase; color: var(--muted); font-weight: 700; }
    .kpi-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 27px;
        color: #fff;
        margin: 9px 0 7px;
        letter-spacing: -.02em;
    }
    .kpi-foot { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 6px; }
    .kpi-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-size: 22px;
        color: #fff;
        flex-shrink: 0;
    }
    .kpi-icon.money    { background: linear-gradient(135deg, #22c55e, #15803d); box-shadow: 0 10px 24px rgba(34, 197, 94, .25); }
    .kpi-icon.orders   { background: linear-gradient(135deg, #f5a524, #f97316); box-shadow: 0 10px 24px rgba(245, 165, 36, .25); }
    .kpi-icon.users    { background: linear-gradient(135deg, #38bdf8, #6366f1); box-shadow: 0 10px 24px rgba(56, 189, 248, .22); }
    .kpi-icon.products { background: linear-gradient(135deg, #f472b6, #a855f7); box-shadow: 0 10px 24px rgba(244, 114, 182, .22); }
    .trend-up     { color: var(--success); }
    .trend-warn   { color: var(--warning); }
    .trend-info   { color: #38bdf8; }
    .trend-danger { color: #f87171; }

    /* ── Panels ────────────────────────────── */
    .card-block {
        height: 100%;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid var(--line);
        background: var(--surface);
    }
    .card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }
    .card-head h6 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 15px;
        color: #fff;
        margin: 0;
    }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: #b9a5ff;
        background: rgba(124, 92, 255, .12);
        border: 1px solid rgba(124, 92, 255, .25);
    }
    .chart-wrap { position: relative; height: 300px; }
    .chart-wrap.sm { height: 244px; }

    .donut-wrap {
        position: relative;
        height: 232px;
        max-width: 232px;
        margin: 0 auto;
        display: grid;
        place-items: center;
    }
    .donut-center { position: absolute; text-align: center; pointer-events: none; }
    .donut-center .n { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 30px; color: #fff; line-height: 1; }
    .donut-center .l { font-size: 10.5px; text-transform: uppercase; letter-spacing: 1.3px; color: var(--muted); margin-top: 6px; }

    .legend-row { padding: 7px 0; font-size: 12.5px; }
    .legend-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; margin-right: 8px; }
    .legend-bar { height: 5px; border-radius: 99px; background: rgba(255, 255, 255, .06); margin-top: 6px; overflow: hidden; }
    .legend-bar > span { display: block; height: 100%; border-radius: 99px; }

    /* ── Top products ──────────────────────── */
    .top-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid var(--line);
    }
    .top-item:last-child { border-bottom: 0; padding-bottom: 0; }
    .rank {
        width: 24px; height: 24px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        font-size: 11px;
        font-weight: 800;
        color: #cbd5e1;
        background: rgba(255, 255, 255, .05);
        flex-shrink: 0;
    }
    .top-item img { width: 42px; height: 42px; border-radius: 10px; object-fit: cover; flex-shrink: 0; }
    .sold-pill {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: #b9a5ff;
        background: rgba(124, 92, 255, .12);
        border: 1px solid rgba(124, 92, 255, .22);
        white-space: nowrap;
    }

    /* ── Table ─────────────────────────────── */
    .dash-table {
        margin: 0;
        --bs-table-bg: transparent;
        --bs-table-color: var(--text);
        --bs-table-border-color: var(--line);
        --bs-table-hover-bg: rgba(255, 255, 255, .03);
        --bs-table-hover-color: #fff;
    }
    .dash-table thead th {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--muted);
        font-weight: 700;
        border-bottom: 1px solid var(--line);
        background: transparent;
        padding-bottom: 10px;
        white-space: nowrap;
    }
    .dash-table td { font-size: 13px; vertical-align: middle; border-color: var(--line); }
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .cust-dot {
        width: 30px; height: 30px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--brand), var(--brand-2));
        flex-shrink: 0;
    }
    .empty-hint { text-align: center; padding: 34px 10px; color: var(--muted); }
    .empty-hint i { font-size: 34px; display: block; margin-bottom: 8px; color: rgba(255, 255, 255, .18); }

    @media (max-width: 575.98px) {
        .dash-title { font-size: 22px; }
        .kpi-value { font-size: 24px; }
    }
</style>
@endpush

@section('content')

{{-- ── Header ───────────────────────────────── --}}
<div class="dash-head">
    <div>
        <div class="eyebrow">Admin overview</div>
        <h1 class="dash-title">Welcome back, {{ $adminName }}</h1>
        <p class="dash-sub"><span class="live-dot"></span>Here's what's happening in your store — {{ now()->format('l, d M Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add Product
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-bag me-1"></i>All Orders
        </a>
    </div>
</div>

@if($stats['pending_orders'] > 0)
<div class="attention">
    <i class="bi bi-exclamation-circle-fill"></i>
    <span class="flex-grow-1">
        <strong>{{ $stats['pending_orders'] }}</strong> {{ Str::plural('order', $stats['pending_orders']) }} awaiting confirmation.
    </span>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Review now</a>
</div>
@endif

{{-- ── KPI Cards ────────────────────────────── --}}
<div class="row g-3 mb-3">
    <div class="col-xl-3 col-md-6">
        <div class="kpi">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Total Revenue</div>
                    <div class="kpi-value">PKR {{ number_format($stats['total_revenue']) }}</div>
                    <div class="kpi-foot">
                        <span class="trend-up"><i class="bi bi-arrow-up-right"></i></span>
                        Delivered &amp; in-progress orders
                    </div>
                </div>
                <div class="kpi-icon money"><i class="bi bi-currency-dollar"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Total Orders</div>
                    <div class="kpi-value">{{ number_format($stats['total_orders']) }}</div>
                    <div class="kpi-foot">
                        <span class="trend-warn"><i class="bi bi-clock"></i></span>
                        {{ $stats['today_orders'] }} today · {{ $stats['pending_orders'] }} pending
                    </div>
                </div>
                <div class="kpi-icon orders"><i class="bi bi-bag-check"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Customers</div>
                    <div class="kpi-value">{{ number_format($stats['total_customers']) }}</div>
                    <div class="kpi-foot">
                        <span class="trend-info"><i class="bi bi-people"></i></span>
                        Registered shoppers
                    </div>
                </div>
                <div class="kpi-icon users"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Products</div>
                    <div class="kpi-value">{{ number_format($stats['total_products']) }}</div>
                    <div class="kpi-foot">
                        <span class="trend-danger"><i class="bi bi-exclamation-triangle"></i></span>
                        {{ $stats['low_stock'] }} low stock · {{ $stats['total_categories'] }} categories
                    </div>
                </div>
                <div class="kpi-icon products"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- ── Revenue + Status ─────────────────────── --}}
<div class="row g-3 mb-3">
    <div class="col-xl-8">
        <div class="card-block">
            <div class="card-head">
                <h6>Revenue — Last 7 Days</h6>
                <span class="chip"><i class="bi bi-graph-up"></i>Daily Sales</span>
            </div>
            <div class="chart-wrap">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card-block">
            <div class="card-head">
                <h6>Order Status</h6>
                <span class="chip">{{ $totalStatus }} total</span>
            </div>
            <div class="donut-wrap">
                <canvas id="statusChart"></canvas>
                <div class="donut-center">
                    <div class="n">{{ $totalStatus }}</div>
                    <div class="l">Orders</div>
                </div>
            </div>
            <div class="mt-2">
                @foreach($statusMeta as $i => $meta)
                    @php
                        $count = $orderStatusData[$i] ?? 0;
                        $pct   = $totalStatus > 0 ? round($count / $totalStatus * 100) : 0;
                    @endphp
                    <div class="legend-row">
                        <div class="legend-top">
                            <span><span class="legend-dot" style="background:{{ $meta['color'] }};"></span>{{ $meta['label'] }}</span>
                            <span class="fw-semibold" style="color:#cfd5e4;">{{ $count }}</span>
                        </div>
                        <div class="legend-bar"><span style="width:{{ $pct }}%;background:{{ $meta['color'] }};"></span></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Monthly + Top products ───────────────── --}}
<div class="row g-3 mb-3">
    <div class="col-xl-7">
        <div class="card-block">
            <div class="card-head">
                <h6>Monthly Revenue</h6>
                <span class="chip">Last 6 months</span>
            </div>
            <div class="chart-wrap sm">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card-block">
            <div class="card-head">
                <h6>Top Selling Products</h6>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Manage</a>
            </div>

            @forelse($top_products as $i => $product)
            <div class="top-item">
                <div class="rank">{{ $i + 1 }}</div>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                <div class="flex-grow-1" style="min-width:0;">
                    <div class="fw-semibold text-truncate" style="font-size:13px;color:#e9edf7;">{{ $product->name }}</div>
                    <div style="font-size:11.5px;color:var(--muted);">PKR {{ number_format($product->price) }}</div>
                </div>
                <span class="sold-pill">{{ $product->order_items_count }} sold</span>
            </div>
            @empty
            <div class="empty-hint">
                <i class="bi bi-box"></i>
                No sales data yet.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Recent Orders ────────────────────────── --}}
<div class="card-block">
    <div class="card-head">
        <h6>Recent Orders</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table dash-table align-middle">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                @php
                    $tone = [
                        'pending'    => ['#f5a524', 'rgba(245,165,36,.13)', 'rgba(245,165,36,.28)'],
                        'confirmed'  => ['#22d3ee', 'rgba(34,211,238,.12)', 'rgba(34,211,238,.28)'],
                        'processing' => ['#9d8bff', 'rgba(124,92,255,.14)', 'rgba(124,92,255,.3)'],
                        'shipped'    => ['#c084fc', 'rgba(168,85,247,.14)', 'rgba(168,85,247,.3)'],
                        'delivered'  => ['#4ade80', 'rgba(34,197,94,.13)', 'rgba(34,197,94,.3)'],
                        'cancelled'  => ['#f87171', 'rgba(239,68,68,.13)', 'rgba(239,68,68,.3)'],
                    ][$order->status] ?? ['#94a3b8', 'rgba(148,163,184,.12)', 'rgba(148,163,184,.25)'];
                @endphp
                <tr>
                    <td><span class="fw-semibold">#{{ $order->order_number }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="cust-dot">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</span>
                            <span>{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="fw-semibold" style="color:#f5a524;">PKR {{ number_format($order->total) }}</td>
                    <td>
                        <span class="pill" style="color:#cbd5e1;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </td>
                    <td>
                        <span class="pill" style="color:{{ $tone[0] }};background:{{ $tone[1] }};border:1px solid {{ $tone[2] }};">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="color:var(--muted);">{{ $order->created_at->format('d M, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary" title="View order">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-hint">
                            <i class="bi bi-inbox"></i>
                            No orders yet.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.color = '#8b93a7';
    Chart.defaults.borderColor = 'rgba(255,255,255,.06)';
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.size = 11;

    const brand = '#7c5cff';
    const tooltipStyle = {
        backgroundColor: '#0f172a',
        borderColor: 'rgba(255,255,255,.12)',
        borderWidth: 1,
        cornerRadius: 10,
        padding: 10,
        displayColors: false,
        titleColor: '#fff',
        bodyColor: '#cbd5e1',
        titleFont: { weight: '600' }
    };
    const moneyTick = v => 'PKR ' + (v >= 1000 ? (v / 1000).toFixed(0) + 'K' : v);

    // ── Revenue line ─────────────────────────────
    const salesEl = document.getElementById('salesChart');
    const salesGrad = salesEl.getContext('2d').createLinearGradient(0, 0, 0, 300);
    salesGrad.addColorStop(0, 'rgba(124,92,255,.38)');
    salesGrad.addColorStop(1, 'rgba(124,92,255,0)');

    new Chart(salesEl, {
        type: 'line',
        data: {
            labels: @json($salesLabels),
            datasets: [{
                label: 'Revenue (PKR)',
                data: @json($salesData),
                borderColor: brand,
                backgroundColor: salesGrad,
                borderWidth: 3,
                tension: .42,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: brand,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipStyle,
                    callbacks: { label: ctx => 'PKR ' + ctx.parsed.y.toLocaleString() }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: 'rgba(255,255,255,.05)', drawTicks: false },
                    ticks: { callback: moneyTick, padding: 8, precision: 0 }
                },
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: { padding: 6 }
                }
            }
        }
    });

    // ── Order status doughnut ────────────────────
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
            datasets: [{
                data: @json($orderStatusData),
                backgroundColor: ['#f5a524', '#22d3ee', '#7c5cff', '#a855f7', '#22c55e', '#ef4444'],
                borderColor: '#111827',
                borderWidth: 3,
                hoverOffset: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '74%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipStyle,
                    callbacks: { label: ctx => ' ' + ctx.parsed + ' orders' }
                }
            }
        }
    });

    // ── Monthly revenue bars ─────────────────────
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Revenue (PKR)',
                data: @json($monthlyRevenue),
                backgroundColor: 'rgba(124,92,255,.72)',
                hoverBackgroundColor: '#9d8bff',
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 34,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipStyle,
                    callbacks: { label: ctx => 'PKR ' + ctx.parsed.y.toLocaleString() }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: 'rgba(255,255,255,.05)', drawTicks: false },
                    ticks: { callback: moneyTick, padding: 8, precision: 0 }
                },
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: { padding: 6 }
                }
            }
        }
    });
</script>
@endpush
