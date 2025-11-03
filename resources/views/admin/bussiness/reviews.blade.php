<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Business Reviews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <style>
    .rating { color: #f4b400; font-size: 1.1rem; }
    .reply-box {
      background: #f8f9fa;
      border-left: 3px solid #198754;
      padding: 8px 12px;
      margin-top: 5px;
      font-size: 0.9rem;
      border-radius: 6px;
    }
    .review-comment {
      white-space: pre-line;
      word-break: break-word;
    }
    @media (max-width: 768px) {
      table { font-size: 0.9rem; }
      .reply-box { font-size: 0.8rem; }
    }
  </style>
</head>
<body>
<main id="main">
  <div class="d-aside-right-bar bg-grey">
    @include('components.sidebar')

    <div class="admin-content-right p-3">

      {{-- Alerts --}}
      @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      <h2 class="mb-4">All Reviews</h2>

      <div class="table-responsive shadow-sm">
        <table class="table align-middle table-bordered">
          <thead class="table-light">
            <tr>
              <th>Reviewer</th>
              <th>Rating</th>
              <th>Comment</th>
              <th>Replies</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($reviews as $review)
            <tr>
              <td><strong>{{ $review['reviewer']['displayName'] ?? 'N/A' }}</strong></td>

              <td class="rating">
                @php
                  $stars = match($review['starRating'] ?? null) {
                    'ONE' => 1, 'TWO' => 2, 'THREE' => 3, 'FOUR' => 4, 'FIVE' => 5, default => 0,
                  };
                @endphp
                {!! str_repeat('⭐', $stars) !!}
              </td>

              <td class="review-comment">{{ $review['comment'] ?? '-' }}</td>

              <td>
                {{-- Show replies (sometimes array or single) --}}
                @php
                    $replies = isset($review['reviewReply']) ? (is_array($review['reviewReply']) ? [$review['reviewReply']] : [$review['reviewReply']]) : [];
                @endphp

                @forelse($replies as $reply)
                  <div class="reply-box">
                    <strong>Reply:</strong> {{ $reply['comment'] ?? '—' }}<br>
                    <small class="text-muted">
                      {{ isset($reply['updateTime']) ? \Carbon\Carbon::parse($reply['updateTime'])->format('Y-m-d H:i') : '' }}
                    </small>
                  </div>
                @empty
                  <span class="text-muted">No reply yet.</span>
                @endforelse
              </td>

              <td>
                {{ isset($review['createTime']) ? \Carbon\Carbon::parse($review['createTime'])->format('Y-m-d') : '-' }}
              </td>

              <td>
                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#replyModal{{ $loop->index }}">
                  Reply
                </button>
              </td>
            </tr>

            {{-- Reply Modal --}}
            <div class="modal fade" id="replyModal{{ $loop->index }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $loop->index }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
<form action="{{ route('reviews.reply', ['business' => $business->id, 'review' => $review['reviewId']]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="replyModalLabel{{ $loop->index }}">Reply to {{ $review['reviewer']['displayName'] ?? 'Reviewer' }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <textarea name="comment" class="form-control" rows="4" placeholder="Write your reply..." required></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-success">Send Reply</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            @empty
            <tr>
              <td colspan="6" class="text-center text-muted">No reviews found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
