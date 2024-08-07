<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Models\Movie;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
    }
    
    public function popular()
    {
        $popularMovies = $this->tmdbService->getPopularMovies()->results;
        $popularMovies = $this->movieService->mergeAverageScores($popularMovies);
        
        return view('movies.popular', compact('popularMovies',));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!empty($query)) {
            $searchResults = $this->tmdbService->searchMovies($query)->results;
            $searchResults = $this->movieService->mergeAverageScores($searchResults);
        } else {
            $searchResults = [];
        }

        return view('movies.search_results', compact('searchResults'));
    }
    
    public function show($tmdbId)
    {
        // データベースから映画を取得
        $movie = Movie::where('tmdb_id', $tmdbId)->first();
        
        if (!$movie) {
            $movieDetailWithCredits = $this->tmdbService->getMovieDetailWithCredits($tmdbId);
            $movieDetail = $movieDetailWithCredits['movieDetail'];
            $credits = $movieDetailWithCredits['credits'];
            $movie = $this->movieService->storeMovieDetailWithCredits($movieDetail, $credits);
        }
        dd($movie);
        
        // ユーザーの最新のレビューを取得
        $review = Review::where('movie_id', $movie->id)
                        ->where('user_id', Auth::id())
                        ->with('tags')
                        ->latest()
                        ->first();
        
        
        
    
        return view('movies.show', compact('movie', 'review'));
    }
}