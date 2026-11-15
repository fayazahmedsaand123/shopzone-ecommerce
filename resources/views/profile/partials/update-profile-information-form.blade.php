<div class="panel">
    <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-person-badge" style="color:var(--brand);"></i>
        <h5 class="mb-0">Profile Information</h5>
    </div>
    <p class="text-muted mb-4" style="font-size:.86rem;">
        Update the name and email address associated with your account.
    </p>

    <form method="POST" action="{{ route('customer.profile.update') }}">
        @csrf
        @method('patch')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Full name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        required autofocus autocomplete="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Your full name">
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        required autocomplete="username"
                        class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">
            <i class="bi bi-check2-circle me-2"></i>Save Changes
        </button>
    </form>
</div>
