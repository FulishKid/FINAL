<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Artist;
use Illuminate\Http\Request;
/**
 * @mixin  AuthorizesRequests
 * @mixin  ValidatesRequests
 *
 */
class ArtistController extends Controller
{
    use ValidatesRequests, AuthorizesRequests;
    public function index()
    {
        $artists = Artist::all();
        return response()->json($artists);
    }

    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        return response()->json($artist);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'spotify_artist_id' => 'required|string|unique:artists,spotify_artist_id',
            'name' => 'required|string|max:255',
        ]);

        $artist = Artist::create($request->only(['spotify_artist_id', 'name']));
        return response()->json($artist, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'sometimes|required|string|max:255',
        ]);

        $artist = Artist::findOrFail($id);
        $artist->update($request->only(['name']));
        return response()->json($artist);
    }

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return response()->json(null, 204);
    }
}
