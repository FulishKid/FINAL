<?php



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
namespace App\Models;


class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'thread_id', 'user_id'];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

