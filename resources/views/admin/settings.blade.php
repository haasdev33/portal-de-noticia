@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold">Configurações do Site</h1>
            <p class="text-muted">Customize a aparência e informações do seu portal</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Informações do Site -->
                        <h5 class="fw-bold mb-4 text-primary">
                            <i class="bi bi-info-circle"></i> Informações do Site
                        </h5>

                        <div class="mb-3">
                            <label for="site_name" class="form-label">Nome do Site *</label>
                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                id="site_name" name="site_name" 
                                value="{{ old('site_name', $settings['site_name']->value ?? '') }}" required>
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Nome exibido em todo o site</small>
                        </div>

                        <div class="mb-4">
                            <label for="site_tagline" class="form-label">Tagline (Subtítulo)</label>
                            <input type="text" class="form-control @error('site_tagline') is-invalid @enderror" 
                                id="site_tagline" name="site_tagline" 
                                value="{{ old('site_tagline', $settings['site_tagline']->value ?? '') }}">
                            @error('site_tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Descrição curta do site</small>
                        </div>

                        <div class="mb-4">
                            <label for="site_logo" class="form-label">Logo do Site</label>
                            <div class="d-flex gap-3">
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control @error('site_logo') is-invalid @enderror" 
                                        id="site_logo" name="site_logo" accept="image/*">
                                    @error('site_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">Recomendado: 200x60px, máximo 2MB</small>
                                </div>
                                @if($settings['site_logo']->value)
                                    <div>
                                        <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" 
                                            alt="Logo" class="img-fluid" style="max-height: 80px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Informações de Contato / Negócio -->
                        <h5 class="fw-bold mb-4 text-primary">
                            <i class="bi bi-geo-alt"></i> Informações de Contato e Negócio
                        </h5>

                        <div class="mb-3">
                            <label for="business_name" class="form-label">Nome do Negócio</label>
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror"
                                id="business_name" name="business_name"
                                value="{{ old('business_name', $settings['business_name']->value ?? '') }}">
                            @error('business_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="business_email" class="form-label">Email de Contato</label>
                                <input type="email" class="form-control @error('business_email') is-invalid @enderror"
                                    id="business_email" name="business_email"
                                    value="{{ old('business_email', $settings['business_email']->value ?? '') }}">
                                @error('business_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="business_phone" class="form-label">Telefone</label>
                                <input type="text" class="form-control @error('business_phone') is-invalid @enderror"
                                    id="business_phone" name="business_phone"
                                    value="{{ old('business_phone', $settings['business_phone']->value ?? '') }}">
                                @error('business_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="business_address" class="form-label">Endereço</label>
                            <input type="text" class="form-control @error('business_address') is-invalid @enderror"
                                id="business_address" name="business_address"
                                value="{{ old('business_address', $settings['business_address']->value ?? '') }}">
                            @error('business_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="business_hours_html" class="form-label">Horário de Funcionamento (HTML)</label>
                            <textarea class="form-control @error('business_hours_html') is-invalid @enderror" id="business_hours_html" name="business_hours_html" rows="3">{{ old('business_hours_html', $settings['business_hours_html']->value ?? '') }}</textarea>
                            @error('business_hours_html')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">Pode conter HTML simples (ex: &lt;strong&gt;Seg-Sex:&lt;/strong&gt; 9-18)</small>
                        </div>

                        <div class="mb-3">
                            <label for="business_map_embed" class="form-label">Mapa (embed HTML)</label>
                            <textarea class="form-control @error('business_map_embed') is-invalid @enderror" id="business_map_embed" name="business_map_embed" rows="3">{{ old('business_map_embed', $settings['business_map_embed']->value ?? '') }}</textarea>
                            @error('business_map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">Cole o código de embed do Google Maps ou iframe similar.</small>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Redes Sociais</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="business_facebook" class="form-label">Facebook (URL)</label>
                                <input type="url" class="form-control @error('business_facebook') is-invalid @enderror" id="business_facebook" name="business_facebook" value="{{ old('business_facebook', $settings['business_facebook']->value ?? '') }}">
                                @error('business_facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="business_instagram" class="form-label">Instagram (URL)</label>
                                <input type="url" class="form-control @error('business_instagram') is-invalid @enderror" id="business_instagram" name="business_instagram" value="{{ old('business_instagram', $settings['business_instagram']->value ?? '') }}">
                                @error('business_instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="business_twitter" class="form-label">Twitter (URL)</label>
                                <input type="url" class="form-control @error('business_twitter') is-invalid @enderror" id="business_twitter" name="business_twitter" value="{{ old('business_twitter', $settings['business_twitter']->value ?? '') }}">
                                @error('business_twitter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="business_linkedin" class="form-label">LinkedIn (URL)</label>
                                <input type="url" class="form-control @error('business_linkedin') is-invalid @enderror" id="business_linkedin" name="business_linkedin" value="{{ old('business_linkedin', $settings['business_linkedin']->value ?? '') }}">
                                @error('business_linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label for="contact_faq_html" class="form-label">FAQ de Contato (HTML)</label>
                            <textarea class="form-control @error('contact_faq_html') is-invalid @enderror" id="contact_faq_html" name="contact_faq_html" rows="5">{{ old('contact_faq_html', $settings['contact_faq_html']->value ?? '') }}</textarea>
                            @error('contact_faq_html')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">Bloco FAQ exibido na página de contato. Aceita HTML.</small>
                        </div>

                        <hr class="my-4">

                        <!-- Cores -->
                        <h5 class="fw-bold mb-4 text-primary">
                            <i class="bi bi-palette"></i> Cores do Site
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primary_color" class="form-label">Cor Primária *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('primary_color') is-invalid @enderror" 
                                        id="primary_color" name="primary_color" 
                                        value="{{ old('primary_color', $settings['primary_color']->value ?? '#0d6efd') }}" required>
                                    <input type="text" class="form-control @error('primary_color') is-invalid @enderror" 
                                        id="primary_color_text" name="primary_color_text" 
                                        value="{{ old('primary_color', $settings['primary_color']->value ?? '#0d6efd') }}" disabled>
                                </div>
                                <small class="text-muted d-block mt-1">Menus, botões e links principais</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="secondary_color" class="form-label">Cor Secundária *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('secondary_color') is-invalid @enderror" 
                                        id="secondary_color" name="secondary_color" 
                                        value="{{ old('secondary_color', $settings['secondary_color']->value ?? '#6c757d') }}" required>
                                    <input type="text" class="form-control @error('secondary_color') is-invalid @enderror" 
                                        id="secondary_color_text" name="secondary_color_text" 
                                        value="{{ old('secondary_color', $settings['secondary_color']->value ?? '#6c757d') }}" disabled>
                                </div>
                                <small class="text-muted d-block mt-1">Cor complementar</small>
                            </div>
                        </div>

                        <h6 class="fw-bold mt-4 mb-3">Navbar (Barra de Navegação)</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="navbar_bg_color" class="form-label">Cor de Fundo *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('navbar_bg_color') is-invalid @enderror" 
                                        id="navbar_bg_color" name="navbar_bg_color" 
                                        value="{{ old('navbar_bg_color', $settings['navbar_bg_color']->value ?? '#ffffff') }}" required>
                                    <input type="text" class="form-control @error('navbar_bg_color') is-invalid @enderror" 
                                        id="navbar_bg_color_text" name="navbar_bg_color_text" 
                                        value="{{ old('navbar_bg_color', $settings['navbar_bg_color']->value ?? '#ffffff') }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="navbar_text_color" class="form-label">Cor do Texto *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('navbar_text_color') is-invalid @enderror" 
                                        id="navbar_text_color" name="navbar_text_color" 
                                        value="{{ old('navbar_text_color', $settings['navbar_text_color']->value ?? '#000000') }}" required>
                                    <input type="text" class="form-control @error('navbar_text_color') is-invalid @enderror" 
                                        id="navbar_text_color_text" name="navbar_text_color_text" 
                                        value="{{ old('navbar_text_color', $settings['navbar_text_color']->value ?? '#000000') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mt-4 mb-3">Rodapé (Footer)</h6>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="footer_bg_color" class="form-label">Cor de Fundo *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('footer_bg_color') is-invalid @enderror" 
                                        id="footer_bg_color" name="footer_bg_color" 
                                        value="{{ old('footer_bg_color', $settings['footer_bg_color']->value ?? '#212529') }}" required>
                                    <input type="text" class="form-control @error('footer_bg_color') is-invalid @enderror" 
                                        id="footer_bg_color_text" name="footer_bg_color_text" 
                                        value="{{ old('footer_bg_color', $settings['footer_bg_color']->value ?? '#212529') }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="footer_text_color" class="form-label">Cor do Texto *</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('footer_text_color') is-invalid @enderror" 
                                        id="footer_text_color" name="footer_text_color" 
                                        value="{{ old('footer_text_color', $settings['footer_text_color']->value ?? '#ffffff') }}" required>
                                    <input type="text" class="form-control @error('footer_text_color') is-invalid @enderror" 
                                        id="footer_text_color_text" name="footer_text_color_text" 
                                        value="{{ old('footer_text_color', $settings['footer_text_color']->value ?? '#ffffff') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Salvar Configurações
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">Preview</h6>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        <!-- Preview Navbar -->
                        <div class="mb-4 p-3 rounded" id="navbar_preview" 
                            style="background-color: #ffffff; border: 1px solid #dee2e6;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="font-weight: bold; font-size: 18px;" id="logo_preview">
                                    @if($settings['site_logo']->value)
                                        <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" 
                                            alt="Logo" style="max-height: 40px;">
                                    @else
                                        Portal
                                    @endif
                                </div>
                                <div style="font-size: 12px;">Links</div>
                            </div>
                        </div>

                        <!-- Preview Footer -->
                        <div class="p-3 rounded text-white" id="footer_preview" 
                            style="background-color: #212529;">
                            <small>
                                <div style="margin-bottom: 8px;" id="site_name_preview">
                                    {{ $settings['site_name']->value ?? 'Portal de Notícias' }}
                                </div>
                                <div style="font-size: 11px; opacity: 0.8;" id="tagline_preview">
                                    {{ $settings['site_tagline']->value ?? 'Notícias, análises e opinião' }}
                                </div>
                            </small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <small class="text-muted">
                        <strong>Dica:</strong> A previsualização é atualizada em tempo real conforme você muda as configurações.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update preview in real-time
    const colorInputs = document.querySelectorAll('input[type="color"]');
    const textInputs = {
        'site_name': 'site_name_preview',
        'site_tagline': 'tagline_preview',
        'navbar_bg_color': 'navbar_preview',
        'footer_bg_color': 'footer_preview',
    };

    document.getElementById('site_name').addEventListener('change', (e) => {
        document.getElementById('site_name_preview').textContent = e.target.value;
    });

    document.getElementById('site_tagline').addEventListener('change', (e) => {
        document.getElementById('tagline_preview').textContent = e.target.value;
    });

    document.getElementById('navbar_bg_color').addEventListener('change', (e) => {
        document.getElementById('navbar_preview').style.backgroundColor = e.target.value;
        document.getElementById('navbar_bg_color_text').value = e.target.value;
    });

    document.getElementById('navbar_text_color').addEventListener('change', (e) => {
        document.getElementById('navbar_preview').style.color = e.target.value;
        document.getElementById('navbar_text_color_text').value = e.target.value;
    });

    document.getElementById('footer_bg_color').addEventListener('change', (e) => {
        document.getElementById('footer_preview').style.backgroundColor = e.target.value;
        document.getElementById('footer_bg_color_text').value = e.target.value;
    });

    document.getElementById('footer_text_color').addEventListener('change', (e) => {
        document.getElementById('footer_preview').style.color = e.target.value;
        document.getElementById('footer_text_color_text').value = e.target.value;
    });

    document.getElementById('primary_color').addEventListener('change', (e) => {
        document.getElementById('primary_color_text').value = e.target.value;
    });

    document.getElementById('secondary_color').addEventListener('change', (e) => {
        document.getElementById('secondary_color_text').value = e.target.value;
    });

    document.getElementById('site_logo').addEventListener('change', (e) => {
        if (e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById('logo_preview').innerHTML = 
                    `<img src="${event.target.result}" alt="Logo Preview" style="max-height: 40px;">`;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection
