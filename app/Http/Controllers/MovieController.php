<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Models\Movie;
use App\Models\Review;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MovieController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
    }
    
    public function popular()
    {
        $popularMovies = $this->tmdbService->getPopularMovies()->results;
        $popularMovies = collect($popularMovies);// 一旦コレクションに変換
        $popularMovies = $this->movieService->mergeAverageScoresForIndex($popularMovies);
        
        // 詳細画面の戻るボタンようにセッションにURLを保存
        session(['previous_page' => url()->full()]);
        
        return view('movies.popular', compact('popularMovies',));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!empty($query)) {
            $searchResults = $this->tmdbService->searchMovies($query)->results;
            $searchResults = collect($searchResults);// 一旦コレクションに変換
            $searchResults = $this->movieService->mergeAverageScoresForIndex($searchResults);
        } else {
            $searchResults = [];
        }
        
        // 詳細画面の戻るボタンようにセッションにURLを保存
        session(['previous_page' => url()->full()]);

        return view('movies.search_results', compact('searchResults'));
    }
    
    // 映画詳細画面の表示
    public function show($tmdbId)
    {
        // データベースから映画を取得
        $movie = Movie::where('tmdb_id', $tmdbId)
            ->with(['casts' => function($query) {
                $query->take(10);
            }, 'genres', 'reviews'])
            ->first();
            
        // データベースに存在しない映画はAPIから取得
        if (!$movie) {
            $movieDetailWithCredits = $this->tmdbService->getMovieDetailWithCredits($tmdbId);
            $movieDetail = $movieDetailWithCredits['movieDetail'];
            $credits = $movieDetailWithCredits['credits'];
            $movie = $this->movieService->storeMovieDetailWithCredits($movieDetail, $credits);
        }
        
        // キャストのうち10人をロード
        $movie->load(['casts' =>function($query) {
            $query->take(10);
        }]);
        
        // キャストから監督を抽出
        $director = $movie->casts()->wherePivot('role', 'director')->first();
        
        // ユーザーの最新のレビューを取得
        $reviews = $movie->reviews;
        return view('movies.show', compact('movie', 'director', 'reviews'));
    }
    
    // 全キャスト表示画面
    public function showCastIndex(Movie $movie)
    {
        $movie->load('casts');
        return view('movies.casts_index', compact('movie'));
    }
    
    // ジャンルで検索
    public function moviesByGenre(Genre $genre) 
    {
        $genreId = $genre->tmdb_id;
        $movies = $this->tmdbService->getMoviesByGenre($genreId)->results;
        $movies = collect($movies);
        $movies = $this->movieService->mergeAverageScoresForIndex($movies);
        
        return view('movies.by_genre', compact('movies', 'genre'));
    }
}