<div class="panel" style="border-color:rgba(239,68,68,.35);">
    <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-exclamation-triangle" style="color:var(--danger);"></i>
        <h5 class="mb-0">Danger Zone</h5>
    </div>
    <p class="text-muted mb-4" style="font-size:.86rem;">
        Once your account is deleted, all of its data is permanently removed. Download anything you want to keep first.
    </p>

    @if($errors->userDeletion->any())
        <div class="alert alert-danger py-2" style="font-size:.86rem;">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->userDeletion->first() }}
        </div>
    @endif

    <button class="btn btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#delete-account-form"
        aria-expanded="{{ $errors->userDeletion->any() ? 'true' : 'false' }}" aria-controls="delete-account-form">
        <i class="bi bi-trash3 me-2"></i>Delete My Account
    </button>

    <div class="collapse {{ $errors->userDeletion->any() ? 'show' : '' }} mt-3" id="delete-account-form">
        <form method="POST" action="{{ route('customer.profile.destroy') }}"
            onsubmit="return confirm('Delete your account permanently? This cannot be undone.');">
            @csrf
            @method('delete')

            <label for="delete_password" class="form-label">Confirm with your password</label>
            <div class="input-group" style="max-width:420px;">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="delete_password" name="password" autocomplete="current-password"
                    required class="form-control" placeholder="Your current password">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash3 me-1"></i>Delete
                </button>
            </div>
        </form>
    </div>
</div>
