<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TagController;

use Illuminate\Support\Facades\Route;

//Welcome route
Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::prefix('movies')->group(function () {
    Route::get('popular', [MovieController::class, 'popular'])->name('movies.popular');
    Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
    Route::get('/ranked', [RankingController::class, 'rankedMoviesIndex'])->name('movies.ranked');
    Route::get('/{id}', [MovieController::class, 'show'])->name('movies.show');
});

// Review routes
Route::middleware('auth')->prefix('reviews')->group(function () {
    Route::post('/store', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Tag routes
Route::get('tags/suggest', [TagController::class, 'suggest'])->name('tags.suggest');


// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tag route
Route::delete('/tags/{id}', [TagController::class, 'removeTag'])->name('tags.destroy');

// Stats route
Route::middleware('auth')->prefix('stats')->group(function () {
    Route::get('/index', [StatsController::class, 'index'])->name('stats.index');
});




require __DIR__.'/auth.php';
