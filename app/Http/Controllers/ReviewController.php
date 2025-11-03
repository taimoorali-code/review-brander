<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Review;
use App\Services\GoogleReviewService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{



public function index($businessId)
{
    try {
        $business = Business::findOrFail($businessId);
        $platform = $business->platforms()->where('name', 'Google Business')->first();

        if (!$platform || !$platform->credentials) {
            return back()->with('error', 'Google Business not connected yet.');
        }

        $service = new GoogleReviewService(
            $platform->credentials,
            config('services.google.gbp_account_id'),
            config('services.google.gbp_location_id')
        );

        // ✅ listReviews() already returns decoded array
        $reviewsData = $service->listReviews();

        if (isset($reviewsData['error'])) {
            return back()->with('error', 'Google API Error: ' . json_encode($reviewsData['error']));
        }

        // ✅ Save or update reviews
        if (!empty($reviewsData['reviews']) && is_array($reviewsData['reviews'])) {
            foreach ($reviewsData['reviews'] as $review) {
                Review::updateOrCreate(
                    ['review_id' => $review['reviewId']],
                    [
                        'business_id'   => $business->id,
                        'reviewer_name' => $review['reviewer']['displayName'] ?? null,
                        'comment'       => $review['comment'] ?? null,
                        'star_rating'   => match ($review['starRating'] ?? null) {
                            'ONE' => 1,
                            'TWO' => 2,
                            'THREE' => 3,
                            'FOUR' => 4,
                            'FIVE' => 5,
                            default => null,
                        },
                        'create_time'   => isset($review['createTime']) ? Carbon::parse($review['createTime']) : null,
                        'update_time'   => isset($review['updateTime']) ? Carbon::parse($review['updateTime']) : null,
                        'raw_data'      => json_encode($review),
                    ]
                );
            }
        }

        return view('admin.bussiness.reviews', [
            'business' => $business,
            'reviews'  => $reviewsData['reviews'] ?? [],
            'averageRating' => $reviewsData['averageRating'] ?? null,
            'totalReviewCount' => $reviewsData['totalReviewCount'] ?? null,
        ])->with('success', 'Reviews fetched and saved successfully!');

    } catch (\Throwable $e) {
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}




  public function reply(Request $request, $businessId, $reviewId)
{
    $request->validate([
        'comment' => 'required|string|max:2000',
    ]);

    $business = Business::findOrFail($businessId);
    $platform = $business->platforms()->where('name', 'Google Business')->first();

    if (!$platform || !$platform->credentials) {
        return back()->with('error', 'Google Business not connected yet.');
    }

    $service = new GoogleReviewService(
        $platform->credentials,
        config('services.google.gbp_account_id'),
        config('services.google.gbp_location_id')
    );

    $response = $service->replyToReview($reviewId, $request->comment);

    if (isset($response['error'])) {
        return back()->with('error', 'Failed to reply: ' . json_encode($response['error']));
    }

    return back()->with('success', 'Reply posted successfully!');
}


}
