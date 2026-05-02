<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title . '-' . fake()->unique()->randomNumber(3)),
            'excerpt' => fake()->sentence(12),
            'content' => fake()->paragraphs(4, true),
            'cover_image' => fake()->imageUrl(1200, 800, 'travel', true),
            'author_name' => fake()->name(),
            'published_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ];
    }
}
