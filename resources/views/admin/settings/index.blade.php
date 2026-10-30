@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Store Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="admin-table p-4">
            <h6 class="fw-bold mb-1">
                <i class="bi bi-envelope-fill text-primary me-2"></i>
                Order Notification Emails
            </h6>
            <p class="text-muted mb-4" style="font-size:13px;">
                All emails below will receive a notification when a new order is placed.
            </p>

            {{-- Add Email Form --}}
            <div class="d-flex gap-2 mb-4">
                <input type="email" id="new-email" class="form-control"
                    placeholder="e.g. aliraza@gmail.com">
                <button class="btn btn-primary px-4 flex-shrink-0" id="add-email-btn">
                    <i class="bi bi-plus-lg me-1"></i>Add Email
                </button>
            </div>

            <div id="email-result" class="mb-3"></div>

            {{-- Email List --}}
            <div id="email-list">
                @forelse($emailList as $email)
                <div class="d-flex align-items-center justify-content-between
                    bg-light rounded-3 px-3 py-2 mb-2 email-item"
                    id="item-{{ md5($email) }}">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary text-white d-flex
                            align-items-center justify-content-center fw-bold"
                            style="width:34px;height:34px;font-size:13px;flex-shrink:0;">
                            {{ strtoupper(substr($email, 0, 1)) }}
                        </div>
                        <span style="font-size:14px;">{{ $email }}</span>
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-email-btn"
                        data-email="{{ $email }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                @empty
                <div class="text-center py-4 text-muted" id="empty-state">
                    <i class="bi bi-envelope-slash fs-1 d-block mb-2" style="color:#ddd;"></i>
                    No notification emails added yet.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
// Add Email
$('#add-email-btn').on('click', function () {
    const email = $('#new-email').val().trim();
    if (!email) { showToast('Please enter an email address.', 'error'); return; }

    const btn = $(this);
    btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Adding...');

    $.post('{{ route("admin.settings.email.add") }}', { email: email }, function (res) {
        if (res.success) {
            showToast(res.message);
            $('#new-email').val('');
            $('#empty-state').remove();

            // Add to list
            const initial = email.charAt(0).toUpperCase();
            const hash    = btoa(email).replace(/[^a-z0-9]/gi, '').substring(0, 10);
            $('#email-list').append(`
                <div class="d-flex align-items-center justify-content-between
                    bg-light rounded-3 px-3 py-2 mb-2 email-item"
                    id="item-${hash}">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary text-white d-flex
                            align-items-center justify-content-center fw-bold"
                            style="width:34px;height:34px;font-size:13px;flex-shrink:0;">
                            ${initial}
                        </div>
                        <span style="font-size:14px;">${email}</span>
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-email-btn"
                        data-email="${email}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `);
        } else {
            showToast(res.message, 'error');
        }
    }).always(function() {
        btn.prop('disabled', false).html('<i class="bi bi-plus-lg me-1"></i>Add Email');
    });
});

// Remove Email
$(document).on('click', '.remove-email-btn', function () {
    const email = $(this).data('email');
    if (!confirm('Remove ' + email + '?')) return;

    const btn = $(this);
    $.ajax({
        url: '{{ route("admin.settings.email.remove") }}',
        type: 'DELETE',
        data: { email: email },
        success: function (res) {
            if (res.success) {
                btn.closest('.email-item').fadeOut(300, function() {
                    $(this).remove();
                    if ($('.email-item').length === 0) {
                        $('#email-list').html(`
                            <div class="text-center py-4 text-muted" id="empty-state">
                                <i class="bi bi-envelope-slash fs-1 d-block mb-2" style="color:#ddd;"></i>
                                No notification emails added yet.
                            </div>
                        `);
                    }
                });
                showToast(res.message);
            }
        }
    });
});

// Press Enter to add
$('#new-email').on('keydown', function(e) {
    if (e.key === 'Enter') $('#add-email-btn').click();
});
</script>
@endpush