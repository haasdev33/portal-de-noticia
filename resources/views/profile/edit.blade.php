@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Perfil</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <h5 class="mb-3">Alterar Senha (opcional)</h5>

                        <div class="mb-3">
                            <label class="form-label">Senha Atual</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Deixe em branco se não quiser alterar">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nova Senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Deixe em branco se não quiser alterar">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirme a nova senha">
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Mínimo 8 caracteres. Deixe em branco para manter a senha atual.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
