<?php

namespace App\Services;

use App\Models\Movie;
use Carbon\Carbon;

class MovieService
{
    public function storeMoviesData($movies)
    {
        foreach ($movies as $movieData) {
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
}