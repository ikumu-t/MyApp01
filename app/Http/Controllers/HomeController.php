<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Services\ReviewService;

class HomeController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    protected $reviewService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService, ReviewService $reviewService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
        $this->reviewService = $reviewService;
    }
    public function home()
    {
        $popularMovies = $this->tmdbService->getPopularMovies()->results;
        $popularMovies = collect($popularMovies);
        $popularMovies = $this->movieService->mergeAverageScoresForIndex($popularMovies);
        $latestReviews = $this->reviewService->getlatestReviews(5);
        
        session(['previous_page' => url()->full()]);

        return view('home', compact('popularMovies', 'latestReviews'));
    }
}