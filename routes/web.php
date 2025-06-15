<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('menu');
});

// Route login manual (di luar group auth)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Socialite Login (juga di luar group auth)
Route::get('login/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('login/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

// Route register manual (di luar group auth)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete_photo');

    // News Routes (wartawan: create, store; editor: approve/reject; semua login: index, show, edit, update, destroy)
    Route::middleware('mycustomrole:wartawan')->group(function () {
        Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('news', [NewsController::class, 'store'])->name('news.store');
    });
    Route::middleware('mycustomrole:editor')->group(function () {
        Route::post('news/{news}/approve', [NewsController::class, 'approve'])->name('news.approve');
        Route::post('news/{news}/reject', [NewsController::class, 'reject'])->name('news.reject');
    });
    Route::resource('news', NewsController::class)->except(['create', 'store']);

    // Category Routes (admin only)
    Route::middleware('mycustomrole:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
});

require __DIR__.'/auth.php';

Route::get('/home', function () {
    return redirect('/dashboard');
})->name('home');
