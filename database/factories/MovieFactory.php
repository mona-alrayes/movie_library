<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;

/**
 * Factory for creating instances of the Movie model.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), 
            'director' => $this->faker->name, 
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Horror', 'Science Fiction', 'Romance']), // Random genre from predefined list
            'release_year' => $this->faker->numberBetween(1900, date('Y')), 
            'description' => $this->faker->paragraph, 
        ];
    }
}
