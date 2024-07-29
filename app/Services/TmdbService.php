<?php

namespace App\Services;

use GuzzleHttp\Client;

class TmdbService
{
    protected $client;
    protected $apiKey;
    
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.themoviedb.org/3/',
        ]);
        $this->apiKey = config('services.tmdb.api_key');
    }
    
    public function searchMovies($query)
    {
        $response = $this->client->get('search/movie', [
            'query' => [
                'api_key' => $this->apiKey,
                'query' => '%' . $query . '%',
                'language' => 'ja',
            ],
        ]);
        
        return json_decode($response->getBody()->getContents());
    }
    
    public function getPopularMovies()
    {
        $response = $this->client->get('movie/popular', [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        return json_decode($response->getBody()->getContents());
    }
    
    // //映画詳細情報の取得
    public function getMovieDetail($tmdbId)
    {
        $response = $this->client->get('movie/' .$tmdbId, [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        return json_decode($response->getBody()->getContents());
    }
}