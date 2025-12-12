@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Meu Perfil</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Nome</h6>
                            <p class="fw-bold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p class="fw-bold">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Função</h6>
                            <p class="fw-bold">
                                @if($user->isAdmin())
                                    <span class="badge bg-danger">Administrador</span>
                                @elseif($user->isEditor())
                                    <span class="badge bg-warning">Editor</span>
                                @else
                                    <span class="badge bg-secondary">Usuário</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Membro desde</h6>
                            <p class="fw-bold">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
                        
                        @if($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">Painel Admin</a>
                        @elseif($user->isEditor())
                            <a href="{{ route('articles.create') }}" class="btn btn-info">Criar Artigo</a>
                        @endif

                        <form method="POST" action="{{ route('profile.destroy') }}" class="d-inline" onsubmit="return confirm('Tem certeza que deseja deletar sua conta? Esta ação é irreversível.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Deletar Conta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
