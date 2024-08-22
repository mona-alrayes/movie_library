<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5), // Assuming rating is between 1 and 5
            'review' => fake()->paragraph,
            'movie_id' => movie::inRandomOrder()->first()->id, // Assign a random movie
            'user_id' => User::inRandomOrder()->first()->id, // Assign a random user
        ];
    }
}
