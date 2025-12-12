@extends('layouts.app')

@section('content')
    <h1>Editar Artigo</h1>
    <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input class="form-control" name="title" value="{{ old('title', $article->title) }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Conteúdo</label>
            <textarea class="form-control" name="body" rows="6" required>{{ old('body', $article->body) }}</textarea>
            @error('body') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <input class="form-control" name="category" value="{{ old('category', $article->category) }}">
            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Publicado em (YYYY-mm-dd HH:MM)</label>
            <input class="form-control" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d H:i')) }}">
            @error('published_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Imagem de destaque (thumbnail)</label>
            @php
                $currentThumb = null;
                if ($article->thumbnail) {
                    if (str_starts_with($article->thumbnail, 'http')) {
                        $currentThumb = $article->thumbnail;
                    } else {
                        $currentThumb = \Illuminate\Support\Facades\Storage::disk('public')->exists($article->thumbnail)
                            ? asset('storage/'.$article->thumbnail)
                            : null;
                    }
                }
                if (! $currentThumb) {
                    $currentThumb = "https://picsum.photos/200/150?random={$article->id}-thumb";
                }
            @endphp
            <div class="mb-2">
                <img id="current-thumbnail" src="{{ $currentThumb }}" alt="thumb" style="max-width:200px; height:auto;" />
            </div>
            <input class="form-control" type="file" name="thumbnail" accept="image/*" id="thumbnail-input">
        </div>

        <div class="mb-3">
            <label class="form-label">Imagens adicionais (até 3)</label>
            <div class="mb-2" id="existing-images">
            @if($article->images->isNotEmpty())
                @foreach($article->images as $img)
                    @php
                        if (str_starts_with($img->path, 'http')) {
                            $imgUrl = $img->path;
                        } else {
                            $imgUrl = \Illuminate\Support\Facades\Storage::disk('public')->exists($img->path)
                                ? asset('storage/'.$img->path)
                                : "https://picsum.photos/120/90?random={$article->id}-{$img->id}";
                        }
                    @endphp
                    <div class="d-inline-block me-2 text-center existing-image-item">
                        <img src="{{ $imgUrl }}" alt="img" style="max-width:120px; height:auto; display:block;" />
                        <label class="form-check-label"><input type="checkbox" name="remove_images[]" value="{{ $img->id }}"> Remover</label>
                    </div>
                @endforeach
            @endif
            </div>
            <input class="form-control" type="file" name="images[]" accept="image/*" multiple id="images-input">
            <div class="form-text">Selecione até 3 imagens adicionais.</div>
            <div id="preview-new-images" class="mt-2"></div>
        </div>

        <button class="btn btn-primary" type="submit">Salvar</button>
        <a class="btn btn-secondary" href="{{ route('articles.show', $article) }}">Cancelar</a>
    </form>
    <form class="mt-3" method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Deseja remover este artigo?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Remover Artigo</button>
    </form>
    <script>
    (function(){
        const key = 'article_draft_{{ $article->id }}';
        const form = document.querySelector('form:first-of-type');
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

        // preview thumbnail and new images
        const thumbInput = document.getElementById('thumbnail-input');
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

        if(thumbInput){ thumbInput.addEventListener('change', e=>{
            const f = e.target.files[0];
            if(!f) return;
            const r = new FileReader();
            r.onload = ev=>{ document.getElementById('current-thumbnail').src = ev.target.result; };
            r.readAsDataURL(f);
        }); }
        if(imagesInput){ imagesInput.addEventListener('change', e=> previewFiles(e.target.files)); }

        // clear storage on submit
        form.addEventListener('submit', ()=> localStorage.removeItem(key));
    })();
    </script>
@endsection
