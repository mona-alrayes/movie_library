<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MovieResource;


class MovieService
{

    public function getAllMovies()
    {
        $movies = Movie::with('ratings')->paginate('20');
        return MovieResource::collection($movies)->toArray(request());
    }

    public function storeMovie(array $data)
    {
        $movie = Movie::create([
            'title' => $data['title'],
            'director' => $data['director'],
            'genre' => $data['genre'],
            'release_year' => $data['release_year'],
            'description' => $data['description'],
        ]);

        if (!$movie) {
            throw new \Exception('Failed to create the movie.');
        }

        return MovieResource::make($movie)->toArray(request());
    }



    public function showMovie($id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            throw new \Exception('Movie not found.');
        }
        // Wrap the single movie in a collection and convert to array
        return MovieResource::make($movie)->toArray(request());
    }

    public function updateMovie(Movie $movie, array $data)
    {

        // Update only the provided fields
        $movie->update(array_filter([
            'title' => $data['title'] ?? $movie->title,
            'director' => $data['director'] ?? $movie->director,
            'genre' => $data['genre'] ?? $movie->genre,
            'release_year' => $data['release_year'] ?? $movie->release_year,
            'description' => $data['description'] ?? $movie->description,
        ]));

        // Wrap the updated movie in a collection and convert to array
        return MovieResource::make($movie)->toArray(request());
    }

    public function deleteMovie($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            throw new \Exception('Movie not found.');
        }
        $movie->delete();
    }
}
