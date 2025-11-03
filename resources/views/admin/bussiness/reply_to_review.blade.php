<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Google Reviews</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <h2>Google Reviews for {{ $business->name }}</h2>
   @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
  @foreach($reviews as $review)
    <div class="card mb-3">
      <div class="card-body">
        <strong>{{ $review->reviewer_name ?? 'Anonymous' }}</strong>
        <span>⭐ {{ $review->star_rating }}</span>
        <p>{{ $review->comment }}</p>

        <form action="{{ route('reviews.reply', [$business->id, $review->review_id]) }}" method="POST">
          @csrf
          <div class="input-group">
            <input type="text" name="comment" class="form-control" placeholder="Write a reply..." required>
            <button class="btn btn-primary">Reply</button>
          </div>
        </form>
      </div>
    </div>
  @endforeach
</body>
</html>
