<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Rating
 *
 * Represents a rating entity associated with a movie and a user. This model
 * handles the rating details, including relationships with the movie and user.
 *
 * @package App\Models
 */
class Rating extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rating',
        'review',
        'movie_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'movie_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Get the movie associated with the rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie() 
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the user who gave the rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
