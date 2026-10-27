<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — ShopZone</title>
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
        .brand-logo { font-size:32px;font-weight:900;color:#0d6efd;text-decoration:none;display:block;text-align:center;margin-bottom:6px; }
        .brand-logo span { color:#ff6b35; }
        .form-control { border-radius:10px;padding:12px 16px;border:1.5px solid #e9ecef;font-size:14px; }
        .form-control:focus { border-color:#0d6efd;box-shadow:0 0 0 3px rgba(13,110,253,.1); }
        .btn-primary { border-radius:10px;padding:12px;font-weight:700;font-size:15px; }
        .input-group-text { background:#f8f9fa;border:1.5px solid #e9ecef;border-radius:10px 0 0 10px;color:#6c757d; }
        .input-group .form-control { border-radius:0 10px 10px 0; }
    </style>
</head>
<body>
<div class="auth-card">
    <a href="{{ route('home') }}" class="brand-logo">Shop<span>Zone</span></a>
    <p class="text-center text-muted mb-4" style="font-size:13px;">Password Recovery</p>

    <div class="text-center mb-4">
        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
            style="width:70px;height:70px;font-size:30px;">
            <i class="bi bi-lock text-warning"></i>
        </div>
        <h5 class="fw-bold">Forgot your password?</h5>
        <p class="text-muted" style="font-size:13px;">
            No problem. Enter your email and we will send you a password reset link.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success text-center mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:13px;">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="your@email.com" required autofocus>
            </div>
            @error('email')
                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-send me-2"></i>Send Reset Link
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-muted" style="font-size:13px;">
            <i class="bi bi-arrow-left me-1"></i>Back to Login
        </a>
    </div>
</div>
</body>
</html>