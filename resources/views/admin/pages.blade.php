@extends('layouts.admin')

@section('content')
    <h1>Gerir Páginas</h1>
    <div class="mb-3">
        <a class="btn btn-primary" href="{{ route('admin.pages.create') }}">Criar Página</a>
    </div>
    @if($pages->isEmpty())
        <div class="alert alert-info">Nenhuma página encontrada.</div>
    @else
        <table class="table table-striped table-hover">
            <thead>
                <tr><th>ID</th><th>Slug</th><th>Título</th><th>Menu</th><th>Última edição</th><th>Ações</th></tr>
            </thead>
            <tbody>
            @foreach($pages as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td><code>{{ $p->slug }}</code></td>
                    <td>{{ $p->title }}</td>
                    <td>{!! $p->show_in_menu ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>' !!}</td>
                    <td>{{ $p->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.pages.edit', $p) }}">Editar</a>
                        <a class="btn btn-sm btn-info" href="/{{ $p->slug }}" target="_blank">Ver</a>
                        <form method="POST" action="{{ route('admin.pages.delete', $p) }}" style="display:inline-block" onsubmit="return confirm('Remover página?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
