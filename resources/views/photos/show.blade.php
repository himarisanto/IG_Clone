@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="card-img-top" alt="Photo">

        <div class="card-body">
            <p>{{ $photo->caption }}</p>
            <p>{{ $photo->likes->count() }} likes</p>

            <form action="{{ route('likes.store', $photo) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">Like</button>
            </form>

            <form action="{{ route('comments.store', $photo) }}" method="POST" class="mt-2">
                @csrf
                <div class="input-group">
                    <input type="text" name="comment" class="form-control" placeholder="Add a comment">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection