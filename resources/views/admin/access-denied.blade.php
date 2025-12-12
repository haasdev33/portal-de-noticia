@extends('layouts.admin')

@section('content')
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Acesso Restrito</h4>
        <p>Esta página é restrita para administradores. Você não tem permissão para gerenciar usuários.</p>
        <hr>
        <p class="mb-0">Se você acredita que isso é um erro, entre em contato com o administrador.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Voltar ao Dashboard</a>
@endsection
