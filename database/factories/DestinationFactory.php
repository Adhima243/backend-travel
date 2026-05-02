<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    protected $model = Destination::class;

    public function definition(): array
    {
        $name = fake()->unique()->city();

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->randomNumber(3)),
            'location' => fake()->country(),
            'description' => fake()->paragraph(),
            'hero_image' => fake()->imageUrl(1200, 800, 'travel', true),
            'gallery' => [
                fake()->imageUrl(1200, 800, 'travel', true),
                fake()->imageUrl(1200, 800, 'travel', true),
            ],
            'starting_price' => fake()->numberBetween(1500000, 7000000),
            'is_featured' => fake()->boolean(30),
        ];
    }
}
