<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('trip')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate($request->integer('per_page', 10));

        return BookingResource::collection($bookings);
    }

    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized.');
        }

        return new BookingResource($booking->load('trip'));
    }

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $trip = Trip::findOrFail($data['trip_id']);

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'user_id' => $request->user()->id,
            'travel_date' => $data['travel_date'],
            'travelers' => $data['travelers'],
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
            'total_price' => $trip->price * $data['travelers'],
        ]);

        $booking->load(['trip', 'user']);

        try {
            Mail::to('cahyoashofar@gmail.com')->send(new BookingCreated($booking));
        } catch (\Throwable $exception) {
            Log::warning('Booking created but email notification failed.', [
                'booking_id' => $booking->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }
}
