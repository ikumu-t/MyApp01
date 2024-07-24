<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Models\Movie;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{
    protected $tmdbService;
    
    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }
    
    public function dashboard()
    {
        $movies = $this->tmdbService->getPopularMovies()->results;
        $this->saveMoviesData($movies);
        foreach ($movies as $movie) {
            $tmdb_ids[] = $movie->id;
        }
        //dd($tmdb_ids);
        $movies = Movie::getMoviesByTmdbIds($tmdb_ids);
        //dd($movies);
        
        return view('dashboard', compact('movies',));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!empty($query)) {
            $movies = $this->tmdbService->searchMovies($query)->results;
        } else {
            $movies = [];
        }
        $this->saveMoviesData($movies);
        
        if (!empty($query)) {
            $movies = Movie::getSearchResults($query);
        } else {
            $movies = [];
        }

        return view('movies.search_results', compact('movies'));
    }
    
    public function saveMoviesData($movies)
    {
        foreach ($movies as $movieData) {
            //dd($movieData);
            $movie = Movie::updateOrCreate(
                ['tmdb_id' => $movieData->id],
                [
                    'tmdbid' => $movieData->id,
                    'title' => $movieData->title,
                    'director' => isset($movieData->director) ? $movieData->director : null,
                    'release_date' =>isset($movieData->release_date) ? Carbon::parse($movieData->release_date) : null,
                    'overview' => $movieData->overview,
                    'poster_path' => $movieData->poster_path ?? null,
                    ]
                );
        }
    }
    
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        
        $review = Review::where('movie_id', $id)
                        ->where('user_id', Auth::id())
                        ->with('tags')
                        ->latest()
                        ->first();
                        //dd($review);
        return view('movies.show', compact('movie', 'review'));
    }
} 