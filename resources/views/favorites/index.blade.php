@extends('layouts.app')

@section('title', 'Mis Favoritos - JODAXI')

@section('content')
<div style="grid-column: 1 / -1;">
    <h1>Mis Favoritos</h1>
    
    @if($favoritos->isEmpty())
        <div class="empty">Aún no has agregado favoritos. ¡Explora anuncios y guarda los que te interesen!</div>
    @else
        <div class="cards-grid">
            @foreach($favoritos as $fav)
                @php($anuncio = $fav->anuncio)
                @php($tipo = $anuncio->tipo_operacion)
                <article class="card">
                    <div style="position: relative;">
                        <div class="card-img">
                            @if($anuncio->imagenes->first())
                                <img src="{{ asset('storage/' . $anuncio->imagenes->first()->url) }}" 
                                    style="width:100%; height:100%; object-fit:cover; border-radius:0.5rem;">
                            @else
                                Sin imagen
                            @endif
                        </div>
                        <form action="{{ route('favorite.toggle', $anuncio->id) }}" method="POST" 
                            style="position: absolute; top: 0.5rem; right: 0.5rem;">
                            @csrf
                            <button type="submit" style="background: white; border: none; padding: 0.5rem; border-radius: 50%; cursor: pointer; font-size: 1.2rem;">
                                ❤️
                            </button>
                        </form>
                    </div>
                    <div class="card-title">{{ $anuncio->titulo }}</div>
                    <div class="card-price">
                        @if($anuncio->tipo_operacion === 'DONACION')
                            Donación
                        @elseif(is_null($anuncio->precio))
                            Precio a acordar
                        @else
                            ${{ number_format($anuncio->precio, 2) }}
                        @endif
                    </div>
                    <div class="card-meta">
                        {{ optional($anuncio->categoria)->nombre ?? 'Sin categoría' }}
                        • {{ $anuncio->ubicacion ?? 'Ubicación a acordar' }}
                    </div>
                    <div class="card-meta">
                        <span class="badge badge-{{ strtolower($tipo) }}">{{ $tipo }}</span>
                        <span class="estado-{{ strtolower($anuncio->estado) }}">{{ $anuncio->estado }}</span>
                    </div>
                    <div class="card-footer">
                        <span>Id #{{ $anuncio->id }}</span>
                        <a href="{{ route('user.profile', $anuncio->user_id) }}" style="color:var(--primary);">
                            {{ optional($anuncio->user)->name ?? 'Usuario' }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $favoritos->links() }}
    @endif
</div>
@endsection
