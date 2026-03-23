@extends('layouts.app')

@section('title', 'Marketplace - JODAXI')

@section('content')
    {{-- Sidebar mejorado de filtros --}}
    <aside class="panel">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <span style="font-size: 1.5rem;">🔍</span>
            <h2 style="margin: 0;">Explorar</h2>
        </div>
        <small style="display: block; margin-bottom: 1.5rem;">Encuentra exactamente lo que buscas filtrando por tipo, categoría o estado.</small>

        <div class="filters-group">
            <label>📌 Tipo de Operación</label>
            <div class="chips">
                @foreach(['VENTA'=>'🛒 Venta','COMPRA'=>'💳 Compra','INTERCAMBIO'=>'🔄 Intercambio','DONACION'=>'🎁 Donación'] as $key => $label)
                    <button type="button" onclick="updateQuery('tipo_operacion','{{ $key }}')" 
                        class="chip" 
                        style="@if(request('tipo_operacion')==$key) font-weight:700; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; border-color: var(--primary); @endif">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="filters-group">
            <label for="categoria_id">📚 Categoría</label>
            <select id="categoria_id" onchange="updateQuery('categoria_id', this.value)">
                <option value="">🌐 Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @if(request('categoria_id') == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="filters-group">
            <label for="estado">✅ Estado</label>
            <select id="estado" onchange="updateQuery('estado', this.value)">
                <option value="">📊 Todos</option>
                <option value="DISPONIBLE" @if(request('estado')=='DISPONIBLE') selected @endif>✅ Disponible</option>
                <option value="RESERVADO" @if(request('estado')=='RESERVADO') selected @endif>⏳ Reservado</option>
                <option value="CERRADO" @if(request('estado')=='CERRADO') selected @endif>❌ Cerrado</option>
            </select>
        </div>

        <hr style="margin:1.5rem 0; border:none; border-top:2px solid var(--border);">

        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
            <span style="font-size: 1.5rem;">➕</span>
            <h2 style="margin: 0;">Publicar</h2>
        </div>
        <small style="display: block; margin-bottom: 1rem;">Comparte tus artículos con la comunidad estudiantil.</small>

        <button onclick="window.location.href='{{ route('market.create') }}'" class="btn-primary" style="width:100%; margin-bottom:0.5rem;">
            ➕ Nueva Publicación
        </button>

        <button onclick="clearFilters()" class="btn-outline" style="width:100%;">
            🔄 Limpiar Filtros
        </button>

        <hr style="margin:1.5rem 0; border:none; border-top:2px solid var(--border);">

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <span style="font-size: 1.5rem;">ℹ️</span>
            <h3 style="margin: 0; font-size: 1rem; color: var(--primary-dark);">Información útil</h3>
        </div>
        <ul style="list-style: none; padding: 0; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
            <li style="margin-bottom: 0.75rem;">💡 <strong>Tip:</strong> Añade fotos claras para vender más rápido</li>
            <li style="margin-bottom: 0.75rem;">🛡️ <strong>Seguridad:</strong> Verifica siempre a los compradores</li>
            <li style="margin-bottom: 0.75rem;">⭐ <strong>Reputación:</strong> Las buenas reseñas te ayudan a vender</li>
        </ul>
    </aside>

    {{-- Sección principal mejorada --}}
    <section>
        <div class="cards-header">
            <div>
                <h2>🏪 Anuncios de la Comunidad</h2>
                <small>Descubre productos, servicios y oportunidades de intercambio entre estudiantes.</small>
            </div>
            <div>
                <button class="btn-outline" onclick="location.reload()" title="Actualizar listado">🔄 Actualizar</button>
            </div>
        </div>

        @if($anuncios->isEmpty())
            <div class="empty" style="text-align: center; padding: 3rem 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">No hay anuncios disponibles</p>
                <p>Sé el primero en publicar. <a href="{{ route('market.create') }}" style="color: var(--primary); text-decoration: underline; font-weight: 600;">Crea uno ahora</a></p>
            </div>
        @else
            <div class="cards-grid">
                @foreach($anuncios as $anuncio)
                    @php($tipo = $anuncio->tipo_operacion)
                    @php($isFavorite = auth()->check() ? auth()->user()->favoritos()->where('anuncio_id', $anuncio->id)->exists() : false)
                    <article class="card" onclick="window.location.href='{{ route('anuncios.show', $anuncio) }}'" style="cursor: pointer;">
                        <div class="card-img" style="position: relative;">
                            @php($first = $anuncio->imagenes->first())
                            @if($first)
                                <img src="{{ asset('storage/' . $first->url) }}" alt="{{ $anuncio->titulo }}"
                                    style="width:100%; height:100%; object-fit:cover; border-radius:0.75rem;">
                            @else
                                <div style="width:100%; height:100%; background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 2rem;">📷</div>
                            @endif
                            
                            <div class="card-badge">
                                @switch($tipo)
                                    @case('VENTA')
                                        🛒 Venta
                                    @break
                                    @case('COMPRA')
                                        💳 Compra
                                    @break
                                    @case('INTERCAMBIO')
                                        🔄 Intercambio
                                    @break
                                    @case('DONACION')
                                        🎁 Donación
                                    @break
                                @endswitch
                            </div>

                            @auth
                                <button type="button" 
                                    class="btn-favorite" 
                                    data-anuncio-id="{{ $anuncio->id }}"
                                    data-is-favorite="{{ $isFavorite ? 'true' : 'false' }}"
                                    onclick="event.stopPropagation(); toggleFavorite(event, {{ $anuncio->id }})"
                                    style="position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(255,255,255,0.95); border: none; border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.4rem; transition: all 0.3s ease; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                    <span class="heart-icon">{{ $isFavorite ? '❤️' : '🤍' }}</span>
                                </button>
                            @endauth
                        </div>

                        <div class="card-title" title="{{ $anuncio->titulo }}">{{ Str::limit($anuncio->titulo, 45) }}</div>
                        
                        <div class="card-price">
                            @if($anuncio->tipo_operacion === 'DONACION')
                                <span style="color: #16a34a; font-weight: 700;">🎁 Gratis</span>
                            @elseif(is_null($anuncio->precio))
                                <span style="color: #f97316;">Precio: Acordar</span>
                            @else
                                <span>${{ number_format($anuncio->precio, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        
                        <div class="card-meta">
                            <span style="display: inline-block; background: #dcfce7; color: #16a34a; padding: 0.3rem 0.6rem; border-radius: 0.4rem; font-weight: 600; font-size: 0.75rem;">
                                @switch(strtolower($anuncio->estado))
                                    @case('disponible')
                                        ✅ Disponible
                                    @break
                                    @case('reservado')
                                        ⏳ Reservado
                                    @break
                                    @case('cerrado')
                                        ❌ Vendido
                                    @break
                                    @default
                                        {{ $anuncio->estado }}
                                @endswitch
                            </span>
                        </div>
                        
                        <div class="card-meta" style="font-size: 0.85rem; margin: 0.5rem 0;">
                            📁 {{ optional($anuncio->categoria)->nombre ?? 'Sin categoría' }} 
                            @if($anuncio->ubicacion)
                                • 📍 {{ Str::limit($anuncio->ubicacion, 20) }}
                            @endif
                        </div>
                        
                        <div class="card-footer">
                            <span style="font-size: 0.8rem; color: var(--text-muted);">
                                👤 {{ optional($anuncio->user)->name ?? 'Usuario' }}
                            </span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">
                                ⏰ {{ $anuncio->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Paginación mejorada --}}
            @if($anuncios->hasPages())
                <div style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <a href="{{ $anuncios->previousPageUrl() }}" 
                        class="btn-outline" 
                        style="@if($anuncios->onFirstPage()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                        ← Anterior
                    </a>
                    @for ($i = 1; $i <= $anuncios->lastPage(); $i++)
                        @if ($i == $anuncios->currentPage())
                            <button style="background: var(--primary); color: white; padding: 0.5rem 0.75rem; border-radius: 0.5rem; border: none; font-weight: 700; cursor: default;">{{ $i }}</button>
                        @else
                            <a href="{{ $anuncios->url($i) }}" class="btn-outline" style="padding: 0.5rem 0.75rem;">{{ $i }}</a>
                        @endif
                    @endfor
                    <a href="{{ $anuncios->nextPageUrl() }}" 
                        class="btn-outline" 
                        style="@if(!$anuncios->hasMorePages()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                        Siguiente →
                    </a>
                </div>
                <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                    Página <strong>{{ $anuncios->currentPage() }}</strong> de <strong>{{ $anuncios->lastPage() }}</strong>
                </div>
            @endif
        @endif

        {{-- Categorías disponibles --}}
        @if($categorias->count() > 0)
            <div style="margin-top: 2.5rem;" class="panel">
                <h2 style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">📚</span> Categorías Disponibles
                </h2>
                <small style="display: block; margin-bottom: 1rem;">Explora productos por categoría</small>
                <div class="chips" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem;">
                    @foreach($categorias as $categoria)
                        <a href="?categoria_id={{ $categoria->id }}" class="chip" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s ease; border: 2px solid var(--border);">
                            {{ $categoria->nombre }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    @push('scripts')
    <script>
        function updateQuery(key, value) {
            const params = new URLSearchParams(window.location.search);
            if (value) {
                params.set(key, value);
            } else {
                params.delete(key);
            }
            window.location.search = params.toString();
        }

        function clearFilters() {
            window.location.search = '';
        }

        async function toggleFavorite(event, anuncioId) {
            event.preventDefault();
            event.stopPropagation();

            try {
                const response = await fetch('{{ route("favorite.toggle", ":id") }}'.replace(':id', anuncioId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const button = document.querySelector(`[data-anuncio-id="${anuncioId}"]`);
                    const heartIcon = button.querySelector('.heart-icon');
                    const isFavorite = button.getAttribute('data-is-favorite') === 'true';

                    if (isFavorite) {
                        heartIcon.textContent = '🤍';
                        button.setAttribute('data-is-favorite', 'false');
                    } else {
                        heartIcon.textContent = '❤️';
                        button.setAttribute('data-is-favorite', 'true');
                    }
                } else {
                    alert('Error al guardar. Por favor intenta nuevamente.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión. Por favor intenta nuevamente.');
            }
        }
    </script>
    @endpush
@endsection
