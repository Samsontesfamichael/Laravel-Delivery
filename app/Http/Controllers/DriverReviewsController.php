<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get driver reviews with filters
     */
    public function getDriverReviews(Request $request)
    {
        $driverId = $request->input('driver_id');
        $rating = $request->input('rating');
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        $database = app('firebase.firestore')->database();
        $reviewsRef = $database->collection('driver_reviews')->where('driverID', '==', $driverId);

        if ($rating) {
            $reviewsRef->where('rating', '==', intval($rating));
        }

        $reviewsRef->orderBy('createdAt', 'desc');
        
        $reviews = [];
        $querySnapshot = $reviewsRef->offset($offset)->limit($limit)->documents();
        
        foreach ($querySnapshot as $doc) {
            if ($doc->exists()) {
                $review = $doc->data();
                $reviews[] = [
                    'id' => $doc->id(),
                    'customerName' => $review['customerName'],
                    'rating' => $review['rating'],
                    'reviewText' => $review['reviewText'] ?? '',
                    'createdAt' => $review['createdAt'],
                    'orderId' => $review['orderId'] ?? null
                ];
            }
        }

        $totalReviews = $reviewsRef->count();

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'total' => $totalReviews,
            'limit' => $limit,
            'offset' => $offset
        ]);
    }

    /**
     * Get review details
     */
    public function getReviewDetail($reviewId)
    {
        $database = app('firebase.firestore')->database();
        $reviewRef = $database->collection('driver_reviews')->document($reviewId);
        $review = $reviewRef->snapshot()->data();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'review' => $review
        ]);
    }

    /**
     * Delete review
     */
    public function deleteReview($reviewId)
    {
        $database = app('firebase.firestore')->database();
        $reviewRef = $database->collection('driver_reviews')->document($reviewId);
        
        if (!$reviewRef->snapshot()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $reviewRef->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Get driver rating statistics
     */
    public function getRatingStats($driverId)
    {
        $database = app('firebase.firestore')->database();
        $reviewsRef = $database->collection('driver_reviews')->where('driverID', '==', $driverId);

        $totalReviews = 0;
        $totalRating = 0;
        $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($reviewsRef->documents() as $doc) {
            if ($doc->exists()) {
                $review = $doc->data();
                $rating = intval($review['rating']);
                
                $totalReviews++;
                $totalRating += $rating;
                $ratingCounts[$rating]++;
            }
        }

        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;

        // Calculate percentages
        $ratingPercentages = [];
        foreach ($ratingCounts as $rating => $count) {
            $ratingPercentages[$rating] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }

        return response()->json([
            'success' => true,
            'stats' => [
                'averageRating' => round($averageRating, 1),
                'totalReviews' => $totalReviews,
                'ratingCounts' => $ratingCounts,
                'ratingPercentages' => $ratingPercentages
            ]
        ]);
    }

    /**
     * Get monthly review statistics
     */
    public function getMonthlyStats($driverId)
    {
        $database = app('firebase.firestore')->database();
        $reviewsRef = $database->collection('driver_reviews')->where('driverID', '==', $driverId);

        $monthlyStats = [];
        $currentYear = date('Y');

        for ($month = 1; $month <= 12; $month++) {
            $startDate = new \DateTime("$currentYear-$month-01");
            $endDate = clone $startDate;
            $endDate->modify('last day of this month')->setTime(23, 59, 59);

            $monthlyReviews = $reviewsRef->where('createdAt', '>=', $startDate)
                ->where('createdAt', '<=', $endDate)
                ->count();

            $monthlyStats[] = [
                'month' => $month,
                'year' => $currentYear,
                'reviews' => $monthlyReviews
            ];
        }

        return response()->json([
            'success' => true,
            'monthlyStats' => $monthlyStats
        ]);
    }

    /**
     * Reply to review
     */
    public function replyToReview(Request $request)
    {
        $reviewId = $request->input('review_id');
        $reply = $request->input('reply');
        $adminId = auth()->id();

        $database = app('firebase.firestore')->database();
        $reviewRef = $database->collection('driver_reviews')->document($reviewId);
        
        if (!$reviewRef->snapshot()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $reviewRef->update([
            'reply' => $reply,
            'repliedBy' => $adminId,
            'repliedAt' => app('firebase.firestore')->database()->timestamp()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply added successfully'
        ]);
    }
}
