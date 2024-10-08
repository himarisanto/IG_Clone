@extends('layouts.app')

@section('content')
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Logo</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @foreach($photos as $photo)
            <div class="card mb-3">
                <img src="{{ asset($photo->url) }}" class="card-img-top" alt="{{ $photo->caption }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $photo->caption }}</h5>
                    <p class="card-text">Likes: {{ $photo->likes_count }}</p>
                    <form action="{{ route('photos.like', $photo->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary" type="submit">Like</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Your Profile') }}</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">Uploaded Photos: {{ $user->photos_count }}</p>
                    <a href="{{ route('photos.create') }}" class="btn btn-primary">Upload New Photo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection