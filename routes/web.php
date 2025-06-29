<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::get('/explore', [App\Http\Controllers\SearchController::class, 'index'])->name('explore');

Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'auth']);
Route::view('/forgot-password', 'user.forgot-password')->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\UserController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\UserController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');


    Route::get('/verify-email', [App\Http\Controllers\UserController::class, 'verifyEmail'])->middleware('throttle:1,5')->name('verification.send');
    Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');

    Route::get('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{profile}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('admin')->group(function () {
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('tags', App\Http\Controllers\Admin\TagController::class);
        Route::resource('posts', App\Http\Controllers\Admin\PostsController::class)->only(['index', 'create', 'store', 'destroy'])->names([
            'index' => 'admin.posts.index',
            'create' => 'admin.posts.create',
            'store' => 'admin.posts.store',
            'destroy' => 'admin.posts.destroy',
        ]);
    });

    Route::prefix('client')->group(function () {
        Route::resource('projects', App\Http\Controllers\Client\ProjectController::class);
        Route::prefix('projects/{project}')->group(function () {
            Route::resource('proposals', App\Http\Controllers\Client\Projects\ProposalController::class)->only(['index'])->names([
                'index' => 'client.projects.proposals.index',
            ]);
            Route::post('proposals/{proposal}/accept', [App\Http\Controllers\Client\Projects\ProposalController::class, 'accept'])->name('client.projects.proposals.accept');
            Route::post('proposals/{proposal}/reject', [App\Http\Controllers\Client\Projects\ProposalController::class, 'reject'])->name('client.projects.proposals.reject');
            Route::get('freelancers', [App\Http\Controllers\Client\Projects\FreelancerController::class, 'index'])->name('client.projects.freelancers.index');
            Route::resource('reviews', App\Http\Controllers\Client\Projects\ReviewController::class)->only(['store', 'destroy'])->names([
                'store' => 'client.projects.reviews.store',
                'destroy' => 'client.projects.reviews.destroy',
            ]);
            Route::resource('uploads', App\Http\Controllers\Client\Projects\UploadController::class)->only(['index', 'create', 'store', 'show', 'destroy'])->names([
                'index' => 'client.projects.uploads.index',
                'create' => 'client.projects.uploads.create',
                'store' => 'client.projects.uploads.store',
                'show' => 'client.projects.uploads.show',
                'destroy' => 'client.projects.uploads.destroy',
            ]);

            Route::resource('messages', App\Http\Controllers\Client\Projects\ChatController::class)->only(['index', 'store'])->names([
                'index' => 'client.projects.messages.index',
                'store' => 'client.projects.messages.store',
            ]);

            Route::resource('payments', App\Http\Controllers\Client\Projects\PaymentController::class)->only(['index', 'create'])->names([
                'index' => 'client.projects.payments.index',
                'create' => 'client.projects.payments.create',
            ]);

            Route::post('/checkout', [App\Http\Controllers\Client\StripeController::class, 'createSession'])->name('checkout.create');
            Route::get('/checkout/success', [App\Http\Controllers\Client\StripeController::class, 'success'])->name('checkout.success');
            Route::get('/checkout/cancel', [App\Http\Controllers\Client\StripeController::class, 'cancel'])->name('checkout.cancel');
        });
    });

    Route::prefix('freelancer')->group(function () {
        Route::resource('projects', App\Http\Controllers\Freelancer\ProjectController::class, ['only' => ['index', 'show']])->names([
            'index' => 'freelancer.projects.index',
            'show' => 'freelancer.projects.show',
        ]);
        Route::resource('proposals', App\Http\Controllers\Freelancer\ProposalController::class)->only(['index', 'store', 'create']);
        Route::resource('projects/reviews', App\Http\Controllers\Freelancer\Projects\ReviewController::class)->only(['store', 'destroy'])->names([
            'store' => 'freelancer.projects.reviews.store',
            'destroy' => 'freelancer.projects.reviews.destroy',
        ]);
    });
    Route::get('/user/stripe/create-account', [App\Http\Controllers\Client\StripeController::class, 'createAccount'])->name('create-account');
});

Route::post('/webhook/stripe', [App\Http\Controllers\Client\StripeController::class, 'handleWebhook']);
