<nav class="topbar navbar navbar-light bg-white">
    <div class="d-flex align-items-center">
        <button class="btn btn-sm btn-outline-secondary me-2 d-md-none" id="sidebarToggleMobile" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="fa-solid fa-bars"></i>
        </button>
        <button class="btn btn-sm btn-outline-secondary me-2 d-none d-md-inline" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <div class="ms-auto d-flex align-items-center">
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user me-1"></i> {{ ucfirst(Auth::user()->name ?? 'User') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>