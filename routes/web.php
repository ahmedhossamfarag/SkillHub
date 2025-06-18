<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'auth']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');