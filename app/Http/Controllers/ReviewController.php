<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReviewService;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $reviewService;
    protected $tegService;
    
    public function __construct(ReviewService $reviewSrevice, TagService $tagService)
    {
        $this->reviewService = $reviewSrevice;
        $this->tagService = $tagService;
    }
    
    public function store(Request $request)
{
        // リクエストデータをバリデーションして変数に代入
        $validated = $request->validate([
            'tags' => 'required|string|max:50',
            'comment' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
            'movie_id' => 'required|exists:movies,id'
        ]);
        
        $review = $this->reviewService->createOrUpdateReview($validated);
        
        // タグの処理
        $tagNames = explode(',', $validated['tags']);
        $tags = $this->tagService->proccessTags($tagNames);

        // 中間テーブルへの保存
        $review->tags()->sync($tags);

        return redirect()->back()->with('success', 'Review created successfully.');

    }
    
    // public function getCreatedReview($movieId)
    // {
    //     return Review::where('movie_id', $movieId)
    //                     ->where('user_id', Auth::id())
    //                     ->with('tags')
    //                     ->first();
        
    // }
}
