<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts');

// Posts
Route::resource('posts', PostController::class);
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');

// Auth pages
Route::get('/home', fn () => redirect('/dashboard'))->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('admin.redirect')
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/users', [AuthController::class, 'store']);

    Route::get('/users/{user}/role', [AuthController::class, 'editRole'])->name('users.role.edit');
    Route::post('/users/{user}/role', [AuthController::class, 'updateRole'])->name('users.role.update');

    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
});
