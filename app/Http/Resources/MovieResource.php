<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RatingResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'director' => $this->director,
            'genre' => $this->genre,
            'release_year' => $this->release_year,
            'description' => $this->description,
            'ratings' => RatingResource::collection($this->whenLoaded('ratings')), // Include ratings if they are loaded
            'average_rating' => $this->averageRating(),
        ];
    }
}
