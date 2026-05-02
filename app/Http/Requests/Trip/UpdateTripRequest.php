<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tripId = $this->route('trip')?->id;

        return [
            'destination_id' => ['nullable', 'exists:destinations,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:trips,slug,' . $tripId],
            'description' => ['nullable', 'string'],
            'duration_days' => ['nullable', 'integer', 'min:1'],
            'duration_nights' => ['nullable', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'available_slots' => ['nullable', 'integer', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'reviews_count' => ['nullable', 'integer', 'min:0'],
            'hero_image' => ['nullable', 'string'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['string'],
            'includes' => ['nullable', 'array'],
            'includes.*' => ['string', 'max:255'],
            'excludes' => ['nullable', 'array'],
            'excludes.*' => ['string', 'max:255'],
            'itinerary' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
