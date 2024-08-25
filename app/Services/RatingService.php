<?php

namespace App\Services;

use App\Models\Rating;
use App\Http\Resources\RatingResource;


class RatingService
{

    public function storeRating(array $data)
    {
        $rating = Rating::create([
            'movie_id' => $data['movie_id'],
            'user_id' => $data['user_id'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);
        if (!$rating) {
            throw new \Exception('Failed to create the Rating.');
        }

        return RatingResource::make($rating)->toArray(request());
    }


    public function updateRating(array $data, $movieId, $userId)
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


    public function deleteRating($MovieId, $userID)
    {
        //bring rating that has this movie_id and User_id
        $rating = Rating::where('movie_id', $MovieId)->where('user_id', $userID)->first();
        //if there is no rating found then return not found
        if (!$rating) {
            return response()->json(['message' => 'Rating not found.'], 404);
        }
        //else delete the rating and return succuess deleting message 
        $rating->delete();
        return response()->json(['message' => 'Rating deleted successfully'], 200); // OK
    }
}
