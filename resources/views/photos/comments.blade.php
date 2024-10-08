<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
        }

        .comment-box {
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 1rem;
            background-color: #ffffff;
            display: flex;
            align-items: flex-start;
        }

        .comment-box:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .comment-author {
            font-weight: bold;
        }

        .comment-time {
            color: #a9a9a9;
            font-size: 0.85rem;
        }

        .comment-text {
            margin-top: 0.25rem;
            line-height: 1.5;
        }

        .add-comment-form {
            border-top: 1px solid #e6e6e6;
            padding-top: 1rem;
        }

        .like-button {
            cursor: pointer;
            margin-left: auto;
            border: none;
            background: none;
            font-size: 1.5rem;
        }

        .liked {
            color: red;
        }

        .not-liked {
            color: #ccc;
            /* Change this to your desired color for not liked */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Comments Section -->
        <h3 class="mb-4">Comments</h3>
        @if($photo->comments->isEmpty())
        <div class="alert alert-info" role="alert">
            No comments yet. Be the first to comment!
        </div>
        @else
        @foreach($photo->comments as $comment)
        <div class="comment-box mb-3">
            <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="{{ $comment->user->name }}" class="profile-img">
            <div class="flex-grow-1">
                <span class="comment-author">{{ $comment->user->name }}</span>
                <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                <p class="comment-text">{{ $comment->comment }}</p>
            </div>
            <form action="{{ route('comments.like', $comment) }}" method="POST" class="like-button">
                @csrf
                <button type="submit" class="like-button {{ $comment->isLikedByUser(auth()->user()) ? 'liked' : 'not-liked' }}">
                    ❤️ {{ $comment->likes_count }}
                </button>
            </form>
        </div>
        @endforeach
        @endif

        <!-- Add New Comment Form -->
        <div class="add-comment-form">
            <form action="{{ route('comments.store', $photo) }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="comment" class="form-control" placeholder="Write a comment..." required>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>