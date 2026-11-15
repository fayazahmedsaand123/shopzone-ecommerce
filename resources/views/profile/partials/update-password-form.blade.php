<div class="panel">
    <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-shield-lock" style="color:var(--brand);"></i>
        <h5 class="mb-0">Update Password</h5>
    </div>
    <p class="text-muted mb-4" style="font-size:.86rem;">
        Use a long, random password to keep your account secure.
    </p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        @if($errors->updatePassword->any())
            <div class="alert alert-danger py-2" style="font-size:.86rem;">
                <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->updatePassword->first() }}
            </div>
        @endif

        <div class="row g-3">
            <div class="col-12">
                <label for="current_password" class="form-label">Current password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="current_password" name="current_password"
                        autocomplete="current-password" class="form-control" placeholder="Your current password">
                </div>
            </div>

            <div class="col-md-6">
                <label for="new_password" class="form-label">New password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                    <input type="password" id="new_password" name="password"
                        autocomplete="new-password" class="form-control" placeholder="At least 8 characters">
                </div>
            </div>

            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm new password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        autocomplete="new-password" class="form-control" placeholder="Repeat new password">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">
            <i class="bi bi-shield-check me-2"></i>Update Password
        </button>
    </form>
</div>
