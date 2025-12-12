@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">{{ \App\Helpers\ConfigHelper::siteName() }}</h1>
        @if(auth()->check() && (auth()->user()->isEditor() || auth()->user()->isAdmin()))
            <a class="btn btn-primary" href="{{ route('articles.create') }}">+ Novo artigo</a>
        @endif
    </div>

    <!-- Search and Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('articles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por título..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="De">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Até">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
                @if(request()->filled('search') || request()->filled('category') || request()->filled('date_from') || request()->filled('date_to'))
                    <div class="col-12">
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-sm">Limpar filtros</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if($articles->isEmpty())
        <div class="alert alert-secondary">Nenhuma notícia encontrada.</div>
    @else
        <p class="text-muted mb-3">{{ $articles->total() }} artigo(s) encontrado(s)</p>
        <div class="row g-3">
        @foreach($articles as $article)
            @php
                $thumb = null;
                if ($article->thumbnail) {
                    if (str_starts_with($article->thumbnail, 'http')) {
                        $thumb = $article->thumbnail;
                    } else {
                        $thumb = \Illuminate\Support\Facades\Storage::disk('public')->exists($article->thumbnail)
                            ? asset('storage/'.$article->thumbnail)
                            : null;
                    }
                }
                if (! $thumb) {
                    $thumb = "https://picsum.photos/300/200?random={$article->id}";
                }
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="{{ $thumb }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <span class="badge bg-info mb-2">{{ $article->category }}</span>
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text text-muted small">{{ $article->published_at?->format('d/m/Y H:i') }}</p>
                        <p class="card-text text-muted small">Por: <strong>{{ $article->user?->name ?? 'Anônimo' }}</strong></p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-primary">Ler</a>
                        @if(auth()->check() && (auth()->user()->isEditor() || auth()->user()->isAdmin()))
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-secondary">Editar</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $articles->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
