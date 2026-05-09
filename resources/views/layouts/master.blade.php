<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Retail Pro')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/build/images/favicon.ico">
    @include('layouts.head-css')
    <style>
        body { font-size: 0.875rem; }
        #sidebar { width: 260px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; transition: all 0.3s; overflow-y: auto; overflow-x: hidden; }
        #sidebar.collapsed { width: 0; overflow: hidden; }
        #content { margin-left: 260px; transition: all 0.3s; min-height: 100vh; }
        #content.expanded { margin-left: 0; }
        #sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 0.5rem 1rem; border-radius: 0.25rem; margin: 2px 0; font-size: 0.85rem; }
        #sidebar .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        #sidebar .nav-link.active { background: rgba(255,255,255,0.15); color: #fff; }
        #sidebar .collapse .nav-link { padding: 0.35rem 1rem 0.35rem 2.4rem; font-size: 0.82rem; color: rgba(255,255,255,0.65); border-left: 2px solid rgba(255,255,255,0.15); margin-left: 0.5rem; border-radius: 0 0.25rem 0.25rem 0; }
        #sidebar .collapse .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); border-left-color: rgba(255,255,255,0.4); }
        #sidebar .collapse .nav-link.active { color: #fff; background: rgba(255,255,255,0.12); border-left-color: rgba(255,255,255,0.5); }
        #sidebar .nav-disabled { color: rgba(255,255,255,0.4) !important; }
        #sidebar .menu-title { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; color: rgba(255,255,255,0.4); padding: 0.75rem 1rem 0.25rem; font-weight: 600; }
        .sidebar-header { padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h5 { color: #fff; margin: 0; font-weight: 600; }
        .topbar { background: #fff; border-bottom: 1px solid #dee2e6; padding: 0.5rem 1rem; position: sticky; top: 0; z-index: 999; }
        .card { box-shadow: 0 0 0.1rem rgba(0,0,0,0.05); }
        @media (max-width: 767.98px) {
            #sidebar { width: 0; overflow: hidden; }
            #sidebar.show { width: 260px; }
            #content { margin-left: 0; }
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')
    <div id="content">
        @include('layouts.topbar')
        <div class="p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> <strong>Gagal menyimpan!</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>
    @include('layouts.vendor-scripts')
</body>
</html>