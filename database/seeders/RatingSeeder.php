<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Number of ratings to create.
     *
     * @var int
     */
    protected $numberOfRatings = 10; // Specify the number of ratings you want to create

    /**
     * Seed the ratings table.
     *
     * @return void
     */
    public function run()
    {
        Rating::factory()->count($this->numberOfRatings)->create();
    }
}
