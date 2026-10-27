@extends('layouts.admin')
@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>Product Reviews</h4>
</div>

<div class="admin-table p-3 mb-3">
    <form method="GET" class="row g-2">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr id="row-{{ $review->id }}">
                <td style="font-size:13px;">{{ $review->user->name ?? 'N/A' }}</td>
                <td style="font-size:13px;">{{ Str::limit($review->product->name ?? 'N/A', 25) }}</td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"
                           style="font-size:12px;"></i>
                    @endfor
                </td>
                <td style="font-size:12px;max-width:200px;">{{ Str::limit($review->comment, 60) }}</td>
                <td>
                    <span class="badge bg-{{ $review->status === 'approved' ? 'success' : ($review->status === 'rejected' ? 'danger' : 'warning') }}"
                          id="rev-status-{{ $review->id }}">
                        {{ ucfirst($review->status) }}
                    </span>
                </td>
                <td style="font-size:12px;">{{ $review->created_at->format('d M Y') }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-success approve-btn"
                        data-id="{{ $review->id }}"
                        data-url="{{ route('admin.reviews.updateStatus', $review) }}">
                        <i class="bi bi-check"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger reject-btn"
                        data-id="{{ $review->id }}"
                        data-url="{{ route('admin.reviews.updateStatus', $review) }}">
                        <i class="bi bi-x"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.reviews.destroy', $review) }}', '#row-{{ $review->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">No reviews found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $reviews->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
function updateReviewStatus(url, id, status) {
    $.ajax({
        url: url, type: 'PATCH',
        data: { status: status },
        success: function(res) {
            if (res.success) {
                const badge = $('#rev-status-' + id);
                badge.text(status.charAt(0).toUpperCase() + status.slice(1));
                badge.removeClass('bg-success bg-danger bg-warning')
                     .addClass(status === 'approved' ? 'bg-success' : status === 'rejected' ? 'bg-danger' : 'bg-warning');
                showToast(res.message);
            }
        }
    });
}

$(document).on('click', '.approve-btn', function() {
    updateReviewStatus($(this).data('url'), $(this).data('id'), 'approved');
});
$(document).on('click', '.reject-btn', function() {
    updateReviewStatus($(this).data('url'), $(this).data('id'), 'rejected');
});
</script>
@endpush