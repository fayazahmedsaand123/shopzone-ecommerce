@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
    <h1>Create your account</h1>
    <p class="sub">Join ShopZone and start shopping Pakistan's best deals today.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="form-control @error('name') is-invalid @enderror" placeholder="Your full name">
            </div>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="At least 8 characters">
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password" class="form-control" placeholder="Repeat your password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-person-plus me-2"></i>Create Free Account
        </button>
    </form>

    <div class="auth-divider">ALREADY REGISTERED?</div>

    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign in to your account
    </a>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i>Back to ShopZone
        </a>
    </div>
@endsection
