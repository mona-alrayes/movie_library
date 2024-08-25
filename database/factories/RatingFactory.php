<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie; 

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
        // Retrieve a random movie ID and user ID for the rating
        $movieId = Movie::inRandomOrder()->first()->id; // Fetch a random movie ID
        $userId = User::inRandomOrder()->first()->id;   // Fetch a random user ID

        return [
            'rating' => $this->faker->numberBetween(1, 5), 
            'review' => $this->faker->paragraph,          
            'movie_id' => $movieId,                       
            'user_id' => $userId,                         
        ];
    }
}
