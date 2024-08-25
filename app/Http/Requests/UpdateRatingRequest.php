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
        return true;
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
            'movie_id' => [
                'required',
                'integer',
                Rule::exists('movies', 'id')->where(function ($query) {
                    $query->where('id', $this->route('movieId'));
                }),
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Merge the movie_id from the route and user_id from the authenticated user
        $this->merge([
            'movie_id' => $this->route('movieId'),
            'user_id' => auth()->id(),
        ]);
    }
}
