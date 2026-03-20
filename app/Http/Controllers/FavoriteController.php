<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Anuncio;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Anuncio $anuncio)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('anuncio_id', $anuncio->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Removido de favoritos';
            $isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'anuncio_id' => $anuncio->id
            ]);
            $message = 'Añadido a favoritos';
            $isFavorite = true;
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'isFavorite' => $isFavorite
            ]);
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favoritos = auth()->user()->favoritos()
            ->with(['anuncio.categoria', 'anuncio.imagenes', 'anuncio.user'])
            ->latest()
            ->paginate(20);

        return view('favorites.index', compact('favoritos'));
    }

    public function isFavorite(Anuncio $anuncio): bool
    {
        return Favorite::where('user_id', auth()->id())
            ->where('anuncio_id', $anuncio->id)
            ->exists();
    }
}
