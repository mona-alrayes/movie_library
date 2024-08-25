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
        return true; // Adjust this if specific authorization is needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentYear = date('Y');

        return [
            'title' => 'required|string|max:50',
            'director' => 'required|string|max:50',
            'genre' => 'required|string|max:50',
            'release_year' => [
                'required',
                'integer',
                'min:1895',
                'max:' . $currentYear,
            ],
            'description' => 'required|string|max:2000',
        ];
    }
}
