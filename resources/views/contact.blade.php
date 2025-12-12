@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <h1>Contato</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Assunto</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Mensagem</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="display:none;" aria-hidden="true">
                    <label>Leave this empty</label>
                    <input type="text" name="hp" value="">
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Enviar Mensagem</button>
                    <button class="btn btn-outline-secondary" type="reset">Limpar</button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Informações</h5>
                    <p class="mb-1"><strong>Empresa:</strong> {{ $business['name'] ?? config('app.name') }}</p>
                    @if(!empty($business['address']))
                        <p class="mb-1"><strong>Endereço:</strong> {{ $business['address'] }}</p>
                    @endif
                    @if(!empty($business['phone']))
                        <p class="mb-1"><strong>Telefone:</strong> <a href="tel:{{ $business['phone'] }}">{{ $business['phone'] }}</a></p>
                    @endif
                    @if(!empty($business['email']))
                        <p class="mb-1"><strong>Email:</strong> <a href="mailto:{{ $business['email'] }}">{{ $business['email'] }}</a></p>
                    @endif
                    @if(!empty($business['hours_html']))
                        <hr>
                        <div><strong>Horário de Funcionamento:</strong></div>
                        <div>{!! $business['hours_html'] !!}</div>
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

            @if(!empty(\\App\Models\Setting::get('contact_faq_html')))
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Perguntas Frequentes</h5>
                        <div>{!! \\App\Models\Setting::get('contact_faq_html') !!}</div>
                    </div>
                </div>
            @endif

            <div class="mt-3">
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

    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isEditor()))
        @php $p = \App\Models\Page::where('slug','contact')->first(); @endphp
        @if($p)
            <p class="mt-3"><a class="btn btn-secondary" href="{{ route('admin.pages.edit', $p) }}">Editar Página de Contato</a></p>
        @endif
    @endif
@endsection
