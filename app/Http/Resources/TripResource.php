<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'destination_id' => $this->destination_id,
            'destination' => new DestinationResource($this->whenLoaded('destination')),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'duration_days' => $this->duration_days,
            'duration_nights' => $this->duration_nights,
            'price' => $this->price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'capacity' => $this->capacity,
            'available_slots' => $this->available_slots,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'hero_image' => $this->hero_image,
            'gallery' => $this->gallery,
            'includes' => $this->includes,
            'excludes' => $this->excludes,
            'itinerary' => $this->itinerary,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}
