@extends('layouts.admin')
@section('title', 'Customers')
@section('page-title', 'Customers')

@section('content')
<div class="page-header">
    <h4>All Customers</h4>
</div>

<div class="admin-table p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                placeholder="Search name or email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Email</th>
                <th>Orders</th>
                <th>Joined</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr id="row-{{ $customer->id }}">
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                            style="width:36px;height:36px;font-size:14px;flex-shrink:0;">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:13px;">{{ $customer->name }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;">{{ $customer->email }}</td>
                <td><span class="badge bg-primary">{{ $customer->orders_count }}</span></td>
                <td style="font-size:12px;">{{ $customer->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'danger' }}"
                          id="status-{{ $customer->id }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-warning toggle-status-btn"
                        data-url="{{ route('admin.customers.toggleStatus', $customer) }}"
                        data-id="{{ $customer->id }}">
                        <i class="bi bi-toggle-on"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">No customers found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $customers->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.toggle-status-btn', function () {
    const url = $(this).data('url');
    const id  = $(this).data('id');

    $.ajax({
        url: url, type: 'PATCH',
        success: function (res) {
            if (res.success) {
                const badge = $('#status-' + id);
                badge.text(res.status.charAt(0).toUpperCase() + res.status.slice(1));
                badge.removeClass('bg-success bg-danger')
                     .addClass(res.status === 'active' ? 'bg-success' : 'bg-danger');
                showToast(res.message);
            }
        }
    });
});
</script>
@endpush