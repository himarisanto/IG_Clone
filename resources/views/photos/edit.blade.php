@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="photo">Upload New Photo</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <div class="form-group">
            <label for="caption">Caption</label>
            <textarea name="caption" id="caption" class="form-control">{{ $photo->caption }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection