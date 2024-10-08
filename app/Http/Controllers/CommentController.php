<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show($photoId)
    {
        $photo = Photo::with(['comments.likes'])->findOrFail($photoId);
        return view('comments.show', compact('photo'));
    }

    public function store(Request $request, Photo $photo)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $photo->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

    public function like(Comment $comment)
    {
        if (!$comment->isLikedByUser(auth()->user())) {
            $comment->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
        } else {
            $comment->likes()->where('user_id', auth()->user()->id)->delete();
        }

        return redirect()->back();
    }
}
