@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- // Tombol tambah foto -->
            <a href="{{ route('photos.create') }}" class="btn btn-success mb-3">Tambah Foto</a>

            <!-- // cari -->
            <form action="{{ request()->url() }}" method="GET" class="mb-3">
                <input type="text" name="search" placeholder="Search photos or users" class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary mt-2">Search</button>
            </form>

            @foreach($photos as $photo)
            <div class="card mb-3 shadow" style="border: none; border-radius: 15px; overflow: hidden;">
                <!-- // Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center bg-white" style="padding: 10px;">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $photo->user->profile_photo) }}" alt="Profile" class="rounded-circle" style="width: 50px; height: 50px;">
                        <div class="ml-3">
                            <strong class="font-weight-bold" style="font-size: 1.2em;">{{ $photo->user->name }}</strong><br>
                            <span class="text-muted small">{{ $photo->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- // card bodynya foto -->
                <div class="card-body p-0">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Photo" class="img-fluid" style="max-height: 500px; object-fit: cover; width: 100%;">
                </div>

                <!-- // deskripsi dan like -->
                <div class="card-body" style="padding: 15px;">
                    <div class="d-flex align-items-center mb-2">
                        <!-- // tombol suka -->
                        <button type="button" class="btn btn-light btn-sm d-flex align-items-center" id="like-button-{{ $photo->id }}" onclick="toggleLike({{ $photo->id }}, {{ $photo->likes->contains('user_id', Auth::id()) ? 'true' : 'false' }})">
                            <i class="{{ $photo->likes->contains('user_id', Auth::id()) ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                            <span class="ml-2 text-muted"><strong>{{ $photo->likes->count() }}</strong></span>
                        </button>
                        <!-- // tombol komentar -->
                        <a href="javascript:void(0)" class="btn btn-light btn-sm d-flex align-items-center ml-3" onclick="goToComments({{ $photo->id }})">
                            <i class="bi bi-chat"></i>
                        </a>
                    </div>

                    <p class="card-text mb-2" style="font-size: 1em;">{{ $photo->caption }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- User Profile Section (Jika diperlukan) -->

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
        var likeCount = button.parentElement.parentElement.querySelector('strong');
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection