<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Business Reviews</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <style>
    .rating {
      color: #f4b400;
      font-size: 1.1rem;
    }

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

    .reply-count {
      cursor: pointer;
      color: #0d6efd;
      text-decoration: underline;
    }

    .reply-btn {
      font-size: 0.85rem;
      padding: 4px 10px;
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

        <h2 class="box-heading mt-3 mb-3">All Reviews</h2>

        <div class="transaction-table shadow-sm table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Business</th>
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
              @php
              $replies = isset($review['reviewReply'])
              ? (is_array($review['reviewReply']) ? [$review['reviewReply']] : [$review['reviewReply']])
              : [];
              $replyCount = count($replies);
              $stars = match($review['starRating'] ?? null) {
              'ONE' => 1, 'TWO' => 2, 'THREE' => 3, 'FOUR' => 4, 'FIVE' => 5, default => 0,
              };
              @endphp

              <tr>
                <td><strong>{{ $review['business_name'] }}</strong></td>
                <td><strong>{{ $review['reviewer']['displayName'] ?? 'N/A' }}</strong></td>
                <td class="rating">{!! str_repeat('⭐', $stars) !!}</td>
                <td class="review-comment">{{ $review['comment'] ?? '-' }}</td>

                <td>
                  @if($replyCount > 0)
                  <a href="{{ route('reviews.replies.view', ['business' =>  $review['business_id'], 'reviewId' => $review['reviewId']]) }}"
                    class="text-decoration-none fw-semibold text-success">
                    {{ $replyCount }} {{ Str::plural('Reply', $replyCount) }}
                  </a>

                  @else
                  <span class="text-muted">No reply yet</span>
                  @endif
                </td>

                <td>{{ isset($review['createTime']) ? \Carbon\Carbon::parse($review['createTime'])->format('Y-m-d') : '-' }}</td>

                <td>
                  <button class="btn btn-sm btn-success reply-btn"
                    data-review-id="{{ $review['reviewId'] }}"
                    data-reviewer="{{ $review['reviewer']['displayName'] ?? 'N/A' }}"
                    data-bs-toggle="modal"
                    data-bs-target="#replyModal">
                    Reply
                  </button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted">No reviews found.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  {{-- 💬 Reply Modal --}}
  <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" id="replyForm">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="replyModalLabel">Reply to Review</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="reviewerName" class="form-label">Reviewer</label>
              <input type="text" id="reviewerName" class="form-control" readonly>
            </div>
            <div class="mb-3">
              <label for="replyComment" class="form-label">Your Reply</label>
              <textarea name="comment" id="replyComment" class="form-control" rows="4" placeholder="Write your reply..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Send Reply</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget;
      const reviewId = button.getAttribute('data-review-id');
      const reviewerName = button.getAttribute('data-reviewer');

      // Fill modal fields
      document.getElementById('reviewerName').value = reviewerName;

      // Set the form action dynamically
      const form = document.getElementById('replyForm');
      form.action = "{{ route('reviews.reply', ['business' =>  $review['business_id'], 'review' => 'REVIEW_ID']) }}".replace('REVIEW_ID', reviewId);
    });
  </script>
</body>

</html>