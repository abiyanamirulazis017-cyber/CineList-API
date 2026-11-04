<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'slug', 'overview', 'poster_path',
        'vote_average', 'release_date', 'runtime',
        'tagline', 'genre_id', 'user_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function watchlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'watchlists')->withTimestamps();
    }
}