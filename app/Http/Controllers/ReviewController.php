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
            'tags' => 'required|string|max:100',
            'comment' => 'string',
            'score' => 'required|integer|min:0|max:100',
            'movie_id' => 'required|exists:movies,id'
        ]);
        
        // レビューを作成または更新
        $review = $this->reviewService->createOrUpdateReview($validated);
        
        // タグの処理
        $tagNames = explode(',', $validated['tags']);
        $tags = $this->tagService->processTags($tagNames);

        // 中間テーブルへの保存
        $review->tags()->sync($tags);

        return redirect()->back()->with('success', 'Review created successfully.');

    }
    
    public function destroy($id)
    {
        // レビューを取得して、ユーザーが所有しているか確認
        $review = $this->reviewService->findReviewById($id);
        
        if ($review && $review->user_id == Auth::id()) {
            $this->reviewService->deleteReview($review);
            return redirect()->back()->with('success', 'レビューが正常に削除されました。');
        }
        
        return redirect()->back()->with('error', 'レビューの削除に失敗しました。');
    }
    
    // public function getCreatedReview($movieId)
    // {
    //     return Review::where('movie_id', $movieId)
    //                     ->where('user_id', Auth::id())
    //                     ->with('tags')
    //                     ->first();
        
    // }
}
