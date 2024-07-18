<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    public function users()
    {
        $this->belongTo(User::class);
    }
    
    public function reviews()
    {
        $this->blongToMany(Review::class);
    }
}
