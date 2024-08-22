<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie; // Correct model name
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
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
        // Fetch a random movie and user, with fallback in case none exist
        $movieId = Movie::inRandomOrder()->first()->id ?? null;
        $userId = User::inRandomOrder()->first()->id ?? null;

        return [
            'rating' => $this->faker->numberBetween(1, 5), // Using $this->faker
            'review' => $this->faker->paragraph,
            'movie_id' => $movieId, // Assign a random movie, if available
            'user_id' => $userId,   // Assign a random user, if available
        ];
    }
}
