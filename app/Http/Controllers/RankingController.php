<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Movie;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    protected $tagService;
    
    public function __construct(Tagservice $tagSercice)
    {
        $this->tagService = $tagSercice;
    }
    
    public function rankedMoviesIndex(Request $request)
    {
        $tags = explode(',', $request->input('tags', ''));
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
    
        // ユーザースコアによるフィルタリング
        if ($myScore === 'yes') {
            $query->whereHas('reviews', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
    
        // スコアに基づいて映画をランク付け
        $movies = $query->with(['reviews.tags'])
                        ->withCount(['reviews as average_score' => function ($query) {
                            $query->select(DB::raw('avg(score)'));
                        }])
                        ->orderByDesc('average_score')
                        ->get();
    
        $userTags = $this->tagService->findTagsByUserId($userId);
        $userTags = $this->tagService->getReviewCountByTag($userTags)->sortByDesc('review_count');
    
        return view('movies.ranked', compact('movies', 'userTags'));
    }

}
