<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class Thread extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'artist_id', 'creator_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }


}

