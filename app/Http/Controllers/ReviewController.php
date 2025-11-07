<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Platform;
use App\Models\Review;
use App\Services\GoogleReviewService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{

// public function getAllSavedReviews()
// {
//     try {
//         // Get all reviews with related business info
//         $reviews = Review::with('business')  // assuming relation defined: Review belongsTo Business
//             ->orderBy('create_time', 'desc')
//             ->get();

//         // Calculate overall stats
//         $averageRating = $reviews->avg('star_rating');
//         $totalReviewCount = $reviews->count();

//         // Get distinct businesses for filter/display
//         $businesses = Business::whereIn('id', $reviews->pluck('business_id')->unique())->get();

//         return view('admin.bussiness.reviews', [
//             'businesses' => $businesses,
//             'reviews'  => $reviewsData['reviews'] ?? [],
//             'averageRating' => $reviewsData['averageRating'] ?? null,
//             'totalReviewCount' => $reviewsData['totalReviewCount'] ?? null,
//         ])->with('success', 'Reviews fetched and saved successfully!');

//     } catch (\Throwable $e) {
//         return back()->with('error', 'Failed to load saved reviews: ' . $e->getMessage());
//     }
// }
public function getAllSavedReviews()
{
    try {
        // Get all reviews + related business (if exists)
        $reviews = Review::with('business')
            ->orderBy('create_time', 'desc')
            ->get();

        // Decode raw_data JSON for each review
        $decodedReviews = $reviews->map(function ($review) {
            $data = json_decode($review->raw_data, true) ?? [];
            $data['business_name'] = $review->business->name ?? 'Unknown';
            $data['business_id'] = $review->business->id ?? '1';

            return $data;
        });

        return view('admin.bussiness.reviews', [
            'reviews' => $decodedReviews,
        ]);

    } catch (\Throwable $e) {
        return back()->with('error', 'Failed to load saved reviews: ' . $e->getMessage());
    }
}



public function index($businessId , $platformId)
{
    try {
        $business = Business::findOrFail($businessId);
        $platform = Platform::findOrFail($platformId);

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

public function showReplies($businessId, $reviewId)
{
    // Get business and its review from DB
    $business = Business::findOrFail($businessId);

    $review = Review::where('business_id', $businessId)
        ->where('review_id', $reviewId)
        ->first();

    if (!$review) {
        return back()->with('error', 'Review not found in database.');
    }

    // Decode raw_data JSON to extract reply info
    $data = json_decode($review->raw_data, true);
    $replies = [];

    if (isset($data['reviewReply'])) {
        // API sometimes returns single object, sometimes array
        $replies = is_array($data['reviewReply']) && array_is_list($data['reviewReply'])
            ? $data['reviewReply']
            : [$data['reviewReply']];
    }

    return view('admin.bussiness.replyview', compact('business', 'review', 'replies'));
}


}


