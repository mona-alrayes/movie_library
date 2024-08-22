<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Http\Traits\ApiResponserTrait;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    use ApiResponserTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $ratings = Rating::with(['movie', 'user'])->get();
            $ratingsArray = RatingResource::collection($ratings)->toArray(request());

            return $this->successResponse($ratingsArray, 'All ratings retrieved successfully.');
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while retrieving ratings.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $rating = Rating::create($validatedData);

            $ratingArray = RatingResource::collection(collect([$rating]))->toArray(request());

            return $this->successResponse($ratingArray, 'Rating created successfully.', 201);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while storing the rating.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating): JsonResponse
    {
        try {
            $ratingArray = RatingResource::collection(collect([$rating]))->toArray(request());

            return $this->successResponse($ratingArray, 'Rating retrieved successfully.');
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while retrieving the rating.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $rating): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $rating->update($validatedData);

            $ratingArray = RatingResource::collection(collect([$rating]))->toArray(request());

            return $this->successResponse($ratingArray, 'Rating updated successfully.');
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while updating the rating.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating): JsonResponse
    {
        try {
            $rating->delete();

            return $this->successResponse([], 'Rating deleted successfully.', 204);
        } catch (\Throwable $th) {
            return $this->handleException($th, 'An error occurred while deleting the rating.');
        }
    }
}
