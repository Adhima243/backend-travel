<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Trip;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query()->with('user');

        if ($tripId = $request->query('trip_id')) {
            $query->where('trip_id', $tripId);
        }

        $reviews = $query->latest()->paginate($request->integer('per_page', 10));

        return ReviewResource::collection($reviews);
    }

    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();

        $review = Review::create([
            'trip_id' => $data['trip_id'],
            'user_id' => $request->user()->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        $trip = Trip::findOrFail($data['trip_id']);
        $average = round($trip->reviews()->avg('rating'), 1);
        $count = $trip->reviews()->count();

        $trip->update([
            'rating' => $average,
            'reviews_count' => $count,
        ]);

        return (new ReviewResource($review->load('user')))
            ->response()
            ->setStatusCode(201);
    }
}
