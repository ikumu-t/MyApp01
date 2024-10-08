<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService 
{
    // レビューの作成または更新処理
    public function createOrUpdateReview($validated)
    {
        return Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $validated['movie_id'],
            ],
            [
                'comment' =>$validated['comment'],
                'score' => $validated['score'],
            ]
        );
    }
    
    // レビューをidで取得
    public function findReviewById($id)
    {
        return Review::find($id);
    }
    
    // 論理削除を実行
    public function deleteReview($review)
    {
        $review->delete();
    }
    
    // レビュー件数を取得
    public function getReviewCount($userId)
    {
        return Review::where('user_id', $userId)->count();
    }
    
    // ユーザーの平均スコア
    public function getAvgScore($userId)
    {
        return Review::where('user_id', $userId)->avg('score');
    }
    
    // 最新のレビューを取得
    public function getlatestReviews($count)
    {
        return Review::with('movies', 'users')
                        ->latest()
                        ->take($count)
                        ->get();
    }
    
}