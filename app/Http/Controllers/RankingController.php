<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function rankedMoviesIndex(Request $request)
    {
        $tag = $request->input('tag');
        $myScore = $request->input('my_score');
        $userId = Auth::id();
        
        $tags = Tag::forUser($userId)->get();
        
        $query = Movie::query();
        
        //タグでフィルタリング
        if ($tag) {
            $query->whereHas('reviews.tags', function($q) use ($tag) {
                $q->where('name', $tag);
            });
        }
        if ($myScore === 'yes') {
            $query->whereHas('reviews', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        
        $query->whereHas('reviews');
        
        $movies = $query->with('reviews')
            ->get()
            ->sortByDesc(function($movie) {
                return $movie->reviews->avg('score') ;
            });
        
        return view('movies.ranked', compact('movies', 'tags'));
    }
}


