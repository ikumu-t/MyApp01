<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use App\Models\Cast;
use App\Services\TmdbService;

class UpdateMovieData extends Command
{
    
    protected $signature = 'movies:update-data';
    protected $description = 'Update movie data by re-fetching from TMDB and saving to the database';

    protected $tmdbService;
    
    public function __construct(TmdbService $tmdbService)
    {
        parent::__construct();
        $this->tmdbService = $tmdbService;
    }
    
    public function handle()
    {
        // すべての映画データを取得
        $movies = Movie::all();
        
        foreach ($movies as $movie) {
            $this->info("Updating movie: {$movie->title}");
            
            // TMDBから映画情報を再取得
            $movieData = $this->tmdbService->getMovieDetailWithCredits($movie->tmdb_id);
            $credits = $movieData['credits'];
            foreach ($credits->cast as $castMember) {
                $cast = Cast::updateOrCreate(
                    ['name' => $castMember->name],
                    [   
                        'person_id' => $castMember->id,
                        'name' => $castMember->name, 'profile_path' => $castMember->profile_path ?? ''
                    ]
                );
                $castData[$cast->id] = ['role' => 'cast', 'character' => $castMember->character];
            }

            // クルー（監督など）のperson_idを更新
            foreach ($credits->crew as $crewMember) {
                if ($crewMember->job === 'Director') {
                    $cast = Cast::updateOrCreate(
                        ['name' => $castMember->name],
                        [
                            'person_id' => $crewMember->id,
                            'name' => $crewMember->name, 'profile_path' => $crewMember->profile_path ?? ''
                        ]
                    );
                    $castData[$cast->id] = ['role' => 'director'];
                }
            }

            // 映画に関連するキャスト・クルーデータを更新
            $movie->casts()->syncWithoutDetaching($castData);

            $this->info("Updated cast data for movie: {$movie->title}");
        }
        
        $this->info('All movie casts have been updated successfully.');
    }
}
