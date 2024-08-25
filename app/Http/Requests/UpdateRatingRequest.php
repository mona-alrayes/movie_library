<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this if authorization logic is required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'sometimes|integer|between:1,5',
            'review' => 'sometimes|string|max:2000',
            // Ensure the movie exists
            'movie_id' => [
                'required',
                'integer',
                Rule::exists('movies', 'id'),
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Set the movie_id from the route
        $this->merge([
            'movie_id' => $this->route('movieId'),
            'user_id' => auth()->id(),
        ]);
    }
}
