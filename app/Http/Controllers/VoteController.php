<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @mixin  AuthorizesRequests
 * @mixin  ValidatesRequests
 *
 */

class VoteController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;
    public function store(Request $request, $threadId)
    {
        $this->validate($request, [
            'vote_type' => 'required|in:up,down',
        ]);

        $thread = Thread::where('thread_id', $threadId)->first();

        $existingVote = Vote::where('thread_id', $thread->thread_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'You have already voted on this thread'], 400);
        }

        $vote = Vote::create([
            'thread_id' => $thread->thread_id,
            'user_id' => Auth::id(),
            'vote_type' => Vote::getVoteType($request->vote_type),
        ]);

        return response()->json($vote, 201);
    }

    public function destroy($voteId)
    {
        $vote = Vote::findOrFail($voteId);
        $this->authorize('delete', $vote);

        $vote->delete();
        return response()->json(null, 204);
    }

    public function getThreadRating($threadId)
    {
        $thread = Thread::where('thread_id' , $threadId)->first();
        return response()->json(['rating' => $thread->rating]);
    }
}
