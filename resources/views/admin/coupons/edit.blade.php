@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-table p-4">

            {{-- Stats Bar --}}
            <div class="row g-3 mb-4 pb-3 border-bottom">
                <div class="col-4 text-center">
                    <div class="text-primary fw-bold fs-4">{{ $coupon->used_count }}</div>
                    <div class="text-muted" style="font-size:12px;">Times Used</div>
                </div>
                <div class="col-4 text-center">
                    <div class="text-success fw-bold fs-4">
                        {{ $coupon->usage_limit ? $coupon->usage_limit - $coupon->used_count : '∞' }}
                    </div>
                    <div class="text-muted" style="font-size:12px;">Remaining Uses</div>
                </div>
                <div class="col-4 text-center">
                    <div class="fw-bold fs-4">
                        @if($coupon->expires_at)
                            @if($coupon->expires_at->isPast())
                                <span class="text-danger">Expired</span>
                            @else
                                <span class="text-success">Active</span>
                            @endif
                        @else
                            <span class="text-success">Active</span>
                        @endif
                    </div>
                    <div class="text-muted" style="font-size:12px;">Validity</div>
                </div>
            </div>

            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coupon Code *</label>
                    <input type="text" name="code"
                        class="form-control font-monospace text-uppercase @error('code') is-invalid @enderror"
                        value="{{ old('code', $coupon->code) }}"
                        style="letter-spacing:2px;font-weight:700;">
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Type *</label>
                    <select name="type" class="form-select" id="coupon-type">
                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount (PKR)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Value *</label>
                    <div class="input-group">
                        <span class="input-group-text" id="type-symbol">
                            {{ $coupon->type === 'percentage' ? '%' : '₨' }}
                        </span>
                        <input type="number" name="value" class="form-control"
                            value="{{ old('value', $coupon->value) }}" min="1" step="0.01">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Minimum Order (PKR)</label>
                    <input type="number" name="min_order_amount" class="form-control"
                        value="{{ old('min_order_amount', $coupon->min_order_amount) }}" min="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Max Discount (PKR)</label>
                    <input type="number" name="max_discount" class="form-control"
                        value="{{ old('max_discount', $coupon->max_discount) }}" min="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Usage Limit</label>
                    <input type="number" name="usage_limit" class="form-control"
                        value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Per Customer Limit</label>
                    <input type="number" name="per_user_limit" class="form-control"
                        value="{{ old('per_user_limit', $coupon->per_user_limit) }}" min="1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="starts_at" class="form-control"
                        value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Expiry Date</label>
                    <input type="date" name="expires_at" class="form-control"
                        value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status *</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $coupon->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $coupon->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Update Coupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#coupon-type').on('change', function() {
    $('#type-symbol').text($(this).val() === 'percentage' ? '%' : '₨');
});
</script>
@endpush