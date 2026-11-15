@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <h1>Welcome back</h1>
    <p class="sub">Login to your ShopZone account to continue shopping.</p>

    @if (session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="your@email.com" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                @endif
            </div>
            <input type="password" name="password" class="form-control mt-1 @error('password') is-invalid @enderror"
                placeholder="Enter your password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:.82rem;">Remember me for 30 days</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login to ShopZone
        </button>
    </form>

    <div class="auth-divider">NEW TO SHOPZONE?</div>

    <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100">
        <i class="bi bi-person-plus me-2"></i>Create a free account
    </a>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i>Back to ShopZone
        </a>
    </div>
@endsection
