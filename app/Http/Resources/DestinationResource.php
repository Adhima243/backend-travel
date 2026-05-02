<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'location' => $this->location,
            'description' => $this->description,
            'hero_image' => $this->hero_image,
            'gallery' => $this->gallery,
            'starting_price' => $this->starting_price,
            'is_featured' => $this->is_featured,
            'created_at' => $this->created_at,
        ];
    }
}
