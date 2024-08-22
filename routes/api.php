<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


Route::group(['prefix' => 'v1'], function () {
    // Movie Routes using apiResource
    Route::apiResource('movies', MovieController::class);

    // Additional route to get a specific movie with its ratings
    Route::get('/movies/{movie}/ratings', [RatingController::class, 'indexForMovie'])->name('movies.ratings.index'); // View all ratings for a specific movie

    // Rating Routes
    Route::post('/movies/{movie}/ratings', [RatingController::class, 'store'])->name('movies.ratings.store'); // Add a rating to a specific movie
    Route::delete('/movies/{movie}/ratings/{rating}', [RatingController::class, 'destroy'])->name('movies.ratings.destroy'); // Delete a specific rating
});
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::apiResource('/movies', MovieController::class);
    Route::apiResource('/ratings', RatingController::class);
});
