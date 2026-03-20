@extends('layouts.app')

@section('title', 'Dejar Reseña - JODAXI')

@section('content')
<div style="grid-column: 1 / -1; max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h1>Dejar una Reseña</h1>
        
        <div style="padding: 1rem; background: var(--border); border-radius: 0.4rem; margin-bottom: 1rem;">
            <p style="margin: 0;"><strong>Anuncio:</strong> {{ $anuncio->titulo }}</p>
            <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">
                <strong>Vendedor:</strong> {{ $anuncio->user->name }}
            </p>
        </div>

        <form action="{{ route('review.store', $anuncio->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label><strong>Calificación*</strong></label>
                <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                    @for($i = 1; $i <= 5; $i++)
                        <label style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                            <input type="radio" name="calificacion" value="{{ $i }}" 
                                style="margin-right: 0.5rem;" required>
                            <span style="font-size: 1.5rem;">
                                @for($j = 0; $j < $i; $j++)
                                    ⭐
                                @endfor
                            </span>
                        </label>
                    @endfor
                </div>
                @error('calificacion')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="comentario"><strong>Comentario</strong></label>
                <textarea id="comentario" name="comentario" 
                    placeholder="Comparte tu experiencia con otros compradores..."
                    style="min-height: 150px; max-height: 300px;"></textarea>
                @error('comentario')
                    <p style="color: #d32f2f; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="background: var(--border); padding: 1rem; border-radius: 0.4rem; margin-bottom: 1rem; font-size: 0.9rem;">
                <strong>Pautas para reseñas:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    <li>Sé honesto y constructivo</li>
                    <li>No incluyas información personal o contacto</li>
                    <li>Evita lenguaje ofensivo</li>
                    <li>Las reseñas inapropiadas serán eliminadas</li>
                </ul>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-primary">Enviar Reseña</button>
                <a href="{{ route('user.profile', $anuncio->user) }}" class="btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
