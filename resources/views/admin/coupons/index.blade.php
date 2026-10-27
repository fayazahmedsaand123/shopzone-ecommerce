@extends('layouts.admin')
@section('title', 'Coupons')
@section('page-title', 'Coupons')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>All Coupons</h4>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Coupon
    </a>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Used</th>
                <th>Expires</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr id="row-{{ $coupon->id }}">
                <td>
                    <span class="badge bg-dark fs-6 px-3 py-2 font-monospace">
                        {{ $coupon->code }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-info bg-opacity-10 text-info">
                        {{ ucfirst($coupon->type) }}
                    </span>
                </td>
                <td class="fw-bold text-danger">
                    @if($coupon->type === 'percentage')
                        {{ $coupon->value }}%
                    @else
                        PKR {{ number_format($coupon->value) }}
                    @endif
                </td>
                <td style="font-size:13px;">
                    {{ $coupon->min_order_amount > 0 ? 'PKR ' . number_format($coupon->min_order_amount) : '—' }}
                </td>
                <td>
                    <span class="text-muted" style="font-size:13px;">
                        {{ $coupon->used_count }}
                        @if($coupon->usage_limit)
                            / {{ $coupon->usage_limit }}
                        @else
                            / ∞
                        @endif
                    </span>
                </td>
                <td style="font-size:12px;">
                    @if($coupon->expires_at)
                        @if($coupon->expires_at->isPast())
                            <span class="text-danger">{{ $coupon->expires_at->format('d M Y') }} (Expired)</span>
                        @else
                            <span class="text-success">{{ $coupon->expires_at->format('d M Y') }}</span>
                        @endif
                    @else
                        <span class="text-muted">No expiry</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $coupon->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($coupon->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.coupons.destroy', $coupon) }}', '#row-{{ $coupon->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    No coupons yet. <a href="{{ route('admin.coupons.create') }}">Create one</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $coupons->links() }}</div>
</div>
@endsection