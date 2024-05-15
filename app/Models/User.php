<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 * @mixin Builder
 */

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'user_id';


    protected $fillable = [
        'username', 'email', 'password'
    ];
    public function generateVerificationToken()
    {
        $this->verification_token = Str::random(40);
        $this->save();
    }
    public function profile() {

        return $this->hasOne(Profile::class, 'user_id', 'user_id');

    }

    public function threads() {
        return $this->hasMany(Thread::class, 'creator_id', 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class, 'user_id', 'user_id');
    }

    public function favoriteArtists() {
        return $this->belongsToMany(Artist::class, 'favorite_artists', 'user_id', 'artist_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
