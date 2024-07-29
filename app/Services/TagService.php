<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagService
{
    public function proccessTags($tagNames)
    {
        $tags = [];
        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            $tag = Tag::firstOrCreate(['name' => $tagName],['user_id' => Auth::id()]);
            $tags[] = $tag->id;
        }
        return $tags;
    }
}