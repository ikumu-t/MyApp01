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
        $this->movieService->storeMoviesData($popularMovies);
        
        $tmdbIds = array_map(function ($movie) {
            return $movie->id;
        }, $popularMovies);
        
        $popularMovies = Movie::getMoviesByTmdbIds($tmdbIds);
        
        return view('movies.popular', compact('popularMovies',));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!empty($query)) {
            $searchResults = $this->tmdbService->searchMovies($query)->results;
            $this->movieService->storeMoviesData($searchResults);
            $searchResults = Movie::getSearchResults($query);
        } else {
            $searchResults = [];
        }

        return view('movies.search_results', compact('searchResults'));
    }
    
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        
        $review = Review::where('movie_id', $id)
                        ->where('user_id', Auth::id())
                        ->with('tags')
                        ->latest()
                        ->first();
        
        $tmdbId = $movie->tmdb_id;
        $movieDitail = $this->tmdbService->getMovieDetail($tmdbId);

        return view('movies.show', compact('movie', 'review'));
    }
} 