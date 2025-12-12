<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Helpers\ConfigHelper::siteName() }} — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        {!! \App\Helpers\ConfigHelper::dynamicCss() !!}
        :root {
            --bs-primary: var(--primary-color);
            --bs-secondary: var(--secondary-color);
        }
        body { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--primary-color); color: #fff; padding: 20px; }
        .sidebar a { color: rgba(255,255,255,0.9); text-decoration: none; display: block; padding: 10px; border-radius: 4px; margin: 5px 0; }
        .sidebar button.btn-link { color: rgba(255,255,255,0.95); text-decoration: none; }
        .sidebar .collapse a { padding-left: 14px; padding-top: 6px; padding-bottom: 6px; }
        .sidebar a:hover { background: rgba(0,0,0,0.2); }
        .sidebar .active { background: var(--secondary-color); }
        .admin-content { flex: 1; padding: 30px; background: #f8f9fa; }

        /* Make layout stack on small screens */
        @media (max-width: 767.98px) {
            body { display: block; }
            .sidebar { display: none; }
            .admin-content { padding: 15px; }
        }
    </style>
</head>
<body>
<!-- Responsive sidebar: visible on md+, offcanvas on small screens -->
<nav class="d-md-none bg-primary text-white p-2">
    <div class="container-fluid d-flex align-items-center">
        <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
        <a href="/" class="text-white text-decoration-none fw-bold">← Portal</a>
        <div class="ms-auto">
            <a href="{{ route('profile.show') }}" class="text-white text-decoration-none me-2"><i class="bi bi-person-circle"></i></a>
        </div>
    </div>
</nav>

<!-- Offcanvas for small screens -->
<div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="adminSidebarOffcanvas" aria-labelledby="adminSidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white" id="adminSidebarLabel">Menu</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <div class="p-3">
        <h6 class="text-muted">Menu</h6>
        <a href="{{ route('admin.dashboard') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Usuários
            </a>
        @endif

        @if(auth()->user()->isEditor() || auth()->user()->isAdmin())
            @php
                $contentOpen = request()->routeIs('admin.articles') || request()->routeIs('admin.pages');
            @endphp
            <div class="mb-1">
                <button class="btn btn-sm btn-link text-start w-100 text-white d-flex justify-content-between align-items-center {{ $contentOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#menuContentMobile" aria-expanded="{{ $contentOpen ? 'true' : 'false' }}">
                    <span><i class="bi bi-folder2-open"></i> Conteúdo</span>
                    <i class="bi bi-chevron-{{ $contentOpen ? 'down' : 'right' }}"></i>
                </button>
                <div class="collapse {{ $contentOpen ? 'show' : '' }}" id="menuContentMobile">
                    <div class="ps-2">
                        <a href="{{ route('admin.articles') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.articles') ? 'active' : '' }}">
                            <i class="bi bi-newspaper"></i> Artigos
                        </a>
                        <a href="{{ route('admin.pages') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.pages') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark"></i> Páginas
                        </a>
                        <a href="{{ route('admin.pages.create') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.pages.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i> Criar Página
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.settings') }}" class="d-block text-white mb-1 {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Configurações
            </a>
        @endif

        <hr class="bg-secondary">

        <h6 class="text-muted mt-3">Conta</h6>
        <a href="{{ route('profile.show') }}" class="d-block text-white mb-2">
            <i class="bi bi-person"></i> Meu Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="btn btn-sm btn-outline-light w-100" type="submit">
                <i class="bi bi-box-arrow-right"></i> Sair
            </button>
        </form>
    </div>
  </div>
</div>

<!-- Desktop sidebar -->
<div class="sidebar d-none d-md-block">
    <h5 class="mb-4"><a href="/" style="color: #fff; text-decoration: none;">← Portal</a></h5>
    <h6 class="text-muted">Menu</h6>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Usuários
        </a>
    @endif

    @if(auth()->user()->isEditor() || auth()->user()->isAdmin())
        @php
            $contentOpen = request()->routeIs('admin.articles') || request()->routeIs('admin.pages');
        @endphp
        <div class="mb-1">
                <button class="btn btn-sm btn-link text-start w-100 text-white d-flex justify-content-between align-items-center {{ $contentOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse" data-bs-target="#menuContent" aria-expanded="{{ $contentOpen ? 'true' : 'false' }}">
                <span><i class="bi bi-folder2-open"></i> Conteúdo</span>
                <i class="bi bi-chevron-{{ $contentOpen ? 'down' : 'right' }}"></i>
            </button>
            <div class="collapse {{ $contentOpen ? 'show' : '' }}" id="menuContent">
                <div class="ps-2">
                    <a href="{{ route('admin.articles') }}" class="{{ request()->routeIs('admin.articles') ? 'active' : '' }}">
                        <i class="bi bi-newspaper"></i> Artigos
                    </a>
                    <a href="{{ route('admin.pages') }}" class="{{ request()->routeIs('admin.pages') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark"></i> Páginas
                    </a>
                        <a href="{{ route('admin.pages.create') }}" class="{{ request()->routeIs('admin.pages.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i> Criar Página
                        </a>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Configurações
        </a>
    @endif

    <hr class="bg-secondary">

    <h6 class="text-muted mt-3">Conta</h6>
    <a href="{{ route('profile.show') }}">
        <i class="bi bi-person"></i> Meu Perfil
    </a>
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button class="btn btn-sm btn-outline-light w-100" type="submit">
            <i class="bi bi-box-arrow-right"></i> Sair
        </button>
    </form>
</div>

<div class="admin-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
