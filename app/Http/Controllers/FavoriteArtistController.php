<?php

namespace App\Http\Controllers;


use App\Models\FavoriteArtist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * @mixin  AuthorizesRequests
 * @mixin  ValidatesRequests
 *
 */


class FavoriteArtistController extends Controller
{

    use ValidatesRequests, AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $favorites = FavoriteArtist::where('user_id', $user->id)->with('artist')->get();
        return response()->json($favorites);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'artist_id' => 'required|integer|exists:artists,id',
        ]);

        $user = Auth::user();
        $favorite = FavoriteArtist::create([
            'user_id' => $user->id,
            'artist_id' => $request->artist_id,
        ]);

        return response()->json($favorite, 201);
    }

    public function destroy($artistId)
    {
        $user = Auth::user();
        $favorite = FavoriteArtist::where('user_id', $user->id)
            ->where('artist_id', $artistId)
            ->firstOrFail();

        $favorite->delete();
        return response()->json(null, 204);
    }
}
