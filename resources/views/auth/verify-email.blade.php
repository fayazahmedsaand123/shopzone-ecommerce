@extends('layouts.auth')
@section('title', 'Verify Email')

@section('content')
    <h1>Verify your email</h1>
    <p class="sub">
        Thanks for signing up! Please verify your email address by clicking the link we just sent you.
        If you didn't receive it, we can send another one.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle me-2"></i>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="d-grid gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-envelope-arrow-up me-2"></i>Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="bi bi-box-arrow-right me-2"></i>Log Out
            </button>
        </form>
    </div>
@endsection
