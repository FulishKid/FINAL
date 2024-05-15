<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class Vote extends Model
{
    use HasFactory;
    protected $table = 'votes';
    protected $primaryKey = 'vote_id';

    protected $fillable = [
        'thread_id', 'user_id', 'vote_type'
    ];

    public function thread() {
        return $this->belongsTo(Thread::class, 'thread_id', 'thread_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    const UPVOTE = 1;
    const DOWNVOTE = -1;

    public static function getVoteType($type)
    {
        return $type === 'up' ? self::UPVOTE : self::DOWNVOTE;
    }

}

