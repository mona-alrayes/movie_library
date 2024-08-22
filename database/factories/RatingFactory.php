<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\movie;
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
        $movieId = movie::inRandomOrder()->first()->id; 
        $userId = User::inRandomOrder()->first()->id; 

        return [
            'rating' => $this->faker->numberBetween(1, 5), // Assuming rating is between 1 and 5
            'review' => $this->faker->paragraph,
            'movie_id' => $movieId,
            'user_id' => $userId,
        ];
    }
}
