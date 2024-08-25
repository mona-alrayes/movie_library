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
| This file is where you can register API routes for your application.
| Routes are loaded by the RouteServiceProvider and assigned to the "api"
| middleware group. Here, we define routes for movie management, rating
| management, and user authentication.
|
*/

// Routes that require admin access
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    /**
     * Store a new movie.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('movies', [MovieController::class, 'store']);

    /**
     * Update an existing movie.
     *
     * @param \Illuminate\Http\Request $request
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
     * Handle ratings related actions for movies.
     *
     * Provides routes to store, update, and delete ratings for movies.
     * 
     * @return \Illuminate\Routing\Router
     */
    Route::apiResource('/movies/{movieId}/rating', RatingController::class)
        ->only(['store', 'update', 'destroy']);
});

// Public routes for movies
Route::apiResource('movies', MovieController::class)
    // Exclude store, update, and destroy methods from the resource routes
    ->except('store', 'update', 'destroy');

/**
 * User authentication routes.
 */
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
