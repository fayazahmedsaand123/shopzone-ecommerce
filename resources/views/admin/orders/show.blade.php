@extends('layouts.admin')
@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Order #{{ $order->order_number }}</h5>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">

        {{-- Items --}}
        <div class="admin-table mb-4">
            <div class="p-3 border-bottom"><h6 class="mb-0 fw-bold">Order Items</h6></div>
            <table class="table align-middle mb-0">
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td width="60">
                            <img src="{{ $item->product ? $item->product->image_url : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60' }}"
                                width="50" height="50" class="rounded" style="object-fit:cover;">
                        </td>
                        <td>
                            <div class="fw-semibold" style="font-size:13px;">{{ $item->product_name }}</div>
                            <div class="text-muted" style="font-size:12px;">{{ $item->product_sku }}</div>
                        </td>
                        <td class="text-muted" style="font-size:13px;">
                            PKR {{ number_format($item->price) }} × {{ $item->quantity }}
                        </td>
                        <td class="fw-bold text-end">PKR {{ number_format($item->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Update Status --}}
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3">Update Order Status</h6>
            <div class="row g-2">
                <div class="col-md-5">
                    <select class="form-select" id="new-status">
                        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="status-comment" placeholder="Comment (optional)">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" id="update-status-btn">Update</button>
                </div>
            </div>
            <div id="status-result" class="mt-2"></div>
        </div>

        {{-- Timeline --}}
        <div class="admin-table p-4">
            <h6 class="fw-bold mb-3">Order Timeline</h6>
            @foreach($order->statusHistories as $h)
            <div class="d-flex gap-3 mb-3">
                <i class="bi bi-check-circle-fill text-primary mt-1"></i>
                <div>
                    <div class="fw-semibold" style="font-size:13px;">{{ ucfirst($h->status) }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $h->comment }}</div>
                    <div class="text-muted" style="font-size:11px;">{{ $h->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Summary --}}
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 pb-2 border-bottom">Order Summary</h6>
            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                <span class="text-muted">Subtotal</span>
                <span>PKR {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                <span class="text-muted">Shipping</span>
                <span>{{ $order->shipping_amount == 0 ? 'FREE' : 'PKR '.number_format($order->shipping_amount) }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span class="fw-bold">Total</span>
                <span class="fw-bold text-danger">PKR {{ number_format($order->total) }}</span>
            </div>
        </div>

        {{-- Customer --}}
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 pb-2 border-bottom">Customer</h6>
            <div style="font-size:13px;">
                <div class="fw-semibold">{{ $order->user->name ?? 'N/A' }}</div>
                <div class="text-muted">{{ $order->user->email ?? '' }}</div>
            </div>
        </div>

        {{-- Shipping --}}
        <div class="admin-table p-4">
            <h6 class="fw-bold mb-3 pb-2 border-bottom">Payment Details</h6>
            <div style="font-size:13px;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Method</span>
                    <span class="fw-bold text-uppercase">{{ str_replace('_',' ',$order->payment_method) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status</span>
                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                @if($order->transaction_id)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Transaction ID</span>
                    <span class="fw-bold font-monospace">{{ $order->transaction_id }}</span>
                </div>
                @endif
                @if($order->account_number)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Account #</span>
                    <span class="fw-bold">{{ $order->account_number }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $('#update-status-btn').on('click', function () {
            const status  = $('#new-status').val();
            const comment = $('#status-comment').val();
            const btn     = $(this);

            btn.prop('disabled', true).text('Updating...');

            $.ajax({
                url: '{{ route("admin.orders.updateStatus", $order) }}',
                type: 'PATCH',
                data: { status: status, comment: comment },
                success: function (res) {
                    if (res.success) {
                        showToast(res.message);
                        $('#status-result').html(
                            '<div class="alert alert-success py-2 mb-0">' + res.message + '</div>'
                        );
                        setTimeout(() => location.reload(), 1000);
                    }
                },
                error: function () { showToast('Update failed.', 'error'); },
                complete: function () { btn.prop('disabled', false).text('Update'); }
            });
        });
    </script>
@endpush