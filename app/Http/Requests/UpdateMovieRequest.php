<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $movieId = $this->route('movie'); // route pakai {movie} (id)
        return [
            //
            'title'        => 'sometimes|string|max:255',
            'slug'         => 'sometimes|string|unique:movies,slug,' . $movieId,
            'overview'     => 'sometimes|string',
            'poster'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'vote_average' => 'sometimes|numeric|min:0|max:10',
            'release_date' => 'sometimes|date',
            'runtime'      => 'sometimes|integer|min:1',
            'tagline'      => 'nullable|string|max:255',
            'genre_id'     => 'sometimes|exists:genres,id',
        ];
    }
}
