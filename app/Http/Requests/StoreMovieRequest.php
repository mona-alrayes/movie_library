<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'title' => 'sometimes|string|max:50',
            'director' => 'sometimes|string|max:50',
            'genre' => 'sometimes|string|max:50',
            'release_year' => 'sometimes|integer|min:1895|max:' . date('Y'),
            'description' => 'sometimes|string|max:2000',
        ];
    }
}
