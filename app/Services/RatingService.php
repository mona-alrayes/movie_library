<?php

namespace App\Services;

use App\Models\Rating;
use App\Http\Resources\RatingResource;

/**
 * Class RatingService
 * 
 * This service handles operations related to ratings, including storing, updating, and deleting ratings.
 */
class RatingService
{
    /**
     * Store a new rating.
     * 
     * @param array $data
     * An associative array containing 'movie_id', 'user_id', 'rating', and 'review'.
     * 
     * @return array
     * An array containing the created rating resource.
     * 
     * @throws \Exception
     * Throws an exception if the rating creation fails.
     */
    public function storeRating(array $data): array
    {
        // Create a new rating using the provided data
        $rating = Rating::create([
            'movie_id' => $data['movie_id'],
            'user_id' => $data['user_id'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);

        // Check if the rating was created successfully
        if (!$rating) {
            throw new \Exception('Failed to create the Rating.');
        }

        // Return the created rating as a resource
        return RatingResource::make($rating)->toArray(request());
    }

    /**
     * Update an existing rating.
     * 
     * @param array $data
     * An associative array containing 'rating' and/or 'review' to be updated.
     * @param int $movieId
     * The ID of the movie associated with the rating.
     * @param int $userId
     * The ID of the user who created the rating.
     * 
     * @return array
     * An array containing the updated rating resource.
     * 
     * @throws \Exception
     * Throws an exception if the rating update fails.
     */
    public function updateRating(array $data, int $movieId, int $userId): array
    {
        // Find the existing rating based on movie_id and user_id
        $rating = Rating::where('movie_id', $movieId)->where('user_id', $userId)->first();

        // If no rating is found, return an appropriate response
        if (!$rating) {
            return response()->json(['message' => 'Rating not found.'], 404);
        }

        // Update only the fields that are present in the input data
        if (isset($data['rating'])) {
            $rating->rating = $data['rating'];
        }
        if (isset($data['review'])) {
            $rating->review = $data['review'];
        }

        // Save the updated rating to the database
        $rating->save();

        // Return the updated rating as a resource
        return RatingResource::make($rating)->toArray(request());
    }

    /**
     * Delete an existing rating.
     * 
     * @param int $movieId
     * The ID of the movie associated with the rating to be deleted.
     * @param int $userId
     * The ID of the user who created the rating to be deleted.
     * 
     * @return \Illuminate\Http\JsonResponse
     * A JSON response indicating success or failure.
     */
    public function deleteRating(int $movieId, int $userId)
    {
        // Retrieve the rating that matches the provided movie_id and user_id
        $rating = Rating::where('movie_id', $movieId)->where('user_id', $userId)->first();

        // If no rating is found, return a 'not found' response
        if (!$rating) {
            return response()->json(['message' => 'Rating not found.'], 404);
        }

        // Delete the rating and return a success response
        $rating->delete();
        return response()->json(['message' => 'Rating deleted successfully'], 200); // OK
    }
}
