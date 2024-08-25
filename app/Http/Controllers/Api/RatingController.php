<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;

class RatingController extends Controller
{
    protected $ratingService;
    use ApiResponserTrait;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            // $ratings = Rating::with(['movie', 'user'])->get();
            // $ratingsArray = RatingResource::collection($ratings)->toArray(request());
            // return $this->successResponse($ratingsArray, 'All ratings retrieved successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while retrieving ratings.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $rating = $this->ratingService->storeRating($validatedData);
            return $this->successResponse($rating, 'Rating created successfully.', 201);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while storing the rating.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Rating $rating): JsonResponse
    {
        try {
            // $ratingArray = RatingResource::collection(collect([$rating]))->toArray(request());
            // return $this->successResponse($ratingArray, 'Rating retrieved successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while retrieving the rating.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, $movieId): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Since the user ID is now retrieved from the authenticated user, use it directly
            $userId = auth()->id();

            // Update the rating using the movieId from the route and userId from the authenticated user
            $updatedRatingResource = $this->ratingService->updateRating($validatedData, $movieId, $userId);

            return $this->successResponse($updatedRatingResource, 'Rating updated successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while updating the rating.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($movieId): JsonResponse
    {
        try {
            $userId = auth()->id();
            return $this->ratingService->deleteRating($movieId, $userId);
        } catch (\Exception $e) {
            return $this->handleException($e, 'An error occurred while deleting the rating.');
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
