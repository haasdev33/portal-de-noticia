@extends('layouts.app')

@section('content')
  <div class="text-center py-5">
    <h1 class="display-4">404 — Página não encontrada</h1>
    <p class="lead text-muted">Desculpe, a página que você tentou acessar não existe ou foi removida.</p>

    <p class="mt-4">
      <a class="btn btn-primary" href="{{ url('/') }}">Voltar para a Home</a>
    </p>

    <p class="small text-muted mt-3">Você será redirecionado para a página inicial em <span id="count">5</span> segundos.</p>
  </div>

  <script>
    (function(){
      var s = 5;
      var el = document.getElementById('count');
      var t = setInterval(function(){
        s--; if(!el) return clearInterval(t);
        el.textContent = s;
        if(s<=0){ window.location = '{{ url('/') }}'; }
      }, 1000);
    })();
  </script>
@endsection
