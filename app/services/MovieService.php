<?php
namespace App\Services;

use App\Models\Movie;
use App\Http\Resources\MovieResource;

class MovieService
{
    public function getAllMovies()
    {
        $movies = Movie::with('ratings')->get();
        return MovieResource::collection($movies)->toArray(request());
    }

    public function storeMovie(array $data)
    {
        $movie = Movie::create($data);
        // Wrap the single movie in a collection and convert to array
        return MovieResource::collection(collect([$movie]))->toArray(request());
    }

    public function showMovie(Movie $movie)
    {
        // Wrap the single movie in a collection and convert to array
        return MovieResource::collection(collect([$movie]))->toArray(request());
    }

    public function updateMovie(Movie $movie, array $data)
    {
        $movie->update($data);
        // Wrap the single movie in a collection and convert to array
        return MovieResource::collection(collect([$movie]))->toArray(request());
    }

    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        // Return an empty array to maintain consistency
        return [];
    }
}
