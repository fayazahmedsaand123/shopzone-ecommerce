@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.stat-card-new {
    background: #fff;
    border-radius: 16px;
    padding: 22px;
    border: 1px solid #eef0f4;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    transition: all .25s;
    position: relative;
    overflow: hidden;
}
.stat-card-new:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1); transform: translateY(-2px); }
.stat-card-new .stat-icon-new {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.stat-card-new .stat-wave {
    position: absolute;
    bottom: -10px; right: -10px;
    font-size: 80px;
    opacity: .06;
}
.chart-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #eef0f4;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    height: 100%;
}
.chart-card h6 {
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 20px;
    font-size: 15px;
}
.recent-order-row { transition: background .15s; }
.recent-order-row:hover { background: #f8f9ff; }
.top-product-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}
.top-product-item:last-child { border-bottom: none; }
</style>
@endpush

@section('content')

{{-- ── Stats Row ───────────────────────────── --}}
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted mb-1" style="font-size:12px;text-transform:uppercase;letter-spacing:.8px;">Total Revenue</div>
                    <div class="fw-bold" style="font-size:26px;color:#1a1a2e;">
                        PKR {{ number_format($stats['total_revenue']) }}
                    </div>
                    <div class="text-success mt-1" style="font-size:12px;">
                        <i class="bi bi-arrow-up-right me-1"></i>From delivered orders
                    </div>
                </div>
                <div class="stat-icon-new" style="background:#e8f5e9;">
                    <i class="bi bi-currency-dollar text-success"></i>
                </div>
            </div>
            <i class="bi bi-currency-dollar stat-wave text-success"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted mb-1" style="font-size:12px;text-transform:uppercase;letter-spacing:.8px;">Total Orders</div>
                    <div class="fw-bold" style="font-size:26px;color:#1a1a2e;">{{ $stats['total_orders'] }}</div>
                    <div class="text-warning mt-1" style="font-size:12px;">
                        <i class="bi bi-clock me-1"></i>{{ $stats['pending_orders'] }} pending
                    </div>
                </div>
                <div class="stat-icon-new" style="background:#fff3e0;">
                    <i class="bi bi-bag-check text-warning"></i>
                </div>
            </div>
            <i class="bi bi-bag stat-wave text-warning"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted mb-1" style="font-size:12px;text-transform:uppercase;letter-spacing:.8px;">Customers</div>
                    <div class="fw-bold" style="font-size:26px;color:#1a1a2e;">{{ $stats['total_customers'] }}</div>
                    <div class="text-info mt-1" style="font-size:12px;">
                        <i class="bi bi-people me-1"></i>Registered users
                    </div>
                </div>
                <div class="stat-icon-new" style="background:#e3f2fd;">
                    <i class="bi bi-people text-info"></i>
                </div>
            </div>
            <i class="bi bi-people stat-wave text-info"></i>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card-new">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted mb-1" style="font-size:12px;text-transform:uppercase;letter-spacing:.8px;">Products</div>
                    <div class="fw-bold" style="font-size:26px;color:#1a1a2e;">{{ $stats['total_products'] }}</div>
                    <div class="text-danger mt-1" style="font-size:12px;">
                        <i class="bi bi-exclamation-triangle me-1"></i>{{ $stats['low_stock'] }} low stock
                    </div>
                </div>
                <div class="stat-icon-new" style="background:#fce4ec;">
                    <i class="bi bi-box-seam text-danger"></i>
                </div>
            </div>
            <i class="bi bi-box stat-wave text-danger"></i>
        </div>
    </div>
</div>

{{-- ── Charts Row 1 ────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Sales Line Chart --}}
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Revenue — Last 7 Days</h6>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2" style="font-size:12px;">
                    <i class="bi bi-graph-up me-1"></i>Daily Sales
                </span>
            </div>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    {{-- Order Status Doughnut --}}
    <div class="col-lg-4">
        <div class="chart-card">
            <h6>Order Status Breakdown</h6>
            <canvas id="statusChart" height="200"></canvas>
            <div class="mt-3">
                @php
                $statusColors = ['#ffc107','#0dcaf0','#0d6efd','#6610f2','#198754','#dc3545'];
                $statusLabels = ['Pending','Confirmed','Processing','Shipped','Delivered','Cancelled'];
                @endphp
                @foreach($statusLabels as $i => $label)
                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size:12px;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:10px;height:10px;border-radius:50%;background:{{ $statusColors[$i] }};"></div>
                        {{ $label }}
                    </div>
                    <span class="fw-bold">{{ $orderStatusData[$i] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── Charts Row 2 ────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Monthly Revenue Bar Chart --}}
    <div class="col-lg-7">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Monthly Revenue (Last 6 Months)</h6>
            </div>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-5">
        <div class="chart-card">
            <h6>Top Selling Products</h6>
            @forelse($top_products as $i => $product)
            <div class="top-product-item">
                <div class="fw-bold text-muted" style="width:20px;font-size:13px;">#{{ $i+1 }}</div>
                <img src="{{ $product->main_image ? asset('storage/'.$product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=40' }}"
                    width="40" height="40" class="rounded" style="object-fit:cover;flex-shrink:0;">
                <div class="flex-grow-1" style="min-width:0;">
                    <div class="fw-semibold text-truncate" style="font-size:13px;">{{ $product->name }}</div>
                    <div class="text-muted" style="font-size:11px;">PKR {{ number_format($product->price) }}</div>
                </div>
                <div class="text-end flex-shrink-0">
                    <div class="fw-bold text-primary" style="font-size:13px;">{{ $product->order_items_count }}</div>
                    <div class="text-muted" style="font-size:11px;">sold</div>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <i class="bi bi-box fs-1 d-block mb-2" style="color:#ddd;"></i>
                No sales data yet.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Recent Orders Table ──────────────────── --}}
<div class="chart-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Recent Orders</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr style="background:#f8f9fa;">
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Order #</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Customer</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Total</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Payment</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Status</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Date</th>
                    <th style="font-size:11px;text-transform:uppercase;color:#6c757d;font-weight:700;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                @php
                $statusColor = [
                    'pending'    => 'warning',
                    'confirmed'  => 'info',
                    'processing' => 'primary',
                    'shipped'    => 'primary',
                    'delivered'  => 'success',
                    'cancelled'  => 'danger',
                ][$order->status] ?? 'secondary';
                @endphp
                <tr class="recent-order-row">
                    <td>
                        <span class="fw-bold" style="font-size:13px;">#{{ $order->order_number }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                style="width:30px;height:30px;font-size:11px;flex-shrink:0;">
                                {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-size:13px;">{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="fw-bold" style="font-size:13px;color:#ff6b35;">
                        PKR {{ number_format($order->total) }}
                    </td>
                    <td>
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_method) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $statusColor }} bg-opacity-15 text-{{ $statusColor }}"
                              style="font-size:11px;padding:5px 10px;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#6c757d;">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="btn btn-sm btn-outline-primary" style="border-radius:8px;">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2" style="color:#ddd;"></i>
                        No orders yet.
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
const primaryColor = '#0d6efd';
const accentColor  = '#ff6b35';

// ── Sales Line Chart ──────────────────────────
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: @json($salesLabels),
        datasets: [{
            label: 'Revenue (PKR)',
            data: @json($salesData),
            borderColor: primaryColor,
            backgroundColor: 'rgba(13,110,253,.08)',
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: primaryColor,
            pointRadius: 4,
            pointHoverRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'PKR ' + ctx.parsed.y.toLocaleString()
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,.04)' },
                ticks: {
                    callback: v => 'PKR ' + (v >= 1000 ? (v/1000).toFixed(0)+'K' : v),
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});

// ── Order Status Doughnut ─────────────────────
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending','Confirmed','Processing','Shipped','Delivered','Cancelled'],
        datasets: [{
            data: @json($orderStatusData),
            backgroundColor: ['#ffc107','#0dcaf0','#0d6efd','#6610f2','#198754','#dc3545'],
            borderWidth: 2,
            borderColor: '#fff',
            hoverBorderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { display: false },
        }
    }
});

// ── Monthly Revenue Bar Chart ─────────────────
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Revenue (PKR)',
            data: @json($monthlyRevenue),
            backgroundColor: [
                'rgba(13,110,253,.7)',
                'rgba(255,107,53,.7)',
                'rgba(25,135,84,.7)',
                'rgba(13,202,240,.7)',
                'rgba(255,193,7,.7)',
                'rgba(111,66,193,.7)',
            ],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'PKR ' + ctx.parsed.y.toLocaleString()
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,.04)' },
                ticks: {
                    callback: v => 'PKR ' + (v >= 1000 ? (v/1000).toFixed(0)+'K' : v),
                    font: { size: 11 }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});
</script>
@endpush