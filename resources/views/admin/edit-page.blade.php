@extends('layouts.admin')

@section('content')
    <h1>Editar Página</h1>
    <p class="text-muted">{{ $page->slug }}</p>
    
    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input class="form-control" name="title" value="{{ old('title', $page->title) }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Thumbnail (imagem)</label>
            @if($page->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($page->thumbnail))
                <div class="mb-2"><img src="{{ asset('storage/'.$page->thumbnail) }}" alt="thumb" style="max-width:200px"></div>
            @endif
            <input class="form-control" type="file" name="thumbnail" accept="image/*">
            @error('thumbnail') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Video URL (YouTube, etc.)</label>
            <input class="form-control" name="video_url" value="{{ old('video_url', $page->video_url) }}">
            @error('video_url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Imagens (até 3)</label>
            @if($page->images->count())
                <div class="mb-2">
                    @foreach($page->images as $img)
                        <div class="d-inline-block me-2 text-center">
                            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img->path))
                                <img src="{{ asset('storage/'.$img->path) }}" alt="img" style="max-width:120px; display:block">
                            @endif
                            <label class="form-check-label small"><input type="checkbox" name="remove_images[]" value="{{ $img->id }}"> Remover</label>
                        </div>
                    @endforeach
                </div>
            @endif
            <input class="form-control" type="file" name="images[]" accept="image/*" multiple>
            @error('images') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Conteúdo</label>
            <textarea class="form-control" name="content" rows="12">{{ old('content', $page->content) }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
            <small class="text-muted d-block mt-2">Dica: você pode inserir componentes usando shortcodes. Ex: <code>[[contact_form]]</code>, <code>[[business_info]]</code>, <code>[[map]]</code>.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
            <label class="form-check-label" for="show_in_menu">Exibir no menu</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="hide_business_info" name="hide_business_info" value="1" {{ old('hide_business_info', $page->hide_business_info) ? 'checked' : '' }}>
            <label class="form-check-label" for="hide_business_info">Ocultar informações de contato</label>
        </div>
        <button class="btn btn-primary" type="submit">Salvar Mudanças</button>
        <a class="btn btn-secondary" href="{{ route('admin.pages') }}">Cancelar</a>
    </form>
@endsection
