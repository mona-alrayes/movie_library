<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\MovieResource;

/**
 * Class MovieService
 * 
 * This service handles operations related to movies, including fetching, storing, updating, and deleting movies.
 */
class MovieService
{
    /**
     * Retrieve all movies with optional filters and sorting.
     * 
     * @param Request $request
     * The request object containing optional filters (genre, director) and sorting options (sort_by, sort_order).
     * 
     * @return array
     * An array containing paginated movie resources.
     */
    public function getAllMovies(Request $request): array
    {
        // Create a query builder instance for the Movie model
        $query = Movie::with('ratings');

        // Apply filters based on request parameters
        $query->when($request->genre, function ($q, $genre) {
            return $q->where('genre', $genre);
        });

        $query->when($request->director, function ($q, $director) {
            return $q->where('director', $director);
        });

        // Apply sorting if specified
        if ($request->sort_by) {
            $sortOrder = $request->sort_order ?? 'asc';
            $query->orderBy($request->sort_by, $sortOrder);
        }

        // Paginate the results
        $movies = $query->paginate(10);

        // Return the paginated movies wrapped in a MovieResource collection
        return MovieResource::collection($movies)->toArray(request());
    }

    /**
     * Store a new movie.
     * 
     * @param array $data
     * An associative array containing 'title', 'director', 'genre', 'release_year', and 'description'.
     * 
     * @return array
     * An array containing the created movie resource.
     * 
     * @throws \Exception
     * Throws an exception if the movie creation fails.
     */
    public function storeMovie(array $data): array
    {
        // Create a new movie using the provided data
        $movie = Movie::create([
            'title' => $data['title'],
            'director' => $data['director'],
            'genre' => $data['genre'],
            'release_year' => $data['release_year'],
            'description' => $data['description'],
        ]);

        // Check if the movie was created successfully
        if (!$movie) {
            throw new \Exception('Failed to create the movie.');
        }

        // Return the created movie as a resource
        return MovieResource::make($movie)->toArray(request());
    }

    /**
     * Retrieve a specific movie by its ID.
     * 
     * @param int $id
     * The ID of the movie to retrieve.
     * 
     * @return array
     * An array containing the movie resource.
     * 
     * @throws \Exception
     * Throws an exception if the movie is not found.
     */
    public function showMovie(int $id): array
    {
        // Find the movie by ID
        $movie = Movie::find($id);

        // If no movie is found, throw an exception
        if (!$movie) {
            throw new \Exception('Movie not found.');
        }

        // Return the found movie as a resource
        return MovieResource::make($movie)->toArray(request());
    }

    /**
     * Update an existing movie.
     * 
     * @param Movie $movie
     * The movie model instance to update.
     * @param array $data
     * An associative array containing the fields to update (title, director, genre, release_year, description).
     * 
     * @return array
     * An array containing the updated movie resource.
     */
    public function updateMovie(Movie $movie, array $data): array
    {
        // Update only the fields that are provided in the data array
        $movie->update(array_filter([
            'title' => $data['title'] ?? $movie->title,
            'director' => $data['director'] ?? $movie->director,
            'genre' => $data['genre'] ?? $movie->genre,
            'release_year' => $data['release_year'] ?? $movie->release_year,
            'description' => $data['description'] ?? $movie->description,
        ]));

        // Return the updated movie as a resource
        return MovieResource::make($movie)->toArray(request());
    }

    /**
     * Delete a movie by its ID.
     * 
     * @param int $id
     * The ID of the movie to delete.
     * 
     * @return void
     * 
     * @throws \Exception
     * Throws an exception if the movie is not found.
     */
    public function deleteMovie(int $id): void
    {
        // Find the movie by ID
        $movie = Movie::find($id);

        // If no movie is found, throw an exception
        if (!$movie) {
            throw new \Exception('Movie not found.');
        }

        // Delete the movie
        $movie->delete();
    }
}
