<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $like = Like::where('photo_id', $photoId)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            // hapus suka
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            // buat suka baru
            Like::create([
                'user_id' => Auth::id(),
                'photo_id' => $photoId,
            ]);
            return response()->json(['status' => 'liked']);
        }
    }
}
