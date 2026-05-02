<?php

namespace App\Http\Requests\Destination;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $destinationId = $this->route('destination')?->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:destinations,slug,' . $destinationId],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['string'],
            'starting_price' => ['nullable', 'numeric', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
