<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function summary()
    {
        $onlineUsers = User::whereHas('tokens', function ($query) {
            $query->where('last_used_at', '>=', Carbon::now()->subMinutes(15));
        })->count();

        $recentBookings = Booking::with(['trip.destination', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'data' => [
                'counts' => [
                    'users' => User::count(),
                    'bookings' => Booking::count(),
                    'trips' => Trip::count(),
                    'destinations' => Destination::count(),
                    'blog_posts' => BlogPost::count(),
                    'faqs' => Faq::count(),
                    'reviews' => Review::count(),
                    'contacts' => Contact::count(),
                ],
                'online_users' => $onlineUsers,
                'pending_bookings' => Booking::where('status', 'pending')->count(),
                'recent_bookings' => BookingResource::collection($recentBookings),
            ],
        ]);
    }
}
