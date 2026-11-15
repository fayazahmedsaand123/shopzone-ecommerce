@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('content')
    <h1>Forgot your password?</h1>
    <p class="sub">Enter your email and we'll send you a secure link to reset it.</p>

    @if (session('status'))
        <div class="alert alert-success mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-send me-2"></i>Send Reset Link
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="auth-link">
            <i class="bi bi-arrow-left me-1"></i>Back to Login
        </a>
    </div>
@endsection
