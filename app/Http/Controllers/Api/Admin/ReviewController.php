<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query()->with(['user']);

        if ($tripId = $request->query('trip_id')) {
            $query->where('trip_id', $tripId);
        }

        $reviews = $query->latest()->paginate($request->integer('per_page', 10));

        return ReviewResource::collection($reviews);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review = Review::create([
            'trip_id' => $data['trip_id'],
            'user_id' => $data['user_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        $this->refreshTripRating($data['trip_id']);

        return (new ReviewResource($review->load('user')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review->update($data);

        $this->refreshTripRating($review->trip_id);

        return new ReviewResource($review->load('user'));
    }

    public function destroy(Review $review)
    {
        $tripId = $review->trip_id;
        $review->delete();

        $this->refreshTripRating($tripId);

        return response()->json([
            'data' => [
                'message' => 'Review deleted.',
            ],
        ]);
    }

    private function refreshTripRating(int $tripId): void
    {
        $trip = Trip::find($tripId);
        if (!$trip) {
            return;
        }

        $average = round($trip->reviews()->avg('rating') ?? 0, 1);
        $count = $trip->reviews()->count();

        $trip->update([
            'rating' => $average,
            'reviews_count' => $count,
        ]);
    }
}
