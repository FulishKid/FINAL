<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Thread $thread)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Thread $thread)
    {
        return $user->id === $thread->creator_id;
    }

    public function delete(User $user, Thread $thread)
    {
        return $user->id === $thread->creator_id;
    }
}
