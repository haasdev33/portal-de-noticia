@extends('layouts.app')

@section('content')
    <a href="{{ route('articles.index') }}" class="btn btn-link">← Voltar</a>
    <h1 class="mt-2">{{ $article->title }}</h1>
    <div class="mb-2">
        <span class="badge bg-info">{{ $article->category }}</span>
        <span class="text-muted small">{{ $article->published_at?->format('d/m/Y H:i') }} por {{ $article->user?->name ?? 'Anônimo' }}</span>
    </div>
    <div class="mt-3">
        <div class="mb-3">
            @php
                $thumb = null;
                if ($article->thumbnail) {
                    if (str_starts_with($article->thumbnail, 'http')) {
                        $thumb = $article->thumbnail;
                    } else {
                        $thumb = \Illuminate\Support\Facades\Storage::disk('public')->exists($article->thumbnail)
                            ? asset('storage/'.$article->thumbnail)
                            : null;
                    }
                }
                if (! $thumb) {
                    $thumb = "https://picsum.photos/800/600?random={$article->id}";
                }
            @endphp
            <img src="{{ $thumb }}" alt="thumb" class="img-fluid" style="max-width:400px;" />
        </div>
        {!! nl2br(e($article->body)) !!}
    </div>

    <div class="mt-4">
        <h5>Imagens</h5>
        <div class="d-flex gap-3 flex-wrap">
            @if($article->images->isEmpty())
                @for($i=0;$i<3;$i++)
                    <img src="https://picsum.photos/200/150?random={{ $article->id }}-{{ $i }}" alt="placeholder" style="max-width:200px; height:auto;" />
                @endfor
            @else
                @foreach($article->images as $img)
                    @php
                        if (str_starts_with($img->path, 'http')) {
                            $imgUrl = $img->path;
                        } else {
                            $imgUrl = \Illuminate\Support\Facades\Storage::disk('public')->exists($img->path)
                                ? asset('storage/'.$img->path)
                                : "https://picsum.photos/200/150?random={$article->id}-{$img->id}";
                        }
                    @endphp
                    <img src="{{ $imgUrl }}" alt="img" style="max-width:200px; height:auto;" />
                @endforeach
            @endif
        </div>
    </div>
    @if(auth()->check() && (auth()->user()->isEditor() || auth()->user()->isAdmin()))
        <p class="mt-3"><a class="btn btn-sm btn-secondary" href="{{ route('articles.edit', $article) }}">Editar</a>
        @if(auth()->user()->isAdmin() || auth()->id() === $article->user_id)
            <form method="POST" action="{{ route('articles.destroy', $article) }}" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja deletar este artigo?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" type="submit">Deletar</button>
            </form>
        @endif
        </p>
    @endif

    <!-- Comments Section -->
    <div class="mt-5 pt-4 border-top">
        <h4>Comentários ({{ $article->comments->count() }})</h4>

        @if(auth()->check())
            <form method="POST" action="{{ route('comments.store', $article) }}" class="mb-4">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="content" rows="3" placeholder="Deixe um comentário..." required></textarea>
                    @error('content') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Comentar</button>
            </form>
        @else
            <p class="text-muted"><a href="{{ route('login') }}">Faça login</a> para comentar.</p>
        @endif

        <div class="comments-list">
            @forelse($article->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                        </h6>
                        <p class="card-text">{{ $comment->content }}</p>
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Remover?')">Remover</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">Nenhum comentário ainda.</p>
            @endforelse
        </div>
    </div>
@endsection
