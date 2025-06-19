<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
        Route::get('/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/edit', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('admin')->group(function () {
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('tags', App\Http\Controllers\Admin\TagController::class);
    });

    Route::prefix('client')->group(function () {
        Route::resource('projects', App\Http\Controllers\Client\ProjectController::class);
        Route::resource('reviews', App\Http\Controllers\Client\ReviewController::class);
    });

    Route::prefix('freelancer')->group(function () {
        Route::resource('projects', App\Http\Controllers\Freelancer\ProjectController::class, ['only' => ['index']]);
        Route::resource('proposals', App\Http\Controllers\Freelancer\ProposalController::class);
        Route::resource('reviews', App\Http\Controllers\Freelancer\ReviewController::class);
    });
});