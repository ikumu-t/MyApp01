<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [MovieController::class, 'search'])->name('search');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/ranked', [RankingController::class, 'rankedMoviesIndex'])->name('movies.ranked');
Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');

Route::get('/dashboard', [MovieController::class, 'dashboard'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
