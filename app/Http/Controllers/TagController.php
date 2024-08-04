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
    
    public function removeTag($id)
    {
        $user = Auth::user();
        
        // レビューを取得して、ユーザーが所有しているか確認
        $tag = $this->tagService->findTagById($id);
        
        if ($tag) {
            // ユーザーとタグの関連付けを解除
            $user->tags()->detach($tag->id);
            
            // タグが他のユーザーに関連付けられていない場合のみ論理削除を行う
            if ($tag->users()->count() === 0) {
                $this->tagService->deleteTag($tag);
            }
            
            return redirect()->back()->with('success', 'タグが正常に削除されました。');
        }
        
        return redirect()->back()->with('error', 'タグの削除に失敗しました。');
    }
}
