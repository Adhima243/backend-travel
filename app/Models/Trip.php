<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'name',
        'slug',
        'description',
        'duration_days',
        'duration_nights',
        'price',
        'start_date',
        'end_date',
        'capacity',
        'available_slots',
        'rating',
        'reviews_count',
        'hero_image',
        'gallery',
        'includes',
        'excludes',
        'itinerary',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'gallery' => 'array',
        'includes' => 'array',
        'excludes' => 'array',
        'itinerary' => 'array',
        'is_active' => 'boolean',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
