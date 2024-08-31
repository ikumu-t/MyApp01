<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Person;
use Carbon\Carbon;

class MovieService
{
    public function mergeAverageScoresForIndex($movies)
    {
        // APIから取得した映画情報からtmdbIdを配列で抽出
        $tmdbIds = $movies->map(function ($movie) {
            return $movie->id;
        })->toArray();
        
        // レビューが存在する映画の平均スコアを取得
        $scores = Movie::whereIn('tmdb_id', $tmdbIds)
                                ->withAvg('reviews', 'score')
                                ->pluck('reviews_avg_score', 'tmdb_id');
                                
        // $popularMoviesに平均スコアをマージ
        foreach ($movies as $movie) {
            $movie->avg_score = $scores->get($movie->id) ?? 'N/A';
        }
        
        return $movies;
    }
    
    public function storeMovieDetailWithCredits($movieDetail, $credits)
    {
        $movie = Movie::updateOrCreate(
            ['tmdb_id' => $movieDetail->id],
            [
                'title' => $movieDetail->title, 
                'overview' => $movieDetail->overview, 
                'release_date' => $movieDetail->release_date,
                'poster_path' => $movieDetail->poster_path,
            ]
        );
        
        // ジャンルデータの保存
        $genres = $movieDetail->genres;
        $genreIds = [];
        foreach ($genres as $genreData) {
            $genre = Genre::firstOrCreate(
                ['tmdb_id' => $genreData->id], 
                ['name' => $genreData->name]);
            $genreIds[] = $genre->id;
        }
        $movie->genres()->syncWithoutDetaching($genreIds);
        
        // キャストの処理
        $personData = [];
        foreach ($credits->cast as $castMember) {
            $person = Person::firstOrCreate(
                ['tmdb_id' => $castMember->id],
                [
                    'name' => $castMember->name,
                    'profile_path' => $castMember->profile_path ?? ''
                ]
            );
            $personData[$person->id] = ['role' => 'cast', 'character' => $castMember->character];
        }
        
        foreach ($credits->crew as $crewMember) {
            if ($crewMember->job === 'Director') {
                $person = Person::firstOrCreate(
                    ['tmdb_id' => $crewMember->id],
                    [
                        'name' => $crewMember->name,
                        'profile_path' => $crewMember->profile_path ?? ''
                    ]
                );
                $personData[$person->id] = ['role' => 'director'];
            }
        }
        $movie->people()->syncWithoutDetaching($personData);
        
        return $movie;
    }
}  
    
