@extends('layouts.admin')

@section('content')
    <h1>Dashboard</h1>
    <p>Bem-vindo ao painel de controle do {{ \App\Helpers\ConfigHelper::siteName() }}.</p>
    
    <h4 class="mt-4">Estatísticas</h4>
    <div class="row">
        @if(auth()->user()->isAdmin())
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $usersCount }}</h5>
                        <p class="card-text text-muted">Usuários</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $articlesCount }}</h5>
                    <p class="card-text text-muted">Artigos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $pagesCount }}</h5>
                    <p class="card-text text-muted">Páginas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $commentsCount }}</h5>
                    <p class="card-text text-muted">Comentários</p>
                </div>
            </div>
        </div>
    </div>
    
    <h4 class="mt-4">Últimos Artigos</h4>
    <table class="table table-striped">
        <thead>
            <tr><th>ID</th><th>Título</th><th>Autor</th><th>Data</th></tr>
        </thead>
        <tbody>
            @foreach($latestArticles as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td><a href="{{ route('articles.show', $a) }}">{{ $a->title }}</a></td>
                    <td>{{ $a->user?->email }}</td>
                    <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
