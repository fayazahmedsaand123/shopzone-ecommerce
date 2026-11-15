@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
    <h1>Set a new password</h1>
    <p class="sub">Choose a strong password to secure your ShopZone account.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $request->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Minimum 8 characters" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control"
                placeholder="Repeat new password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-check-lg me-2"></i>Reset My Password
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i>Back to Login
        </a>
    </div>
@endsection
