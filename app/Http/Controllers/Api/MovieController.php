<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Movie::with('genre');

        // Search judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter genre
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        // Sort — whitelist kolom agar tidak SQL injection
        $allowedSort = ['title', 'vote_average', 'release_date', 'created_at'];
        $sortBy = in_array($request->get('sort_by'), $allowedSort)
            ? $request->get('sort_by') : 'created_at';
        $order = strtolower($request->get('order')) === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $order);

        $perPage = (int) $request->get('per_page', 10);
        if ($perPage < 1 || $perPage > 100) $perPage = 10;

        $movies = $query->paginate($perPage);

        return MovieResource::collection($movies);
    }

    public function show($slug)
    {
        $movie = Movie::with('genre')->where('slug', $slug)->firstOrFail();
        return new MovieResource($movie);
    }

    public function store(StoreMovieRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $movie = Movie::create($data)->load('genre');
        return (new MovieResource($movie))->response()->setStatusCode(201);
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            // Hapus poster lama agar tidak menumpuk
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($data);
        return new MovieResource($movie->load('genre'));
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }
        $movie->delete();
        return response()->json(['message' => 'Movie dihapus'], 200);
    }
}
