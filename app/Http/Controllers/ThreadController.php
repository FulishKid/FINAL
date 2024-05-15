<?php

namespace App\Http\Controllers;

use App\Models\Artist;
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

class ThreadController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;

    public function index()
    {
        $threads = Thread::all();
        return response()->json($threads);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content_' => 'required|string',
            'spotify_artist_id' => 'required|string',
            'artist_name' => 'required|string|max:255',
        ]);

        $artist = Artist::firstOrCreate(
            ['spotify_artist_id' => $request->spotify_artist_id],
            ['name' => $request->artist_name]
        );


        $thread = Thread::create([
            'title' => $request->title,
            'content' => $request->content_,
            'artist_id' => $artist->artist_id,
            'creator_id' => Auth::id(),
        ]);

        return response()->json($thread, 201);
    }

    public function show($id)
    {
        $thread = Thread::findOrFail($id);
        return response()->json($thread);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'sometimes|required|string|max:255',
            'content_' => 'sometimes|required|string',
        ]);

        $thread = Thread::findOrFail($id);
        $this->authorize('update', $thread);

        $thread->update($request->only(['title', 'content_']));
        return response()->json($thread);
    }

    public function destroy($id)
    {
        $thread = Thread::where('thread_id', $id)->firstOrFail();


        $thread->delete();
        return response()->json(null, 204);
    }

    public function getThreadsBySpotifyArtistId($spotifyArtistId)
    {

        $artist = Artist::where('spotify_artist_id', $spotifyArtistId)->first();

        if (!$artist){
            return response()->json(null, 404);
        }


        $threads = Thread::where('artist_id', $artist->artist_id)->get();

        return response()->json($threads);
    }
}
