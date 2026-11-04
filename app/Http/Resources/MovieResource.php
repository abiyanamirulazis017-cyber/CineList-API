<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'overview'     => $this->overview,
            // URL utuh, karena React butuh <img src="...">
            'poster_path'  => $this->poster_path
                ? Storage::disk('public')->url($this->poster_path)
                : null,
            'vote_average' => $this->vote_average,
            'release_date' => $this->release_date,
            'runtime'      => $this->runtime,
            'tagline'      => $this->tagline,
            // React mengonsumsi array nama genre
            'genre_names'  => $this->genre ? [$this->genre->name] : [],
            'genre_id'     => $this->genre_id,
            'user_id'      => $this->user_id,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
