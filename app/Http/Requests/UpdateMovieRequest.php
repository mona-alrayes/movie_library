<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust this if authorization logic is needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:50',
            'director' => 'sometimes|string|max:50',
            'genre' => 'sometimes|string|max:50',
            'release_year' => 'sometimes|integer|min:1895|max:2023',
            'description' => 'sometimes|string|max:2000',
        ];
    }
}
