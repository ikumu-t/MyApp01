<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Services\MovieService;
use App\Models\Movie;
use App\Models\Review;
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
        // $this->movieService->storeMoviesData($popularMovies);
        
        // APIから取得した映画情報からtmdbIdを配列で抽出
        $tmdbIds = array_map(function ($movie) {
            return $movie->id;
        }, $popularMovies);
        
        $scores = Movie::whereIn('tmdb_id', $tmdbIds)
                                ->withAvg('reviews', 'score')
                                ->pluck('reviews_avg_score', 'tmdb_id');
        //dd($scores);
        foreach ($popularMovies as $movie) {
            $movie->avg_score = $scores->get($movie->id) ?? 'N/A';
        }
        
        //$popularMovies = Movie::getMoviesByTmdbIds($tmdbIds);
        
        return view('movies.popular', compact('popularMovies',));
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!empty($query)) {
            $searchResults = $this->tmdbService->searchMovies($query)->results;
            $this->movieService->storeMoviesData($searchResults);
            $searchResults = Movie::getSearchResults($query);
        } else {
            $searchResults = [];
        }

        return view('movies.search_results', compact('searchResults'));
    }
    
    public function show($id)
    {
        // データベースから映画を取得
        $movie = Movie::findOrFail($id);
        
        // ユーザーの最新のレビューを取得
        $review = Review::where('movie_id', $id)
                        ->where('user_id', Auth::id())
                        ->with('tags')
                        ->latest()
                        ->first();
        
        // 映画の詳細とクレジットをデータベースに保存
        $tmdbId = $movie->tmdb_id;
        
        if (!$movie->credits()->exists()) {
            $movieDitailWithCredits = $this->tmdbService->getMovieDitailWithCredits($tmdbId);
            $this->movieService->storeMovieDetailWithCredits($movieDetailWithCredits);
            $movie = Movie::with(['genles', 'credits'])->findOrFail($id);
        }
    
        return view('movies.show', compact('movie', 'review'));
    }
}