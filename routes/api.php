<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes that require admin access
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    /**
     * Store a new movie.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('movies', [MovieController::class, 'store']);

    /**
     * Update an existing movie.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    Route::put('movies/{movie}', [MovieController::class, 'update']);

    /**
     * Delete a movie.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    Route::delete('movies/{movie}', [MovieController::class, 'destroy']);
});

// Routes that require user access
Route::group(['middleware' => ['auth:sanctum', 'role:user']], function () {
    /**
     * Store a new rating for a movie.
     *
     * @param int $movieId
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/movies/{movieId}/rating', [RatingController::class, 'store']);

    /**
     * Update an existing rating for a movie.
     *
     * @param int $movieId
     * @return \Illuminate\Http\JsonResponse
     */
    Route::put('/movies/{movieId}/rating', [RatingController::class, 'update']);

    /**
     * Delete a rating for a movie.
     *
     * @param int $movieId
     * @return \Illuminate\Http\JsonResponse
     */
    Route::delete('/movies/{movieId}/rating', [RatingController::class, 'destroy']);
});

// Public routes for movies
Route::apiResource('movies', MovieController::class)
    // Exclude store, update, and destroy methods from apiResource routes
    ->except('store', 'update', 'destroy');

/**
 * User authentication routes.
 */
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
