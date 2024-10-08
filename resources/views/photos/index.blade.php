@extends('layouts.app')

@section('title', 'Halaman Foto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('photos.create') }}" class="btn btn-success mb-3">Tambah Foto</a>

            <!-- Search form -->
            <form action="{{ request()->url() }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Search photos or users" class="form-control" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Photo Cards -->
            @foreach($photos as $photo)
            <div class="card card-custom mb-4">
                <div class="card-header card-header-custom">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $photo->user->profile_photo) }}" alt="Profile" class="rounded-circle" style="width: 50px; height: 50px;">
                        <div class="ms-3">
                            <strong>{{ $photo->user->name }}</strong><br>
                            <span class="text-muted small">{{ $photo->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Photo" class="img-fluid card-body-image">
                </div>

                <div class="card-body card-body-custom">
                    <div class="d-flex align-items-center mb-3">
                        <!-- Like Button -->
                        <button class="btn btn-light btn-sm d-flex align-items-center" id="like-button-{{ $photo->id }}" onclick="toggleLike({{ $photo->id }}, {{ $photo->likes->contains('user_id', Auth::id()) ? 'true' : 'false' }})">
                            <i class="{{ $photo->likes->contains('user_id', Auth::id()) ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                            <span class="ms-2">{{ $photo->likes->count() }}</span>
                        </button>
                        <!-- Comment Button -->
                        <a href="javascript:void(0)" class="btn btn-light btn-sm d-flex align-items-center ms-3" onclick="goToComments({{ $photo->id }})">
                            <i class="bi bi-chat"></i>
                        </a>
                    </div>
                    <p class="card-text">{{ $photo->caption }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function goToComments(photoId) {
        window.location.href = `/photos/${photoId}/comments`;
    }

    function toggleLike(photoId, isLiked) {
        var button = document.getElementById('like-button-' + photoId);
        var heartIcon = button.querySelector('i');
        var likeCount = button.querySelector('span');
        var currentCount = parseInt(likeCount.textContent);

        fetch(`{{ route('likes.toggle', '') }}/${photoId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'liked') {
                    heartIcon.classList.remove('bi-heart');
                    heartIcon.classList.add('bi-heart-fill');
                    likeCount.textContent = currentCount + 1;
                } else {
                    heartIcon.classList.remove('bi-heart-fill');
                    heartIcon.classList.add('bi-heart');
                    likeCount.textContent = currentCount - 1;
                }
            });
    }
</script>
@endsection