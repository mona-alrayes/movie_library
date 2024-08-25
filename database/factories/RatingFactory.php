<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;
use App\Models\User;
use App\Models\Rating;

/**
 * Factory for creating instances of the Rating model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5), // Random rating between 1 and 5
            'review' => $this->faker->paragraph, // Random paragraph for the review
            'movie_id' => Movie::inRandomOrder()->first()->id, // Random movie ID
            'user_id' => User::inRandomOrder()->first()->id, // Random user ID
        ];
    }
}
