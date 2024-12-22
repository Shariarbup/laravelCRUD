<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome', ['posts' => Post::all()]);
})->name('home');

Route::get('/create', [PostController::class, 'createNewPost']);
Route::post('/store-post', [PostController::class, 'storePost']) -> name('store-post');
Route::post('/update-post/{id}', [PostController::class, 'updatePost']) -> name('update-post');
Route::get('/edit-post/{id}', [PostController::class, 'editPost'])-> name('edit-post');
Route::get('/delete-post/{id}', [PostController::class, 'deletePost'])-> name('delete-post');
