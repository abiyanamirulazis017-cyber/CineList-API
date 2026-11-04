<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    //
    public function index()
    {
        return GenreResource::collection(Genre::all());
    }

    public function show($id)
    {
        return new GenreResource(Genre::findOrFail($id));
    }

    public function store(StoreGenreRequest $request)
    {
        $genre = Genre::create($request->validated());
        return (new GenreResource($genre))->response()->setStatusCode(201);
    }

    public function update(StoreGenreRequest $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->update($request->validated());
        return new GenreResource($genre);
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        // Cek apakah genre masih dipakai movie
        if ($genre->movies()->exists()) {
            return response()->json([
                'message' => 'Genre tidak bisa dihapus karena masih dipakai movie.'
            ], 409);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre dihapus'], 200);
    }
}
