<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ArticleController::class, 'get'], function(){
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::delete('/profile/remove_image', [ProfileController::class, 'removeImage'])->name('profile.remove_image');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/article/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::get('/article/edit/{id}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/article/update/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('delete.article');
    Route::get('/my/articles', [ArticleController::class, 'my'])->name('my.articles');
    Route::get('/draft/articles', [ArticleController::class, 'drafts'])->name('draft.articles');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/filter', [ArticleController::class, 'filter'])->name('articles.filter');
    Route::post('/like', [LikeController::class, 'liked'])->name('like');
    Route::get('/articles/{article}/comments', [CommentController::class, 'get'])->name('articles.comments');
    Route::post('/articles/{article}/comments', [CommentController::class, 'create'])->name('comments.store');
    Route::delete('/photos/{id}', [ArticleController::class, 'deletePhoto'])->name('photos.destroy');
});

require __DIR__.'/auth.php';
