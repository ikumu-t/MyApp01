<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Movie;
use App\Models\Review;

class TestController extends Controller
{
    public function index()
{
    $popularMovies = Movie::orderBy('popularity', 'desc')->take(8)->get();
    $latestReviews = Review::with('movie')->latest()->take(8)->get();
    $popularTags = Tag::withCount('reviews')->orderBy('reviews_count', 'desc')->take(10)->get();

    return view('home', compact('popularMovies', 'latestReviews', 'popularTags'));
}

}
