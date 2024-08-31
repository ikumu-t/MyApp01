<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Services\ReviewService;
use App\Services\TagService;
use App\Models\Genre;

class HomeController extends Controller
{
    protected $tmdbService;
    protected $movieService;
    protected $reviewService;
    protected $tagService;
    
    public function __construct(TmdbService $tmdbService, MovieService $movieService, ReviewService $reviewService, TagService $tagService)
    {
        $this->tmdbService = $tmdbService;
        $this->movieService = $movieService;
        $this->reviewService = $reviewService;
        $this->tagService = $tagService;
    }
    
    public function home()
    {
        // 人気映画の取得（TMDB）
        $popularMovies = $this->tmdbService->getPopularMovies()->results;
        $popularMovies = collect($popularMovies);
        $popularMovies = $this->movieService->mergeAverageScoresForIndex($popularMovies);
        
        // 最新レビューの取得
        $latestReviews = $this->reviewService->getlatestReviews(5);
        
        // 人気のタグ
        $top10Tags = $this->tagService->getTop10TagsByReviewCount();

        $top10Genres = Genre::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(10)
            ->get();
        // 詳細画面の戻るボタンようにセッションにURLを保存
        session(['previous_page' => url()->full()]);

        return view('home', compact('popularMovies', 'latestReviews', 'top10Tags', 'top10Genres'));
    }
}