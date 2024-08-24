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
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::post('movies', [MovieController::class, 'store']);
    Route::put('movies/{movie}', [MovieController::class, 'update']);
    Route::delete('movies/{movie}', [MovieController::class, 'destroy']);
});

// Public routes for movies
Route::apiResource('movies', MovieController::class)
    ->except('store', 'update', 'destroy'); // These are the routes excluded from apiResource

// Authentication routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
