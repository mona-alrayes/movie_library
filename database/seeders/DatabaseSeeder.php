<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call UserSeeder to create users first
        $this->call(UserSeeder::class);

        // Call MovieSeeder to create movies after users
        $this->call(MovieSeeder::class);

        // Call RatingSeeder to create ratings after movies
        $this->call(RatingSeeder::class);
    }
}
