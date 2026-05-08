<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Retail Pro') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body class="bg-light min-vh-100 d-flex flex-column align-items-center justify-content-center p-4">
    <div class="text-center mb-4">
        <i class="fa-solid fa-store fa-3x text-primary mb-3 d-block"></i>
        <h1 class="h3 fw-bold">Retail Pro</h1>
        <p class="text-muted">Point of Sale System</p>
    </div>

    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4 text-center">
            <h4 class="mb-1 fw-medium">Let's get started</h4>
            <p class="text-muted mb-3">With so many options available to you, we suggest you start with the following:</p>

            <ul class="list-unstyled mb-3">
                <li class="mb-2">
                    <i class="fa-solid fa-circle text-muted me-2" style="font-size:0.5rem;vertical-align:middle;"></i>
                    Read the <a href="https://laravel.com/docs" target="_blank" class="fw-medium">Documentation</a>
                </li>
                <li class="mb-2">
                    <i class="fa-solid fa-circle text-muted me-2" style="font-size:0.5rem;vertical-align:middle;"></i>
                    Watch video tutorials at <a href="https://laracasts.com" target="_blank" class="fw-medium">Laracasts</a>
                </li>
            </ul>

            <div class="d-flex gap-2 justify-content-center mb-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endauth
            </div>

            <p class="text-muted small mb-0">v{{ app()->version() }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>