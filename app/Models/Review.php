<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'movie_id',
        'score',
        'comment'
    ];
    
    /**
     *ユーザーモデルと多対１のリレーション 
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function movies()
    {
        return $this->belongsTo(Movie::class);
    }
    
}
