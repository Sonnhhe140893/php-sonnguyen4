<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/admin/login', [PostController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [PostController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [PostController::class, 'logout'])->name('admin.logout');

Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('admin.posts');
Route::post('/admin/posts', [PostController::class, 'store'])->name('admin.posts.store');
Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');
Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
