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
        return new MovieResource($movie);
    }

    public function showMovie(Movie $movie)
    {
        return new MovieResource($movie);
    }

    public function updateMovie(Movie $movie, array $data)
    {
        $movie->update($data);
        return new MovieResource($movie);
    }

    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        return response()->noContent();
    }
}
