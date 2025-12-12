<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        if (!auth()->check()) {
            abort(403);
        }

        $data = $request->validate(['content' => 'required|string|min:3|max:1000']);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        return redirect()->route('articles.show', $article)->with('success', 'Comentário adicionado com sucesso!');
    }

    public function destroy(Comment $comment)
    {
        if (!auth()->check() || (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin())) {
            abort(403);
        }

        $article = $comment->article;
        $comment->delete();

        return redirect()->route('articles.show', $article)->with('success', 'Comentário removido.');
    }
}
