<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\TagService;

class RankingController extends Controller
{
    protected $tagService;
    
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    public function rankedMoviesIndex(Request $request)
    {
        $tags = explode(',', $request->input('tags'));
        $myScore = $request->input('my_score') === 'yes';
        $userId = Auth::id();
    
        $query = Movie::query()->whereHas('reviews');
    
        // タグによるフィルタリング
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $query->whereHas('reviews.tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }
    
        if ($myScore) {
            // ユーザーのスコアに基づいたフィルタリング
            $query->whereHas('reviews', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
    
        // 映画と関連レビューの読み込み
        $movies = $query->with(['reviews' => function ($q) use ($userId, $myScore) {
            if ($myScore) {
                $q->where('user_id', $userId);
            }
            $q->with('tags');
        }])->get();
    
        $movies = $query->get()->map(function ($movie) use ($userId, $myScore) {
            $movie->custom_score = $myScore ? $movie->reviews->where('user_id', $userId)->first()->score ?? null : $movie->reviews->avg('score');
            return $movie;
        })->sortByDesc('custom_score')->values();  // ここで再インデックス
    
        // 順位を割り当て
        $rank = 1;
        $lastScore = null;
        $movies->transform(function ($movie, $index) use (&$rank, &$lastScore) {
            if ($lastScore !== $movie->custom_score) {
                $lastScore = $movie->custom_score;
                $movie->rank = $rank;
            } else {
                $movie->rank = $rank; // スコアが同じ場合は同じ順位
            }
            $rank++;
            return $movie;
        });
    
        $userTags = $this->tagService->findTagsByUserId($userId);
        $userTags = $this->tagService->getUserReviewCountByTag($userTags);
    
        return view('movies.ranked', compact('movies', 'userTags', 'myScore'));
    }


}
