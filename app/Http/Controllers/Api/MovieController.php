<?php 
namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Services\MovieService;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
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
            $movieResource = $this->movieService->storeMovie($validatedRequest);
            return $this->successResponse($movieResource, 'Movie stored successfully.', 201);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while storing the movie.');
        }
    }

    public function show(Movie $movie)
    {
        try {
            $fetchedData = $this->movieService->showMovie($movie);
            return $this->successResponse($fetchedData, 'Movie details retrieved successfully.', 200);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while retrieving the movie.');
        }
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try {
            $validatedRequest = $request->validated();
            $updatedMovieResource = $this->movieService->updateMovie($movie, $validatedRequest);
            return $this->successResponse($updatedMovieResource, 'Movie updated successfully.', 200);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while updating the movie.');
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            $this->movieService->deleteMovie($movie);
            return $this->successResponse(null, 'Movie deleted successfully.', 204);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while deleting the movie.');
        }
    }

}
