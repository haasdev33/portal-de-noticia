@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h2 class="mb-4">Permissões e Funcionalidades</h2>
            <p class="text-muted mb-4">Conheça o que você pode fazer no Portal de Notícias de acordo com sua função:</p>

            <div class="row g-4">
                <!-- User Regular -->
                <div class="col-md-6">
                    <div class="card border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">👤 Usuário Regular</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Você pode:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ Ler todos os artigos</li>
                                <li class="mb-2">✅ Comentar nos artigos</li>
                                <li class="mb-2">✅ Editar seu próprio perfil</li>
                                <li class="mb-2">✅ Alterar sua senha</li>
                                <li class="mb-2">✅ Deletar sua conta</li>
                            </ul>
                            <h6 class="card-title mt-3">Você NÃO pode:</h6>
                            <ul class="list-unstyled text-danger small">
                                <li>❌ Criar artigos</li>
                                <li>❌ Editar artigos</li>
                                <li>❌ Gerenciar usuários</li>
                                <li>❌ Acessar painel admin</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Editor -->
                <div class="col-md-6">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">✏️ Editor</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Você pode:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ Fazer tudo que um usuário faz</li>
                                <li class="mb-2">✅ Criar novos artigos</li>
                                <li class="mb-2">✅ Editar seus próprios artigos</li>
                                <li class="mb-2">✅ Deletar seus próprios artigos</li>
                                <li class="mb-2">✅ Editar páginas do site</li>
                                <li class="mb-2">✅ Adicionar imagens e vídeos</li>
                                <li class="mb-2">✅ Acessar painel de artigos</li>
                            </ul>
                            <h6 class="card-title mt-3">Você NÃO pode:</h6>
                            <ul class="list-unstyled text-danger small">
                                <li>❌ Deletar artigos de outros</li>
                                <li>❌ Gerenciar usuários</li>
                                <li>❌ Acessar painel admin completo</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Admin -->
                <div class="col-md-6 offset-md-3">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">👑 Administrador</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Você pode:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ Fazer tudo que um editor faz</li>
                                <li class="mb-2">✅ Editar e deletar qualquer artigo</li>
                                <li class="mb-2">✅ Gerenciar todos os usuários</li>
                                <li class="mb-2">✅ Alterar funções de usuários</li>
                                <li class="mb-2">✅ Deletar usuários</li>
                                <li class="mb-2">✅ Acessar painel admin completo</li>
                                <li class="mb-2">✅ Visualizar estatísticas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-5">
                <h6>💡 Dica:</h6>
                <p class="mb-0">Entre em contato com o administrador se acredita que sua função deve ser alterada.</p>
            </div>
        </div>
    </div>
</div>
@endsection
