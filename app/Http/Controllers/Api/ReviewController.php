<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(ReviewStoreRequest $request)
    {
        $booking = Booking::findByReviewKey($request->id);

        if (null === $booking) {
            return abort(404);
        }

        $booking->review_key = '';
        $booking->save();

        $review = Review::make($request->all());
        $review->bookable_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }
}
