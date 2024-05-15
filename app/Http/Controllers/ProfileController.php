<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Thread;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

/**
 * @mixin  AuthorizesRequests
 * @mixin  ValidatesRequests
 * @mixin  Log
 */
class ProfileController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;
    public function show()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->user_id)->firstOrFail();

        return response()->json($profile);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'bio' => 'nullable|string',
            'favorite_genres' => [
                'nullable',
                'regex:/^(\s*\b[\w-]+\b\s*(?:,\s*)?){0,5}$/'
            ],
            'favorite_artists' => 'nullable|string',
        ]);
        Log::info('Updating profile with data: ', $request->all());
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->user_id)->firstOrFail();

        $profile->update($request->only(['bio', 'favorite_genres', 'favorite_artists']));

        return response()->json($profile);
    }

    public function getRating()
    {
        $user = Auth::user();
        $threads = Thread::where('creator_id', $user->user_id)->pluck('id');

        $upvotes = Vote::whereIn('thread_id', $threads)->where('vote_type', Vote::UPVOTE)->count();
        $downvotes = Vote::whereIn('thread_id', $threads)->where('vote_type', Vote::DOWNVOTE)->count();

        $rating = $upvotes - $downvotes;

        return response()->json(['rating' => $rating]);
    }
}
