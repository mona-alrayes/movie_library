<?php

namespace App\Http\Controllers\Api;

use App\Models\rating;
use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\updateRatingRequest;
use App\Http\Controllers\Controller;


class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRatingRequest $request, rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rating $rating)
    {
        //
    }
}
