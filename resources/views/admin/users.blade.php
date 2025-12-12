@extends('layouts.admin')

@section('content')
    <h1>Gerir Usuários</h1>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr><th>ID</th><th>Nome</th><th>Email</th><th>Role</th><th>Ações</th></tr>
        </thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                    <span class="badge {{ $u->isAdmin() ? 'bg-danger' : ($u->isEditor() ? 'bg-warning' : 'bg-secondary') }}">
                        {{ $u->role ?? 'user' }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.users.update', $u) }}" style="display:inline-flex; gap: 10px; align-items: center;">
                        @csrf
                        <select name="role" class="form-select form-select-sm" style="width:140px">
                            <option value="user" {{ ($u->role ?? 'user')=='user'?'selected':'' }}>user</option>
                            <option value="editor" {{ ($u->role ?? '')=='editor'?'selected':'' }}>editor</option>
                            <option value="admin" {{ ($u->role ?? '')=='admin'?'selected':'' }}>admin</option>
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit">Salvar</button>
                    </form>

                    @if($u->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.delete', $u) }}" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Deletar</button>
                        </form>
                    @else
                        <span class="badge bg-secondary" title="Você é o admin logado">Você</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
