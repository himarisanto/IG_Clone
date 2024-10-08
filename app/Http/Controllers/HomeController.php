<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
{
    $photos = Photo::all(); // Assuming you're fetching photos from a model named Photo
    return view('dashboard', compact('photos'));
}
    public function index()
    {
        $user = auth()->user();
        $photos = Photo::withCount('likes')->latest()->get();

        return view('home', compact('user', 'photos'));
    }
}
