@extends('layouts.auth')
@section('title', 'Confirm Password')

@section('content')
    <h1>Confirm your password</h1>
    <p class="sub">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-shield-lock me-2"></i>Confirm
        </button>
    </form>
@endsection
