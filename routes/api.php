<?php

use App\Http\Controllers\Api\BookableAvailabilityController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\BookingByReviewControlelr;
use App\Http\Controllers\Api\ReviewController;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('bookables', BookableController::class);
Route::get('bookables/{bookable}/availability', BookableAvailabilityController::class)->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews', BookableReviewController::class)->name('bookables.reviews.index');
Route::get('/booking-by-review/{reviewKey}', BookingByReviewControlelr::class)->name('booking.by.review.show');

Route::apiResource('reviews', ReviewController::class)->only(['show', 'store']);
