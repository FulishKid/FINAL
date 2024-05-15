<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class Artist extends Model
{
    use HasFactory;
    protected $table = 'artists';
    protected $primaryKey = 'artist_id';

    protected $fillable = [
        'spotify_artist_id', 'name'
    ];

    public function threads() {
        return $this->hasMany(Thread::class, 'artist_id', 'artist_id');
    }

    public function favoriteByUsers() {
        return $this->belongsToMany(User::class, 'favorite_artists', 'artist_id', 'user_id');
    }

    public $timestamps = false;
}

