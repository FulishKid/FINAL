<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteArtistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post("register", [UserController::class, "register"]);


Route::post("reset-password", [UserController::class, "resetPassword"]);


Route::post("login", [UserController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function(){

    Route::get("refresh", [UserController::class, "refreshToken"]);

    Route::get('user', [UserController::class, 'show']);

    Route::get("profile", [UserController::class, "profile"]);

    Route::get("logout", [UserController::class, "logout"]);


    Route::get('threads', [ThreadController::class, 'index']);

    Route::post('threads', [ThreadController::class, 'store']);
    Route::get('threads/{thread}', [ThreadController::class, 'show']);
    Route::put('threads/{thread}', [ThreadController::class, 'update']);
    Route::delete('threads/{thread}', [ThreadController::class, 'destroy']);
    Route::get('threads/{threadId}/rating', [VoteController::class, 'getThreadRating']);

    Route::post('threads/{threadId}/votes', [VoteController::class, 'store']);
    Route::delete('votes/{voteId}', [VoteController::class, 'destroy']);
    Route::get('threads/{threadId}/rating', [VoteController::class, 'getThreadRating']);

    Route::get('comments/{comment}', [CommentController::class, 'show']);
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::get('profile/rating', [ProfileController::class, 'getRating']);

    Route::get('artists', [ArtistController::class, 'index']);
    Route::get('artists/{artist}', [ArtistController::class, 'show']);
    Route::post('artists', [ArtistController::class, 'store']);
    Route::put('artists/{artist}', [ArtistController::class, 'update']);
    Route::delete('artists/{artist}', [ArtistController::class, 'destroy']);

    Route::get('favorites/artists', [FavoriteArtistController::class, 'index']);
    Route::post('favorites/artists', [FavoriteArtistController::class, 'store']);
    Route::delete('favorites/artists/{artist}', [FavoriteArtistController::class, 'destroy']);

    Route::get('threads/artist/{spotifyArtistId}', [ThreadController::class, 'getThreadsBySpotifyArtistId']);


});

