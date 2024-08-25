<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;
    
    protected $fillable = ['person_id', 'name', 'profile_path'];
    
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'cast_movie')
            ->withPivot('role', 'character')
            ->withTimestamps();
            
    }
}
