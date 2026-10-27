@extends('layouts.admin')
@section('title', 'Add Coupon')
@section('page-title', 'Add Coupon')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-table p-4">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coupon Code *</label>
                    <input type="text" name="code"
                        class="form-control font-monospace text-uppercase @error('code') is-invalid @enderror"
                        value="{{ old('code') }}" placeholder="e.g. SAVE20"
                        style="letter-spacing:2px;font-weight:700;">
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Will be saved in UPPERCASE automatically.</div>
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-secondary w-100" id="generate-code">
                        <i class="bi bi-arrow-clockwise me-1"></i>Generate Random Code
                    </button>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Type *</label>
                    <select name="type" class="form-select" id="coupon-type">
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (PKR)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Value *</label>
                    <div class="input-group">
                        <span class="input-group-text" id="type-symbol">%</span>
                        <input type="number" name="value"
                            class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value') }}" placeholder="e.g. 20" min="1" step="0.01">
                    </div>
                    @error('value')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Minimum Order Amount (PKR)</label>
                    <input type="number" name="min_order_amount" class="form-control"
                        value="{{ old('min_order_amount', 0) }}" placeholder="0 = no minimum" min="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Maximum Discount (PKR)</label>
                    <input type="number" name="max_discount" class="form-control"
                        value="{{ old('max_discount') }}" placeholder="Leave empty = no limit" min="0">
                    <div class="form-text">Only for percentage coupons.</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Usage Limit</label>
                    <input type="number" name="usage_limit" class="form-control"
                        value="{{ old('usage_limit') }}" placeholder="Leave empty = unlimited" min="1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Per Customer Limit</label>
                    <input type="number" name="per_user_limit" class="form-control"
                        value="{{ old('per_user_limit', 1) }}" min="1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="starts_at" class="form-control"
                        value="{{ old('starts_at') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Expiry Date</label>
                    <input type="date" name="expires_at" class="form-control"
                        value="{{ old('expires_at') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status *</label>
                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Save Coupon
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
// Update symbol
$('#coupon-type').on('change', function() {
    $('#type-symbol').text($(this).val() === 'percentage' ? '%' : '₨');
});

// Generate random code
$('#generate-code').on('click', function() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
    $('input[name="code"]').val(code);
});
</script>
@endpush