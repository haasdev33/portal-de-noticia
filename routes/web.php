<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SettingsController;
use App\Models\Page;

Route::get('/', function () {
    $page = Page::where('slug','home')->first();
    if ($page) {
        return view('home', ['page' => $page]);
    }
    return view('welcome');
});

// Public article routes (index + show). Constrain show to numeric to avoid
// matching 'create' or other literal slugs that would conflict with explicit routes.
Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Permissions info page
Route::get('permissions', function() {
    return view('permissions');
})->name('permissions');

// Authentication
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// Protected article routes (create/edit/delete)
Route::middleware('auth')->group(function () {
    Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Comments
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Profile/Account routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin panel
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');
        Route::get('users', [AdminController::class,'users'])->name('users');
        Route::post('users/{user}/update', [AdminController::class,'updateUser'])->name('users.update');
        Route::delete('users/{user}', [AdminController::class,'deleteUser'])->name('users.delete');
        Route::get('articles', [AdminController::class,'articles'])->name('articles');
        Route::get('pages', [AdminController::class,'pages'])->name('pages');
        Route::get('pages/create', [AdminController::class,'createPage'])->name('pages.create');
        Route::post('pages', [AdminController::class,'storePage'])->name('pages.store');
        Route::get('pages/{page}/edit', [AdminController::class,'editPage'])->name('pages.edit');
        Route::post('pages/{page}/update', [AdminController::class,'updatePage'])->name('pages.update');
        Route::delete('pages/{page}', [AdminController::class,'deletePage'])->name('pages.delete');
        Route::get('settings', [SettingsController::class,'index'])->name('settings');
        Route::put('settings', [SettingsController::class,'update'])->name('settings.update');
    });
});

// About page (custom) - render admin-editable Page if present
Route::get('/about', function () {
    $page = \App\Models\Page::where('slug','about')->with('images')->first();
    if ($page) {
        return view('home', ['page' => $page]);
    }

    $business = [
        'name' => \App\Models\Setting::get('business_name', config('app.name')),
        'email' => \App\Models\Setting::get('business_email', config('mail.from.address')),
        'phone' => \App\Models\Setting::get('business_phone', ''),
        'address' => \App\Models\Setting::get('business_address', ''),
        'hours_html' => \App\Models\Setting::get('business_hours_html', ''),
    ];

    return view('about', ['page' => $page, 'business' => $business]);
})->name('about.show');

// Contact page (custom) - fallback closures so /contact works like /home even if controller not resolved
Route::get('/contact', function () {
    $page = \App\Models\Page::where('slug','contact')->with('images')->first();

    $business = [
        'name' => \App\Models\Setting::get('business_name', config('app.name')),
        'email' => \App\Models\Setting::get('business_email', config('mail.from.address')),
        'phone' => \App\Models\Setting::get('business_phone', ''),
        'address' => \App\Models\Setting::get('business_address', ''),
        'hours_html' => \App\Models\Setting::get('business_hours_html', ''),
    ];

    if ($page) {
        return view('home', ['page' => $page, 'business' => $business]);
    }

    return view('contact', ['business' => $business]);
})->name('contact.show');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'hp' => 'nullable|string',
    ]);

    if (!empty($data['hp'])) {
        return redirect()->back()->with('status', 'Obrigado.');
    }

    $to = \App\Models\Setting::get('business_email', config('mail.from.address'));
    $body = "Contato recebido:\n\n";
    $body .= "Nome: " . $data['name'] . "\n";
    $body .= "Email: " . $data['email'] . "\n";
    if (!empty($data['phone'])) {
        $body .= "Telefone: " . $data['phone'] . "\n";
    }
    $body .= "Assunto: " . $data['subject'] . "\n\n";
    $body .= "Mensagem:\n" . $data['message'] . "\n";

    try {
        \Illuminate\Support\Facades\Mail::raw($body, function ($m) use ($to, $data) {
            $m->to($to)->subject('[Contato] ' . $data['subject'])->replyTo($data['email'], $data['name']);
        });
        return redirect()->back()->with('success', 'Mensagem enviada com sucesso.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Não foi possível enviar sua mensagem no momento.');
    }

})->name('contact.send');


// Fallback route for Pages by slug (should be last)
Route::get('{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->with('images')->first();
    if (! $page) {
        abort(404);
    }

    $business = [
        'name' => \App\Models\Setting::get('business_name', config('app.name')),
        'email' => \App\Models\Setting::get('business_email', config('mail.from.address')),
        'phone' => \App\Models\Setting::get('business_phone', ''),
        'address' => \App\Models\Setting::get('business_address', ''),
        'hours_html' => \App\Models\Setting::get('business_hours_html', ''),
    ];

    return view('home', ['page' => $page, 'business' => $business]);
})->where('slug', '[A-Za-z0-9\-]+')->name('page.show');

