@extends('layouts.app')

@section('content')
    <h1>{{ $page->title }}</h1>
        <div class="mb-4">
        @if($page->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($page->thumbnail))
            <img src="{{ asset('storage/'.$page->thumbnail) }}" alt="thumb" class="img-fluid mb-3">
        @elseif($page->video_url)
            <div class="ratio ratio-16x9 mb-3">
                <iframe src="{{ $page->video_url }}" allowfullscreen></iframe>
            </div>
        @endif
        <div>{!! method_exists($page, 'renderContent') ? $page->renderContent() : $page->content !!}</div>
        @if($page->images && $page->images->count())
            <div class="mt-3 d-flex gap-2 flex-wrap">
                @foreach($page->images as $img)
                    @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img->path))
                        <img src="{{ asset('storage/'.$img->path) }}" alt="page-img" style="max-width:200px;" class="img-thumbnail">
                    @endif
                @endforeach
            </div>
        @endif
    </div>
    @if(isset($business) && is_array($business) && !(isset($page) && isset($page->hide_business_info) && $page->hide_business_info))
        <div class="row mt-4">
            <div class="col-lg-8">
                <!-- keep page content above; optionally nothing here -->
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

                @if(!empty(\App\Models\Setting::get('business_map_embed')))
                    <div class="card mb-3">
                        <div class="card-body">
                            {!! \App\Models\Setting::get('business_map_embed') !!}
                        </div>
                    </div>
                @endif

                @if(!empty(\App\Models\Setting::get('contact_faq_html')))
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Perguntas Frequentes</h5>
                            <div>{!! \App\Models\Setting::get('contact_faq_html') !!}</div>
                        </div>
                    </div>
                @endif

                <div class="mt-3">
                    <h6>Redes Sociais</h6>
                    <ul class="list-unstyled">
                        @if(\App\Models\Setting::get('business_facebook'))
                            <li><a href="{{ \App\Models\Setting::get('business_facebook') }}" target="_blank">Facebook</a></li>
                        @endif
                        @if(\App\Models\Setting::get('business_instagram'))
                            <li><a href="{{ \App\Models\Setting::get('business_instagram') }}" target="_blank">Instagram</a></li>
                        @endif
                        @if(\App\Models\Setting::get('business_twitter'))
                            <li><a href="{{ \App\Models\Setting::get('business_twitter') }}" target="_blank">Twitter</a></li>
                        @endif
                        @if(\App\Models\Setting::get('business_linkedin'))
                            <li><a href="{{ \App\Models\Setting::get('business_linkedin') }}" target="_blank">LinkedIn</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isEditor()))
        <p><a class="btn btn-secondary" href="{{ route('admin.pages.edit', $page) }}">Editar Home</a></p>
    @endif
@endsection
