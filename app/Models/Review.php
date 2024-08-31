<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'movie_id',
        'score',
        'comment'
    ];
    
    /**
     * ユーザーモデルと多対１のリレーション 
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function movies()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
    
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_review');
    }
    
}
