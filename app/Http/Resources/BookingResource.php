<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'trip_id' => $this->trip_id,
            'user_id' => $this->user_id,
            'trip' => new TripResource($this->whenLoaded('trip')),
            'user' => new UserResource($this->whenLoaded('user')),
            'travel_date' => $this->travel_date,
            'travelers' => $this->travelers,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'notes' => $this->notes,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
        ];
    }
}
