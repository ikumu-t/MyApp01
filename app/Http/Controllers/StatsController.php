<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ReviewService;
use App\Services\TagService;

class StatsController extends Controller
{
    protected $reviewService;
    protected $tagService;
    
    public function __construct(ReviewService $reviewService, TagService $tagService)
    {
        $this->reviewService = $reviewService;
        $this->tagService = $tagService;
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // レビュー件数とタグの作成数を取得
        $reviewCount = $this->reviewService->getReviewCount($user->id);
        $tagCount = $this->tagService->getTagCount($user->id);
        $avgScore = round($this->reviewService->getAvgScore($user->id));
        
        $userTags = $this->tagService->findTagsByUserId($user->id);
        $userTags = $this->tagService->getReviewCountByTag($userTags)->sortByDesc('review_count');
        
        return view('stats.index', 
        compact(
            'user',
            'reviewCount',
            'tagCount', 
            'avgScore',
            'userTags'
            ));
    }
}
