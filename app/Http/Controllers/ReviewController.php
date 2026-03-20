<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Anuncio;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Anuncio $anuncio)
    {
        $this->authorize('create', [Review::class, $anuncio]);
        return view('reviews.create', compact('anuncio'));
    }

    public function store(Request $request, Anuncio $anuncio)
    {
        $this->authorize('create', [Review::class, $anuncio]);

        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500'
        ]);

        Review::create([
            'reviewer_id' => auth()->id(),
            'reviewed_id' => $anuncio->user_id,
            'anuncio_id' => $anuncio->id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario
        ]);

        return redirect()->route('user.profile', $anuncio->user_id)
            ->with('success', 'Reseña publicada correctamente');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $userId = $review->reviewed_id;
        $review->delete();

        return back()->with('success', 'Reseña eliminada');
    }
}
