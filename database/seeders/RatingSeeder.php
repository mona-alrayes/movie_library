<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Movie;
use App\Models\User;
use Faker\Factory as Faker;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define the number of ratings you want to seed
        $numberOfRatings = 20;

        // Seed the database with fake rating data
        foreach (range(1, $numberOfRatings) as $index) {
            Rating::create([
                'rating' => $faker->numberBetween(1, 5), // Assuming rating is between 1 and 5
                'review' => $faker->paragraph,
                'movie_id' => Movie::inRandomOrder()->first()->id, // Assign a random movie
                'user_id' => User::inRandomOrder()->first()->id, // Assign a random user
            ]);
        }
    }
}
