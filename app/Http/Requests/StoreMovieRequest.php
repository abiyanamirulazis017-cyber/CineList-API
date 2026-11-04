<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
        return [
            //
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|unique:movies,slug',
            'overview'     => 'required|string',
            'poster'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'vote_average' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'runtime'      => 'required|integer|min:1',
            'tagline'      => 'nullable|string|max:255',
            'genre_id'     => 'required|exists:genres,id',
        ];
    }
}
