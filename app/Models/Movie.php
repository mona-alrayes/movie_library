<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Movie
 *
 * Represents a movie entity in the system. This model handles CRUD operations
 * for movies, including relationships with ratings and methods to calculate
 * average ratings.
 *
 * @package App\Models
 */
class Movie extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'director',
        'genre',
        'release_year',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_year' => 'integer',
    ];

    /**
     * Get the ratings associated with the movie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Calculate the average rating for the movie.
     *
     * @return float
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
