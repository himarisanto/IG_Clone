@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Upload Photo Input -->
        <div class="form-group">
            <label for="photo">Upload Photo</label>
            <input type="file" name="photo" id="photo" class="form-control" required onchange="previewImage(event)">
        </div>

        <!-- Image Preview -->
        <div class="form-group">
            <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; height: auto; display: none; margin-top: 15px;" />
        </div>

        <!-- Caption Input -->
        <div class="form-group">
            <label for="caption">Caption</label>
            <textarea name="caption" id="caption" class="form-control" placeholder="Write a caption..." rows="3"></textarea>
        </div>

        <!-- Post Button -->
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>

<script>
    // JavaScript function to preview the image before uploading
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById("imagePreview");

        reader.onload = function() {
            if (reader.readyState == 2) {
                imageField.src = reader.result;
                imageField.style.display = "block"; // Show the image preview
            }
        }

        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection