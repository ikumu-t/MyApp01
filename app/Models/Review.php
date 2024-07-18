<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    /**
     *ユーザーモデルと多対１のリレーション 
     */
    public function users()
    {
        return $this->belongTo(User::class);
    }
    
    public function tags()
    {
        return $this->belongToMany(Tag::class);
    }
}
