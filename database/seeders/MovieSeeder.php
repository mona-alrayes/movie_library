<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Movie;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define the number of movies you want to seed
        $numberOfMovies = 10;

        // Seed the database with fake movie data
        foreach (range(1, $numberOfMovies) as $index) {
            Movie::create([
                'title' => $faker->sentence(3),
                'director' => $faker->name,
                'genre' => $faker->word,
                'release_year' => $faker->year,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
