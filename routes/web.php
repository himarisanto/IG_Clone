<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/photos', function () {
    return view('index');
})->middleware(['auth'])->name('');

require __DIR__ . '/auth.php';


Route::middleware('auth')->group(function () {
    Route::resource('photos', PhotoController::class);
    Route::post('photos/{photo}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('photos/{photo}/like', [LikeController::class, 'destroy'])->name('likes.destroy');
    Route::post('photos/{photo}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::post('photos/{photo}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/likes/toggle/{photo}', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::get('/photos/{photo}/comments', [PhotoController::class, 'showComments'])->name('photos.comments');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

    Route::post('/likes/toggle/{photoId}', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::get('/search', [PhotoController::class, 'search'])->name('search');
    Route::post('/photos/{photo}/like', [PhotoController::class, 'like'])->name('photos.like');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


Auth::routes();
