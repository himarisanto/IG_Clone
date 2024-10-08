<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class PhotoController extends Controller
{

    public function index(Request $request)
    {
        // Query untuk foto
        $query = Photo::with('user', 'likes', 'comments')->latest();

        // Cek apakah ada parameter search
        if ($request->has('search')) {
            $search = $request->get('search');

            // Cari berdasarkan caption atau nama user
            $query->where('caption', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        // Paginate hasil pencarian atau semua foto
        $photos = $query->withCount('likes')->paginate(10);

        // Dapatkan pengguna yang saat ini diautentikasi
        $user = auth()->user();

        // Return view dengan data foto dan user
        return view('photos.index', compact('photos', 'user'));
    }



    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', 
            'caption' => 'nullable|string|max:255',
        ]);

        try {
            $path = $request->file('photo')->store('photos', 'public'); 

            
            \Log::info('Photo Path: ' . $path);

            Photo::create([
                'user_id' => auth()->id(),
                'photo_path' => $path,
                'caption' => $request->caption,
            ]);

            return redirect()->route('photos.index')->with('success', 'Photo uploaded successfully!');
        } catch (\Exception $e) {
            \Log::error('Upload Error: ' . $e->getMessage());
            return redirect()->route('photos.create')->with('error', 'An error occurred while uploading the photo.');
        }
    }



    // public function edit(Photo $photo)
    // {
    //     $this->authorize('update', $photo);
    //     return view('photos.edit', compact('photo'));
    // }

    // public function update(Request $request, Photo $photo)
    // {
    //     $this->authorize('update', $photo);

    //     $request->validate([
    //         'caption' => 'nullable|string|max:255',
    //     ]);

    //     if ($request->hasFile('photo')) {
    //         Storage::delete($photo->photo_path);
    //         $path = $request->file('photo')->store('photos', 'public');
    //         $photo->photo_path = $path;
    //     }

    //     $photo->caption = $request->caption;
    //     $photo->save();

    //     return redirect()->route('photos.index')->with('success', 'Photo updated successfully!');
    // }

    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo'));
    }

    // public function destroy(Photo $photo)
    // {
    //     $this->authorize('delete', $photo);

    //     Storage::delete($photo->photo_path);
    //     $photo->delete();

    //     return redirect()->route('photos.index')->with('success', 'Photo deleted successfully!');
    // }
    public function showComments($id)
    {
       //ambil foto sesuai ai dan komen user
        $photo = Photo::with('comments.user')->findOrFail($id);
        return view('photos.comments', compact('photo'));
    }
    public function like($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $user = auth()->user();

        // Toggle like
        $like = $photo->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete(); //hapus like
        } else {
            $photo->likes()->create(['user_id' => $user->id]); 
        }

        return redirect()->back()->with('success', 'Photo liked/unliked successfully!');
    }
}
