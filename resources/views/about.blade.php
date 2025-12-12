@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Sobre</h1>
            <p class="lead">{{ \\App\Models\Setting::get('site_tagline', '') }}</p>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Quem somos</h5>
                    <p>Bem-vindo ao {{ \\App\Models\Setting::get('business_name', config('app.name')) }}. Aqui você encontra notícias e análises locais e nacionais.</p>
                    @if(!empty(\\App\Models\Setting::get('business_address')))
                        <p><strong>Endereço:</strong> {{ \\App\Models\Setting::get('business_address') }}</p>
                    @endif
                    @if(!empty(\\App\Models\Setting::get('business_email')))
                        <p><strong>Contato:</strong> <a href="mailto:{{ \\App\Models\Setting::get('business_email') }}">{{ \\App\Models\Setting::get('business_email') }}</a></p>
                    @endif
                </div>
            </div>

            @if(!empty(\\App\Models\Setting::get('business_map_embed')))
                <div class="card mb-3">
                    <div class="card-body">
                        {!! \\App\Models\Setting::get('business_map_embed') !!}
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Redes Sociais</h6>
                    <ul class="list-unstyled">
                        @if(\\App\Models\Setting::get('business_facebook'))
                            <li><a href="{{ \\App\Models\Setting::get('business_facebook') }}" target="_blank">Facebook</a></li>
                        @endif
                        @if(\\App\Models\Setting::get('business_instagram'))
                            <li><a href="{{ \\App\Models\Setting::get('business_instagram') }}" target="_blank">Instagram</a></li>
                        @endif
                        @if(\\App\Models\Setting::get('business_twitter'))
                            <li><a href="{{ \\App\Models\Setting::get('business_twitter') }}" target="_blank">Twitter</a></li>
                        @endif
                        @if(\\App\Models\Setting::get('business_linkedin'))
                            <li><a href="{{ \\App\Models\Setting::get('business_linkedin') }}" target="_blank">LinkedIn</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isEditor()))
        @php $p = \App\Models\Page::where('slug','about')->first(); @endphp
        @if($p)
            <p class="mt-3"><a class="btn btn-secondary" href="{{ route('admin.pages.edit', $p) }}">Editar Página Sobre</a></p>
        @endif
    @endif

@endsection
