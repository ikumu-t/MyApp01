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
    public function getMovieDetailWithCredits($tmdbId)
    {
        // 映画の詳細情報を取得
        $movieDitailResponse = $this->client->get('movie/' .$tmdbId, [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        
        $movieDitail = json_decode($movieDitailResponse->getBody()->getContents());
        
        // 監督や出演者の情報を取得
        $creditsResponse = $this->client->get('movie/'. $tmdbId. '/credits', [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        $credits = json_decode($creditsResponse->getBody()->getContents());
        
        return [
            'movieDetail' => $movieDitail,
            'credits' => $credits,
        ];
    }
    
    public function getPersonDetail($personId)
    {
        $response = $this->client->get('person/'. $personId, [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        
        return json_decode($response->getBody()->getContents());
    }
    
    public function getMoviesByPerson($personId)
    {
        $response = $this->client->get('person/'. $personId. '/movie_credits', [
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'ja',
            ],
        ]);
        
        return json_decode($response->getBody()->getContents());
    }
}