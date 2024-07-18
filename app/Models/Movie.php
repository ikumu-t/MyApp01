<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
   
    protected $fillable = [
       'tmdb_id', 'title', 'release_date', 'overview', 'poster_path'
    ];
    
    public static function getSearchResults($query)
    {
        return Movie::where('title', 'LIKE', '%'.$query.'%')->get();
    }
    
    public static function getMoviesByTmdbIds($tmdb_ids) {
        return Movie::whereIn('tmdb_id', $tmdb_ids)
                    ->orderByRaw("FIELD(tmdb_id, '" . implode("','", $tmdb_ids) . "')")
                    ->get();
    }
}
