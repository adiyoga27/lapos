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
<body class="bg-body">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center p-4" style="background: linear-gradient(135deg, #556ee6, #4a5feb, #3b50e8);">
        <div>
            <a href="/">
                <i class="fa-solid fa-store fa-3x text-white mb-3 d-block text-center"></i>
            </a>
        </div>

        <div class="w-100 mt-3" style="max-width: 400px;">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>