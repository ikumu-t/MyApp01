<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Genre;
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
    
    public function storeGenres($movieDitail)
    {
        $genres = $movieDetail->genres;
        foreach ($genres as $genreData) {
            $genre = Genre::firstOrCreate(['id' => $genreData->id], ['name' => $genreData->name]);
            dd($genre);
            $movie->genres()->attach($genre->id);
        }
    }
    
    public function mergeAverageScores($movies)
    {
        // APIから取得した映画情報からtmdbIdを配列で抽出
        $tmdbIds = array_map(function ($movie) {
            return $movie->id;
        }, $movies);
        
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
        
        $genres = $movieDetail->genres;
        $genreIds = [];
        foreach ($genres as $genreData) {
            $genre = Genre::firstOrCreate(['id' => $genreData->id], ['name' => $genreData->name]);
            $genreIds[] = $genre->id;
            
        }
        
        $movie->genres()->syncWithoutDetaching($genreIds);
        
        return $movie;
    }
    
}