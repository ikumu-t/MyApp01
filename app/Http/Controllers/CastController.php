<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Models\Cast;

class CastController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
    }
    
    public function show(Cast $cast)
    {
        $movies = $this->tmdbService->getMoviesByPerson($cast->person_id);
        $moviesAsCast = collect($movies->cast)->sortByDesc('popularity')->take(20);
        $moviesAsDirector = collect($movies->crew)
            ->filter(function ($crewMember) {
                return $crewMember->job === 'Director';
            })
            ->sortByDesc('popularity')
            ->take(20);
        
        $castDetail = $this->tmdbService->getPersonDetail($cast->person_id);
        $birthDate = new \DateTime($castDetail->birthday);
        $today = new \DateTime('today');
        $age = $birthDate->diff($today)->y;
        $moviesAsCast = $this->movieService->mergeAverageScoresForIndex($moviesAsCast);
        $moviesAsDirector = $this->movieService->mergeAverageScoresForIndex($moviesAsDirector);
            
        return view('cast-show', compact('cast', 'moviesAsCast', 'moviesAsDirector', 'castDetail', 'age'));
    }
}
