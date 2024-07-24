<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    \Log::info('ReviewController@store called');
    
        // リクエストデータをバリデーションして変数に代入
        $validated = $request->validate([
            'tags' => 'required|string|max:50',
            'comment' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
            'movie_id' => 'required|exists:movies,id'
        ]);

        \Log::info('Validated data:', $validated);

        // レビューの保存
        // $review = new Review();
        // $review->comment = $validated['comment'];
        // $review->score = $validated['score'];
        // $review->movie_id = $validated['movie_id'];
        // $review->user_id = Auth::id();
        
        // $review->save();
        
        $review = Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $validated['movie_id'],
            ],
            [
                'comment' =>$validated['comment'],
                'score' => $validated['score'],
            ]
        );
        
        // タグの処理
        $tagNames = explode(',', $validated['tags']);
        $tags = [];

        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName],['user_id' => Auth::id()]);
            $tags[] = $tag->id;
        }
        \Log::info('Tags to sync:', $tags);

        // 中間テーブルへの保存
        $review->tags()->sync($tags);

        return redirect()->back()->with('success', 'Review created successfully.');

    }
    
    public function getCreatedReview($movieId)
    {
        return Review::where('movie_id', $movieId)
                        ->where('user_id', Auth::id())
                        ->with('tags')
                        ->first();
        
    }
}
