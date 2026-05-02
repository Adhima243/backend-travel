<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $days = fake()->numberBetween(3, 6);
        $startDate = fake()->dateTimeBetween('+1 week', '+2 months');
        $endDate = (clone $startDate)->modify('+' . $days . ' days');

        return [
            'destination_id' => Destination::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name . '-' . fake()->unique()->randomNumber(3)),
            'description' => fake()->paragraphs(2, true),
            'duration_days' => $days,
            'duration_nights' => max(0, $days - 1),
            'price' => fake()->numberBetween(2500000, 9000000),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => fake()->numberBetween(10, 25),
            'available_slots' => fake()->numberBetween(5, 20),
            'rating' => fake()->randomFloat(1, 4.2, 5),
            'reviews_count' => fake()->numberBetween(20, 180),
            'hero_image' => fake()->imageUrl(1200, 800, 'travel', true),
            'gallery' => [
                fake()->imageUrl(1200, 800, 'travel', true),
                fake()->imageUrl(1200, 800, 'travel', true),
                fake()->imageUrl(1200, 800, 'travel', true),
            ],
            'includes' => ['Hotel', 'Guide lokal', 'Transport lokal'],
            'excludes' => ['Tiket pesawat', 'Asuransi perjalanan'],
            'itinerary' => [
                ['day' => 'Hari 1', 'title' => 'Arrival', 'detail' => fake()->sentence()],
                ['day' => 'Hari 2', 'title' => 'Explore', 'detail' => fake()->sentence()],
            ],
            'is_active' => true,
        ];
    }
}
