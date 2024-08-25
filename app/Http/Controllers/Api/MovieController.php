<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $moviesWithRatings = $this->movieService->getAllMovies($request);
            return $this->successResponse($moviesWithRatings, 'All movies retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while fetching the movies.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        try {
            $validatedRequest = $request->validated();
            $movie = $this->movieService->storeMovie($validatedRequest);

            return $this->successResponse($movie, 'Movie stored successfully.', 201);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while storing the movie.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $fetchedData = $this->movieService->showMovie($id);
            return $this->successResponse($fetchedData, 'Movie details retrieved successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while retrieving the movie.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->movieService->deleteMovie($id);
            return $this->successResponse([], 'Movie deleted successfully.', 200);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while deleting the movie.');
        }
    }

    /**
     * Handle exceptions and return a response.
     */
    protected function handleException(\Exception $e, string $message): JsonResponse
    {
        // Log the error with additional context if needed
        Log::error($message, ['exception' => $e->getMessage(), 'request' => request()->all()]);

        return $this->errorResponse($message, [$e->getMessage()], 500);
    }
}
