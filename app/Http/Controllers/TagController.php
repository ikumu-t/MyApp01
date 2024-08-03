<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagService;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;


class TagController extends Controller
{
    protected $tagService;
    
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    
    public function destroy($id)
    {
        // レビューを取得して、ユーザーが所有しているか確認
        $review = $this->tagService->findTagById($id);
        
        if ($tag && $tag->user_id == Auth::id()) {
            $this->tagService->deleteTag($tag);
            return redirect()->back()->with('success', 'タグが正常に削除されました。');
        }
        
        return redirect()->back()->with('error', 'タグの削除に失敗しました。');
    }
    
    // タグサジェスト
    public function suggest(Request $request)
    {
        $query = $request->input('query');
        $tags = Tag::where('name', 'LIKE', "%{query}%")->pluck(['id','name']);
        return response()->json(['suggestions' => $tags]);
    }
    
}
