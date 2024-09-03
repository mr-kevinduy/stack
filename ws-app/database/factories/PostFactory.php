<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'title' => fake()->realText(50),
            'title' => ucfirst(fake()->sentence()),
            'description' => null,
            'content' => fake()->paragraphs(rand(2, 6), true),
        ];
    }
}
