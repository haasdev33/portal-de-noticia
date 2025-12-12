<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Search by title
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->input('date_to'));
        }

        $articles = $query->latest('published_at')->paginate(9);
        
        // Get available categories for filter
        $categories = Article::distinct('category')->pluck('category')->sort();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        if (! auth()->check() || (! auth()->user()->isEditor() && ! auth()->user()->isAdmin())) {
            abort(403, 'Acesso negado.');
        }

        return view('articles.create');
    }

    public function store(Request $request)
    {
        if (! auth()->check() || (! auth()->user()->isEditor() && ! auth()->user()->isAdmin())) {
            abort(403, 'Acesso negado.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:5120',
        ]);

        // handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = Storage::disk('public')->putFile('articles', $request->file('thumbnail'));
        }

        $article = Article::create($data + ['user_id' => auth()->id()]);

        // handle additional images
        // ensure combined image limit (existing + new) <= 3
        $existingCount = 0;
        // new article has no existing images
        if ($request->hasFile('images')) {
            if (count($request->file('images')) > 3) {
                return back()->withErrors(['images' => 'Selecione no máximo 3 imagens.']);
            }
        }

        if ($request->hasFile('images')) {
            $i = 0;
            foreach ($request->file('images') as $file) {
                $path = Storage::disk('public')->putFile('articles', $file);
                ArticleImage::create(['article_id' => $article->id, 'path' => $path, 'position' => $i]);
                $i++;
            }
        }

        return redirect()->route('articles.show', $article);
    }

    public function edit(Article $article)
    {
        if (! auth()->check() || (! auth()->user()->isEditor() && ! auth()->user()->isAdmin())) {
            abort(403, 'Acesso negado.');
        }

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if (! auth()->check() || (! auth()->user()->isEditor() && ! auth()->user()->isAdmin())) {
            abort(403, 'Acesso negado.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:article_images,id',
        ]);

        // handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // delete old thumbnail file if exists and is a storage path
            if ($article->thumbnail && str_starts_with($article->thumbnail, 'articles')) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = Storage::disk('public')->putFile('articles', $request->file('thumbnail'));
        }

        $article->update($data);

        // remove images requested
        if ($request->filled('remove_images')) {
            $toRemove = (array) $request->input('remove_images');
            $images = ArticleImage::whereIn('id', $toRemove)->where('article_id', $article->id)->get();
            foreach ($images as $img) {
                if ($img->path && str_starts_with($img->path, 'articles')) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }
        }

        // add new images (append positions)
        if ($request->hasFile('images')) {
            $newCount = count($request->file('images'));
            $existing = $article->images()->count();
            if ($existing + $newCount > 3) {
                return back()->withErrors(['images' => 'O total de imagens (existentes + novas) não pode exceder 3.']);
            }
            $currentMax = $article->images()->max('position');
            $currentMax = $currentMax === null ? 0 : $currentMax + 1;
            foreach ($request->file('images') as $file) {
                $path = Storage::disk('public')->putFile('articles', $file);
                ArticleImage::create(['article_id' => $article->id, 'path' => $path, 'position' => $currentMax]);
                $currentMax++;
            }
        }

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Article $article)
    {
        if (! auth()->check() || (! auth()->user()->isEditor() && ! auth()->user()->isAdmin())) {
            abort(403, 'Acesso negado.');
        }

        $article->delete();

        return redirect()->route('articles.index');
    }
}
