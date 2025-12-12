@extends('layouts.admin')

@section('content')
    <h1>Criar Página</h1>

    <form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Slug (identificador da URL)</label>
            <input class="form-control" name="slug" value="{{ old('slug') }}" required>
            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input class="form-control" name="title" value="{{ old('title') }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Thumbnail (imagem)</label>
            <input class="form-control" type="file" name="thumbnail" accept="image/*">
            @error('thumbnail') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Video URL (YouTube, etc.)</label>
            <input class="form-control" name="video_url" value="{{ old('video_url') }}">
            @error('video_url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Imagens (até 3)</label>
            <input class="form-control" type="file" name="images[]" accept="image/*" multiple>
            @error('images') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Conteúdo</label>
            <textarea class="form-control" name="content" rows="12">{{ old('content') }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" value="1" {{ old('show_in_menu') ? 'checked' : '' }}>
            <label class="form-check-label" for="show_in_menu">Exibir no menu</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="hide_business_info" name="hide_business_info" value="1" {{ old('hide_business_info') ? 'checked' : '' }}>
            <label class="form-check-label" for="hide_business_info">Ocultar informações de contato</label>
        </div>

        <button class="btn btn-primary" type="submit">Criar Página</button>
        <a class="btn btn-secondary" href="{{ route('admin.pages') }}">Cancelar</a>
    </form>
@endsection
