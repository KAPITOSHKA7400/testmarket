<?php

use App\Models\Work;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\WorkController;

// ГЛАВНАЯ с лимитом и сортировкой
Route::get('/', function(Request $request) {
    $limit = $request->input('limit', 13);
    $offset = $request->input('offset', 0); // ДОБАВЛЯЕМ offset!
    $sort = $request->input('sort', 'recent');

    // !!! Важно: with(['user', 'likes']) — всё правильно !!!
    $query = \App\Models\Work::with(['user', 'likes']);
    if ($sort === 'popular') {
        $query->withCount('likes')->orderByDesc('likes_count');
    } else {
        $query->orderByDesc('created_at');
    }

    $totalWorks = $query->count();

    $works = $query->offset($offset)->limit($limit)->get();

    if ($request->ajax()) {
        return view('partials._works', compact('works'));
    }

    return view('welcome', compact('works', 'sort', 'limit', 'totalWorks'));
})->name('home');

// AUTH routes (Breeze/Fortify/Jetstream или свои)
// Страница логина
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Авторизация (POST)
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Страница регистрации
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// Регистрация (POST)
Route::post('/register', [RegisteredUserController::class, 'store']);
// Выход
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Кабинет, редактирование профиля и работы — ТОЛЬКО для авторизованных
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/addwork', [ProfileController::class, 'addWork'])->name('profile.addwork');
    Route::delete('/work/{work}', [ProfileController::class, 'deleteWork'])->name('work.delete');
    Route::post('/work/{work}/like', [ProfileController::class, 'likeWork'])->name('work.like');
    Route::post('/work/{work}/unlike', [ProfileController::class, 'unlikeWork'])->name('work.unlike');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/work/{work}/edit', [ProfileController::class, 'editWork'])->name('work.edit');
    Route::post('/work/{work}/update', [ProfileController::class, 'updateWork'])->name('work.update');

    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/profile/social', [ProfileController::class, 'social'])->name('profile.social');
    Route::post('/profile/social', [SocialController::class, 'update'])->name('social.update');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::get('/profile/sessions', [ProfileController::class, 'sessions'])->name('profile.sessions');

    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');

    // ---- ВОТ ОНО: учёт просмотров работы, всё правильно ----
    Route::post('/works/{work}/view', function (\App\Models\Work $work) {
        if (auth()->check()) {
            \App\Models\WorkView::firstOrCreate([
                'user_id' => auth()->id(),
                'work_id' => $work->id,
            ]);
        }

        return response()->noContent();
    })->middleware('auth')->name('works.view');
});

// админские штуки
Route::middleware('auth')->group(function () {
    Route::get('/profile/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
});

Route::get('/profile/admin/games', [\App\Http\Controllers\AdminController::class, 'games'])->name('admin.games');

Route::middleware('auth')->group(function () {
    Route::get('/profile/admin/games', [\App\Http\Controllers\AdminController::class, 'gamesPage'])->name('admin.games');
});
Route::post('/profile/admin/games', [\App\Http\Controllers\AdminController::class, 'storeGame'])->name('admin.games.store');
Route::post('/profile/admin/product-types', [\App\Http\Controllers\AdminController::class, 'storeProductType'])->name('admin.product_types.store');
Route::post('/profile/admin/servers', [\App\Http\Controllers\AdminController::class, 'storeServer'])->name('admin.servers.store');




// Публичный профиль по логину — всегда В САМОМ НИЗУ
Route::get('/{login}', [ProfileController::class, 'showByLogin'])->name('profile.bylogin');

require __DIR__.'/auth.php';
