<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
        Route::prefix('projects/{project}')->group(function () {
            Route::resource('proposals', App\Http\Controllers\Client\Projects\ProposalController::class)->only(['index', 'show'])->names([
                'index' => 'client.projects.proposals.index',
                'show' => 'client.projects.proposals.show',
            ]);
            Route::post('proposals/{proposal}/accept', [App\Http\Controllers\Client\Projects\ProposalController::class, 'accept'])->name('client.projects.proposals.accept');
            Route::post('proposals/{proposal}/reject', [App\Http\Controllers\Client\Projects\ProposalController::class, 'reject'])->name('client.projects.proposals.reject');
            Route::get('freelancers', [App\Http\Controllers\Client\Projects\FreelancerController::class, 'index'])->name('client.projects.freelancers.index');
            Route::resource('reviews', App\Http\Controllers\Client\Projects\ReviewController::class)->only(['store', 'destroy'])->names([
                'store' => 'client.projects.reviews.store',
                'destroy' => 'client.projects.reviews.destroy',
            ]);
        });
    });

    Route::prefix('freelancer')->group(function () {
        Route::resource('projects', App\Http\Controllers\Freelancer\ProjectController::class, ['only' => ['index', 'show']])->names([
            'index' => 'freelancer.projects.index',
            'show' => 'freelancer.projects.show',
        ]);
        Route::resource('proposals', App\Http\Controllers\Freelancer\ProposalController::class);
        Route::resource('{project}/reviews', App\Http\Controllers\Freelancer\Projects\ReviewController::class)->only(['store', 'destroy'])->names([
            'store' => 'freelancer.projects.reviews.store',
            'destroy' => 'freelancer.projects.reviews.destroy',
        ]);
    });
});