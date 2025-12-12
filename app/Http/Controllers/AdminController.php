<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Page;
use App\Models\PageImage;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403);
        }
        $usersCount = User::count();
        $articlesCount = Article::count();
        $pagesCount = Page::count();
        $commentsCount = Comment::count();
        $latestArticles = Article::latest()->limit(10)->get();
        return view('admin.dashboard', compact('usersCount','articlesCount','pagesCount','commentsCount','latestArticles'));
    }

    public function users()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) abort(403);
        $users = User::orderBy('id','desc')->get();
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) abort(403);
        $data = $request->validate(['role' => 'required|in:user,editor,admin']);
        $isAdmin = $data['role'] === 'admin';
        $user->update(['role' => $data['role'], 'is_admin' => $isAdmin]);
        return redirect()->back()->with('success','Usuário atualizado');
    }

    public function deleteUser(User $user)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) abort(403);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Você não pode deletar sua própria conta pelo admin.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Usuário deletado com sucesso');
    }

    public function articles()
    {
        if (! auth()->check() || (! auth()->user()->isAdmin() && ! auth()->user()->isEditor())) abort(403);
        $articles = Article::latest()->paginate(20);
        return view('admin.articles', compact('articles'));
    }

    public function pages()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) abort(403);
        $pages = Page::all();
        return view('admin.pages', compact('pages'));
    }

    public function editPage(Page $page)
    {
        if (! auth()->check() || (! auth()->user()->isAdmin() && ! auth()->user()->isEditor())) abort(403);
        return view('admin.edit-page', compact('page'));
    }

    public function createPage()
    {
        if (! auth()->check() || (! auth()->user()->isAdmin() && ! auth()->user()->isEditor())) abort(403);
        return view('admin.create-page');
    }

    public function storePage(Request $request)
    {
        if (! auth()->check() || (! auth()->user()->isAdmin() && ! auth()->user()->isEditor())) abort(403);

        $data = $request->validate([
            'slug' => 'required|string|max:100|alpha_dash|unique:pages,slug',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:5120',
            'show_in_menu' => 'nullable|boolean',
            'hide_business_info' => 'nullable|boolean',
        ]);

        // handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = Storage::disk('public')->putFile('pages', $request->file('thumbnail'));
        }

        $data['show_in_menu'] = $request->has('show_in_menu') ? 1 : 0;
        $data['hide_business_info'] = $request->has('hide_business_info') ? 1 : 0;
        $page = Page::create($data);

        // add images
        if ($request->hasFile('images')) {
            $currentMax = 0;
            foreach ($request->file('images') as $file) {
                $path = Storage::disk('public')->putFile('pages', $file);
                PageImage::create(['page_id' => $page->id, 'path' => $path, 'position' => $currentMax]);
                $currentMax++;
            }
        }

        return redirect()->route('admin.pages')->with('success', 'Página criada com sucesso');
    }

    public function deletePage(Page $page)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) abort(403);

        // delete thumbnail
        if ($page->thumbnail && str_starts_with($page->thumbnail, 'pages')) {
            Storage::disk('public')->delete($page->thumbnail);
        }

        // delete images
        foreach ($page->images as $img) {
            if ($img->path && str_starts_with($img->path, 'pages')) {
                Storage::disk('public')->delete($img->path);
            }
            $img->delete();
        }

        $page->delete();
        return redirect()->route('admin.pages')->with('success', 'Página removida');
    }

    public function updatePage(Request $request, Page $page)
    {
        if (! auth()->check() || (! auth()->user()->isAdmin() && ! auth()->user()->isEditor())) abort(403);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'thumbnail' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        // handle thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($page->thumbnail && str_starts_with($page->thumbnail, 'pages')) {
                Storage::disk('public')->delete($page->thumbnail);
            }
            $data['thumbnail'] = Storage::disk('public')->putFile('pages', $request->file('thumbnail'));
        }

        if (!isset($data['video_url'])) {
            $data['video_url'] = $page->video_url ?? null;
        }

        // show_in_menu and hide_business_info flags
        $data['show_in_menu'] = $request->has('show_in_menu') ? 1 : 0;
        $data['hide_business_info'] = $request->has('hide_business_info') ? 1 : 0;

        $page->update($data);

        // remove images
        if (!empty($data['remove_images'])) {
            $toRemove = (array) $data['remove_images'];
            $images = PageImage::whereIn('id', $toRemove)->where('page_id', $page->id)->get();
            foreach ($images as $img) {
                if ($img->path && str_starts_with($img->path, 'pages')) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }
        }

        // add new images
        if ($request->hasFile('images')) {
            $newCount = count($request->file('images'));
            $existing = $page->images()->count();
            if ($existing + $newCount > 3) {
                return back()->withErrors(['images' => 'O total de imagens (existentes + novas) não pode exceder 3.']);
            }
            $currentMax = $page->images()->max('position');
            $currentMax = $currentMax === null ? 0 : $currentMax + 1;
            foreach ($request->file('images') as $file) {
                $path = Storage::disk('public')->putFile('pages', $file);
                PageImage::create(['page_id' => $page->id, 'path' => $path, 'position' => $currentMax]);
                $currentMax++;
            }
        }

        return redirect()->route('admin.pages')->with('success','Página atualizada');
    }
}
