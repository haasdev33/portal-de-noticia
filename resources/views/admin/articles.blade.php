@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerir Artigos</h1>
        <a class="btn btn-primary" href="{{ route('articles.create') }}">+ Novo Artigo</a>
    </div>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr><th>ID</th><th>Título</th><th>Autor</th><th>Publicado</th><th>Ações</th></tr>
        </thead>
        <tbody>
        @foreach($articles as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td><a href="{{ route('articles.show', $a) }}">{{ $a->title }}</a></td>
                <td>{{ $a->user?->email }}</td>
                <td>{{ $a->published_at?->format('d/m/Y') ?? '—' }}</td>
                <td>
                    @if(auth()->user()->isAdmin() || auth()->id() === $a->user_id)
                        <a class="btn btn-sm btn-secondary" href="{{ route('articles.edit', $a) }}">Editar</a>
                        <form method="POST" action="{{ route('articles.destroy', $a) }}" style="display:inline-block" onsubmit="return confirm('Tem certeza?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remover</button>
                        </form>
                    @else
                        <span class="badge bg-secondary">Não é autor</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $articles->links() }}
@endsection
