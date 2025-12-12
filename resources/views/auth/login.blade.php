@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h4 mb-3">Login</h1>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Lembrar-me</label>
                </div>
                <button class="btn btn-primary" type="submit">Entrar</button>
            </form>
        </div>
    </div>
@endsection
