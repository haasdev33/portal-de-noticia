@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h4 mb-3">Registrar conta</h1>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar senha</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
                <button class="btn btn-primary" type="submit">Registrar</button>
            </form>
        </div>
    </div>
@endsection
