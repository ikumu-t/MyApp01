<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;

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
        $itemName = 'Serching Results';
        
        return view('movies.index', compact('movies', 'itemName'));
    }
    
}
