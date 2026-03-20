@extends('layouts.app')

@section('title', $user->name . ' - JODAXI')

@section('content')
@if(session('success'))
    <div style="grid-column: 1 / -1; background: #dcfce7; border-left: 4px solid #16a34a; padding: 1rem; border-radius: 0.4rem; margin-bottom: 1rem;">
        <p style="margin: 0; color: #166534; font-weight: 500;">✓ {{ session('success') }}</p>
    </div>
@endif

<div style="grid-column: 1 / -1;">
    <div class="panel" style="margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 2rem; align-items: start;">
            <!-- Avatar -->
            <div style="flex-shrink: 0;">
                @if($user->foto_perfil)
                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" 
                        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
                @else
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 2rem; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- Información -->
            <div style="flex: 1;">
                <h1 style="margin: 0 0 0.5rem 0;">{{ $user->name }}</h1>
                
                @if($user->verificado)
                    <span class="badge" style="background: #dcfce7; color: #166534; display: inline-block; margin-bottom: 0.5rem;">✓ Verificado</span>
                @endif

                <div style="display: flex; gap: 2rem; margin-bottom: 1rem; flex-wrap: wrap;">
                    <div>
                        <div style="font-weight: 600;">{{ $totalVentas }}</div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">Anuncios Publicados</div>
                    </div>
                    <div>
                        <div style="font-weight: 600;">{{ number_format($calificacionPromedio, 1) }}/5 ⭐</div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">{{ $totalResenas }} reseña{{ $totalResenas != 1 ? 's' : '' }}</div>
                    </div>
                </div>

                @if($user->bio)
                    <p style="color: var(--text-muted); margin: 0.5rem 0;">{{ $user->bio }}</p>
                @endif

                @if($user->telefono)
                    <p style="color: var(--text-muted); margin: 0.5rem 0;">📞 {{ $user->telefono }}</p>
                @endif

                <!-- Acciones -->
                <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                    @auth
                        @if(auth()->id() !== $user->id)
                            <a href="{{ route('messages.show', $user->id) }}" class="btn-primary">Enviar Mensaje</a>
                            <a href="{{ route('review.create', 0) }}" class="btn-outline" style="cursor: pointer;">Dejar Reseña</a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn-primary">Editar Perfil</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Anuncios del usuario -->
    @if($anuncios->isNotEmpty())
        <div style="margin-bottom: 2rem;">
            <h2>Anuncios Activos</h2>
            <div class="cards-grid">
                @foreach($anuncios as $anuncio)
                    <article class="card">
                        <div class="card-img">
                            @if($anuncio->imagenes->first())
                                <img src="{{ asset('storage/' . $anuncio->imagenes->first()->url) }}" 
                                    style="width:100%; height:100%; object-fit:cover; border-radius:0.5rem;">
                            @else
                                Sin imagen
                            @endif
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
                            <span class="badge badge-{{ strtolower($anuncio->tipo_operacion) }}">{{ $anuncio->tipo_operacion }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
            {{ $anuncios->links() }}
        </div>
    @endif

    <!-- Reseñas -->
    @if($resenas->isNotEmpty())
        <div class="panel">
            <h2>Reseñas ({{ $totalResenas }})</h2>
            @foreach($resenas as $resena)
                <div style="border-bottom: 1px solid var(--border); padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                        <div>
                            <strong>{{ $resena->reviewer->name }}</strong>
                            <div style="color: #ffc107; font-size: 0.85rem;">
                                {{ str_repeat('⭐', $resena->calificacion) }}
                            </div>
                        </div>
                        <span style="color: var(--text-muted); font-size: 0.85rem;">{{ $resena->created_at->format('d M Y') }}</span>
                    </div>
                    @if($resena->comentario)
                        <p style="margin: 0.5rem 0; color: var(--text-muted);">{{ $resena->comentario }}</p>
                    @endif
                </div>
            @endforeach
            {{ $resenas->links() }}
        </div>
    @else
        <div class="empty">Aún no hay reseñas para este usuario</div>
    @endif
</div>
@endsection
