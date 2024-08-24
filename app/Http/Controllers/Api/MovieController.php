<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;


class MovieController extends Controller
{
    protected $movieService;
    use ApiResponserTrait;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        try {
            $moviesWithRatings = $this->movieService->getAllMovies();
            return $this->successResponse($moviesWithRatings, 'All movies retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while fetching the movies.');
        }
    }

    public function store(StoreMovieRequest $request)
    {
        try {
            $validatedRequest = $request->validated();
            $movie = $this->movieService->storeMovie($validatedRequest);

            return $this->successResponse($movie, 'Movie stored successfully.', 201);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while storing the movie.');
        }
    }

    public function show($id)
    {
        try {
            $fetchedData = $this->movieService->showMovie($id);
            return $this->successResponse($fetchedData, 'Movie details retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while retrieving the movie.');
        }
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try {
            if (!$movie->exists) {
                return $this->notFound('Movie not found.');
            }
            $validatedRequest = $request->validated();
            $updatedMovieResource = $this->movieService->updateMovie($movie, $validatedRequest);
            return $this->successResponse($updatedMovieResource, 'Movie updated successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while updating the movie.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->movieService->deleteMovie($id);
            return $this->successResponse([], 'Movie deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while deleting the movie.');
        }
    }
    protected function handleException(\Exception $e, $message)
    {
        // Log the error if needed
        Log::error($e->getMessage());

        return response()->json([
            'message' => $message,
            'error' => $e->getMessage()
        ], 500);
    }
}
