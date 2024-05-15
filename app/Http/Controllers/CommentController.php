<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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
class CommentController extends Controller
{

    use ValidatesRequests, AuthorizesRequests;

    public function index($threadId)
    {
        $comments = Comment::where('thread_id', $threadId)->get();
        return response()->json($comments);
    }

    public function store(Request $request, $threadId)
    {
        $this->validate($request, [
            'content_' => 'required|string',
        ]);

        $thread = Thread::findOrFail($threadId);

        $comment = Comment::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'content' => $request->content_,
        ]);

        return response()->json($comment, 201);
    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content_' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);

        $comment->update($request->only(['content_']));
        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);

        $comment->delete();
        return response()->json(null, 204);
    }
}
