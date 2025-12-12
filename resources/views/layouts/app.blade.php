<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ \App\Helpers\ConfigHelper::siteName() }}</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-" crossorigin="anonymous">
      <!-- Bootstrap Icons -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
      <!-- Dynamic Colors -->
      <style>
      {!! \App\Helpers\ConfigHelper::dynamicCss() !!}
  :root {
        --bs-primary: var(--primary-color);
        --bs-secondary: var(--secondary-color);
      }
      .navbar {
        background-color: var(--navbar-bg) !important;
        color: var(--navbar-text) !important;
      }
      .navbar .navbar-brand,
      .navbar .nav-link {
        color: var(--navbar-text) !important;
      }
      .navbar .nav-link:hover {
        opacity: 0.8;
      }
      .navbar .dropdown-menu {
        background-color: var(--navbar-bg);
        border-color: var(--navbar-text);
      }
      .navbar .dropdown-menu .dropdown-item {
        color: var(--navbar-text);
      }
      .navbar .dropdown-menu .dropdown-item:hover {
        background-color: rgba(0,0,0,0.1);
      }
      footer {
        background-color: var(--footer-bg) !important;
        color: var(--footer-text) !important;
      }
      footer a {
        color: var(--footer-text) !important;
        opacity: 0.8;
      }
      footer a:hover {
        opacity: 1;
      }
      .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
      }
      .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
      }
      </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
    @if(\App\Helpers\ConfigHelper::siteLogo())
      <img src="{{ \App\Helpers\ConfigHelper::siteLogo() }}" alt="Logo" style="max-height: 40px; margin-right: 10px;">
    @endif
    {{ \App\Helpers\ConfigHelper::siteName() }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    @php $menuPages = \App\Models\Page::where('slug','!=','home')->where('show_in_menu', true)->get(); @endphp
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">Notícias</a></li>
        @foreach($menuPages as $mp)
            <li class="nav-item"><a class="nav-link" href="{{ url('/' . $mp->slug) }}">{{ $mp->title }}</a></li>
        @endforeach
        @auth
          @if(auth()->user()->isEditor() || auth()->user()->isAdmin())
            <li class="nav-item"><a class="nav-link btn btn-sm btn-outline-primary ms-2" href="{{ route('articles.create') }}">Novo Artigo</a></li>
          @endif
          @if(auth()->user()->isAdmin())
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
            @php $__contactPage = \App\Models\Page::where('slug','contact')->first(); @endphp
            @if($__contactPage)
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.pages.edit', $__contactPage) }}">Editar Contato</a></li>
            @endif
          @endif
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="{{ route('profile.show') }}">Meu Perfil</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Editar Perfil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button class="dropdown-item" type="submit">Sair</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth="login">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#authModal" data-auth="register">Registrar</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-" crossorigin="anonymous"></script>
<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="authModalLabel">Entrar / Registrar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab" aria-controls="login-pane" aria-selected="true">Login</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab" aria-controls="register-pane" aria-selected="false">Registrar</button>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="login-pane" role="tabpanel" aria-labelledby="login-tab">
            <form method="POST" action="{{ route('login.post') }}">
              @csrf
              <input type="hidden" name="auth_action" value="login">
              <div class="mb-3">
                <label for="modal_login_email" class="form-label">Email</label>
                <input id="modal_login_email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="modal_login_password" class="form-label">Senha</label>
                <input id="modal_login_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="modal_remember">
                  <label class="form-check-label" for="modal_remember">Lembrar-me</label>
                </div>
                <a href="{{ route('login') }}">Esqueci a senha</a>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="register-pane" role="tabpanel" aria-labelledby="register-tab">
            <form method="POST" action="{{ route('register.post') }}">
              @csrf
              <input type="hidden" name="auth_action" value="register">
              <div class="mb-3">
                <label for="modal_register_name" class="form-label">Nome</label>
                <input id="modal_register_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="modal_register_email" class="form-label">Email</label>
                <input id="modal_register_email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="modal_register_password" class="form-label">Senha</label>
                <input id="modal_register_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="mb-3">
                <label for="modal_register_password_confirmation" class="form-label">Confirmar Senha</label>
                <input id="modal_register_password_confirmation" type="password" class="form-control" name="password_confirmation" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  (function(){
    const authModal = document.getElementById('authModal');
    if (!authModal) return;
    authModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const auth = button && button.getAttribute('data-auth');
      if (auth === 'register') {
        new bootstrap.Tab(document.getElementById('register-tab')).show();
      } else {
        new bootstrap.Tab(document.getElementById('login-tab')).show();
      }
    });

    // If old input indicates which tab, open it on load
    document.addEventListener('DOMContentLoaded', function(){
      try {
        const oldAction = '{{ old('auth_action') }}';
        if (oldAction === 'register') {
          var modal = new bootstrap.Modal(document.getElementById('authModal'));
          modal.show();
          new bootstrap.Tab(document.getElementById('register-tab')).show();
        } else if (oldAction === 'login' && oldAction !== '') {
          var modal = new bootstrap.Modal(document.getElementById('authModal'));
          modal.show();
          new bootstrap.Tab(document.getElementById('login-tab')).show();
        }
      } catch (e) {
        // ignore
      }
    });
  })();
</script>
<footer class="mt-5">
  <div class="container py-5">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">{{ \App\Helpers\ConfigHelper::siteName() }}</h5>
        <p class="small">{{ \App\Helpers\ConfigHelper::siteTagline() }}</p>
      </div>
      <div class="col-md-4 mb-3">
        <h6 class="text-uppercase">Links úteis</h6>
        <ul class="list-unstyled small">
          <li><a class="text-white-50" href="{{ route('articles.index') }}">Últimas notícias</a></li>
          @auth
            <li><a class="text-white-50" href="{{ route('articles.create') }}">Publicar artigo</a></li>
          @endauth
          <li><a class="text-white-50" href="{{ route('permissions') }}">Permissões</a></li>
          @php $footerPages = \App\Models\Page::where('show_in_menu', true)->get(); @endphp
          @foreach($footerPages as $fp)
            <li><a class="text-white-50" href="/{{ $fp->slug }}">{{ $fp->title }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h6 class="text-uppercase">Assine</h6>
        <p class="small text-muted">Receba as principais notícias por e-mail.</p>
        <form class="d-flex" action="/newsletter/subscribe" method="POST">
          <input class="form-control form-control-sm me-2" type="email" name="email" placeholder="Seu e-mail" aria-label="Email">
          <button class="btn btn-primary btn-sm" type="submit">Inscrever</button>
        </form>
      </div>
    </div>
    <div class="border-top pt-3 mt-3 d-flex justify-content-between small">
      <div>&copy; {{ date('Y') }} {{ \App\Helpers\ConfigHelper::siteName() }}. Todos os direitos reservados.</div>
      <div>Feito com ❤️ — <a href="https://example.com">Equipe</a></div>
    </div>
  </div>
</footer>
</body>
</html>
