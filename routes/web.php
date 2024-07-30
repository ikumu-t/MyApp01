<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RankingController;
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
Route::middleware('auth')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/destroy', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test route
Route::get('/test', function() {
    return view('test');
})->name('test');

require __DIR__.'/auth.php';
