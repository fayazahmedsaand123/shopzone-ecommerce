<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ShopZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0d6efd 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .brand-logo {
            font-size: 32px;
            font-weight: 900;
            color: #0d6efd;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 6px;
        }
        .brand-logo span { color: #ff6b35; }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1.5px solid #e9ecef;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,.1);
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 15px;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #e9ecef;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }
        .input-group .form-control { border-radius: 0 10px 10px 0; }
        .divider { border-top: 1px solid #e9ecef; margin: 20px 0; }
    </style>
</head>
<body>
<div class="auth-card">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="brand-logo">Shop<span>Zone</span></a>
    <p class="text-center text-muted mb-4" style="font-size:13px;">Pakistan's #1 Online Store</p>

    <h5 class="fw-bold mb-1">Welcome Back!</h5>
    <p class="text-muted mb-4" style="font-size:13px;">Login to your ShopZone account</p>

    {{-- Session Error --}}
    @if (session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:13px;">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
            </div>
            @error('email')
                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label class="form-label fw-semibold" style="font-size:13px;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:12px;">Forgot password?</a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password" required>
            </div>
            @error('password')
                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:13px;">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login to ShopZone
        </button>
    </form>

    <div class="divider"></div>

    <div class="text-center" style="font-size:13px;">
        Don't have an account?
        <a href="{{ route('register') }}" class="fw-bold text-primary">Register Free</a>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('home') }}" class="text-muted" style="font-size:12px;">
            <i class="bi bi-arrow-left me-1"></i>Back to ShopZone
        </a>
    </div>
</div>
</body>
</html>