<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    //
    public function index(Request $request)
    {
        $movies = $request->user()->watchlists()->with('genre')->get();
        return MovieResource::collection($movies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
        ]);

        $exists = $request->user()->watchlists()
            ->where('movie_id', $request->movie_id)->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Movie sudah ada di watchlist.'
            ], 409);
        }

        $request->user()->watchlists()->attach($request->movie_id);

        return response()->json(['message' => 'Ditambahkan ke watchlist'], 201);
    }

    public function destroy(Request $request, $movie_id)
    {
        $detached = $request->user()->watchlists()->detach($movie_id);

        if (!$detached) {
            return response()->json([
                'message' => 'Movie tidak ada di watchlist.'
            ], 404);
        }

        return response()->json(['message' => 'Dihapus dari watchlist'], 200);
    }
}
