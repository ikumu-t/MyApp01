<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Models\Movie;
use Carbon\Carbon;

class MovieController extends Controller
{
    protected $tmdbService;
    
    public function __construct(TmdbService $tmdbSercice)
    {
        $this->tmdbService =$tmdbSercice;
    }
    
    public function index()
    {
        $movies = $this->tmdbService->getPopularMovies()->results;
        
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
        
        $movies = Movie::getSearchResults($query);

        return view('movies.index', compact('movies'));
    }
    
    public function saveMoviesData($movies)
    {
        foreach ($movies as $movieData) {
            //dd($movieData -> poster_path);
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
        //dd($movie);
        return view('movies.show', compact('movie'));
    }
}
