<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'profile_id';

    protected $fillable = [
        'user_id', 'bio', 'favorite_genres', 'favorite_artists', 'reputation_points'
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public $timestamps = false;
}

