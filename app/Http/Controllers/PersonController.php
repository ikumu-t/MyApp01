<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Models\Person;

class PersonController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
    }
    
    public function show(Person $person)
    {
        $movies = $this->tmdbService->getMoviesByPerson($person->tmdb_id);
        $moviesAsCast = collect($movies->cast)->sortByDesc('popularity')->take(20);
        $moviesAsDirector = collect($movies->crew)
            ->filter(function ($crewMember) {
                return $crewMember->job === 'Director';
            })
            ->sortByDesc('popularity')
            ->take(20);
        
        $personDetail = $this->tmdbService->getPersonDetail($person->tmdb_id);
        $birthDate = new \DateTime($personDetail->birthday);
        $today = new \DateTime('today');
        $age = $birthDate->diff($today)->y;
        $moviesAsCast = $this->movieService->mergeAverageScoresForIndex($moviesAsCast);
        $moviesAsDirector = $this->movieService->mergeAverageScoresForIndex($moviesAsDirector);
            
        return view('person_show', compact('person', 'moviesAsCast', 'moviesAsDirector', 'personDetail', 'age'));
    }
}
