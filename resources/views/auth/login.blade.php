<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Retail Pro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body { background: linear-gradient(135deg, #556ee6, #4a5feb, #3b50e8); min-height: 100vh; }
        .login-card { border-radius: 1rem; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-4">
    <div class="w-100" style="max-width: 400px;">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-25 rounded-3 mb-3" style="width: 64px; height: 64px;">
                <i class="fa-solid fa-store text-white fs-3"></i>
            </div>
            <h1 class="h3 fw-bold text-white">Retail Pro</h1>
            <p class="text-white-50 mt-1 small">Point of Sale System</p>
        </div>

        <div class="card login-card shadow-lg border-0">
            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success small mb-3">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username"
                               class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                               class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password (default: 123456)">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                        <label for="remember_me" class="form-check-label small">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Log In
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot your password?</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>