<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService 
{
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
}