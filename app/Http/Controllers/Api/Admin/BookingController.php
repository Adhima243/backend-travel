<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['trip.destination', 'user']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('contact_name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate($request->integer('per_page', 10));

        return BookingResource::collection($bookings);
    }

    public function show(Booking $booking)
    {
        return new BookingResource($booking->load(['trip.destination', 'user']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'travel_date' => ['required', 'date'],
            'travelers' => ['required', 'integer', 'min:1'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled'],
        ]);

        $trip = Trip::findOrFail($data['trip_id']);
        $user = User::findOrFail($data['user_id']);

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'user_id' => $user->id,
            'travel_date' => $data['travel_date'],
            'travelers' => $data['travelers'],
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'total_price' => $trip->price * $data['travelers'],
        ]);

        return (new BookingResource($booking->load(['trip', 'user'])))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'travel_date' => ['nullable', 'date'],
            'travelers' => ['nullable', 'integer', 'min:1'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled'],
        ]);

        if (isset($data['travelers'])) {
            $data['total_price'] = $booking->trip->price * $data['travelers'];
        }

        $booking->update($data);

        return new BookingResource($booking->load(['trip.destination', 'user']));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'data' => [
                'message' => 'Booking deleted.',
            ],
        ]);
    }
}
