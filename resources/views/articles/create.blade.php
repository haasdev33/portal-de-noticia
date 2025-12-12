@extends('layouts.app')

@section('content')
    <h1>Novo Artigo</h1>
    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input class="form-control" name="title" value="{{ old('title') }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Conteúdo</label>
            <textarea class="form-control" name="body" rows="6" required>{{ old('body') }}</textarea>
            @error('body') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <input class="form-control" name="category" value="{{ old('category', 'Geral') }}">
            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Publicado em (YYYY-mm-dd HH:MM)</label>
            <input class="form-control" name="published_at" value="{{ old('published_at') }}">
            @error('published_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Imagem de destaque (thumbnail)</label>
            <input class="form-control" type="file" name="thumbnail" accept="image/*" id="thumbnail-input">
            @error('thumbnail') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Imagens adicionais (até 3)</label>
            <input class="form-control" type="file" name="images[]" accept="image/*" multiple id="images-input">
            <div class="form-text">Selecione até 3 imagens.</div>
            @error('images') <small class="text-danger">{{ $message }}</small> @enderror
            <div id="preview-new-images" class="mt-2"></div>
        </div>
        <button class="btn btn-primary" type="submit">Criar</button>
        <a class="btn btn-secondary" href="{{ route('articles.index') }}">Cancelar</a>
    </form>

    <script>
    (function(){
        const key = 'article_draft_new';
        const form = document.querySelector('form');
        const fields = ['title','body','published_at','category'];

        // restore
        try{
            const data = JSON.parse(localStorage.getItem(key) || '{}');
            fields.forEach(f=>{ if(data[f]){ const el=form.querySelector('[name="'+f+'"]'); if(el) el.value = data[f]; }});
        }catch(e){/*ignore*/}

        // save on input
        fields.forEach(f=>{
            const el = form.querySelector('[name="'+f+'"]');
            if(!el) return;
            el.addEventListener('input', ()=>{
                const data = JSON.parse(localStorage.getItem(key) || '{}');
                data[f] = el.value;
                localStorage.setItem(key, JSON.stringify(data));
            });
        });

        // preview images
        const imagesInput = document.getElementById('images-input');
        const previewNew = document.getElementById('preview-new-images');

        function previewFiles(files){
            previewNew.innerHTML = '';
            Array.from(files).slice(0,3).forEach(file=>{
                const reader = new FileReader();
                reader.onload = e=>{
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '120px'; img.style.marginRight = '8px'; img.style.display='inline-block';
                    previewNew.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        if(imagesInput){ imagesInput.addEventListener('change', e=> previewFiles(e.target.files)); }

        // clear storage on submit
        form.addEventListener('submit', ()=> localStorage.removeItem(key));
    })();
    </script>
@endsection
