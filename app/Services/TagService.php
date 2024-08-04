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
    
    // タグをidで取得
    public function findTagById($id)
    {
        return Tag::find($id);
    }
    
    // ユーザーのタグを取得
    public function findTagsByUserId($userId)
    {
        return Tag::forUser($userId)->get();
    }
    
    // 論理削除を実行
    public function deleteTag($tag)
    {
        $tag->delete();
    }
    
    public function getTagCount($userId)
    {
        return Tag::where('user_id', $userId)->count();
    }
    
    public function getReviewCountByTag($userTags)
    {
        $tagIds = $userTags->pluck('id')->toArray();
        
        $reviewCountsByTag = Tag::whereIn('id', $tagIds)
            ->withCount('reviews')
            ->get()
            ->pluck('reviews_count', 'id');
            
            foreach ($userTags as $tag) {
            if (isset($reviewCountsByTag[$tag->id])) {
                $tag->review_count = $reviewCountsByTag[$tag->id];
            } else {
                $tag->review_count = 0;
            }
        }
        
        return $userTags;
    }
}