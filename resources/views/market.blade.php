@extends('layouts.app')

@section('title', 'Marketplace - JODAXI')

@section('content')
    {{-- Sidebar de filtros y creación --}}
    <aside class="panel">
        <h2>Explorar</h2>
        <small>Filtra anuncios por tipo, categoría o estado.</small>

        <div class="filters-group">
            <label>Tipo de operación</label>
            <div class="chips">
                @foreach(['VENTA'=>'Venta','COMPRA'=>'Compra','INTERCAMBIO'=>'Intercambio','DONACION'=>'Donación'] as $key => $label)
                    <button type="button" onclick="updateQuery('tipo_operacion','{{ $key }}')" class="chip" style="@if(request('tipo_operacion')==$key) font-weight:600; background:#e5e7eb; @endif">{{ $label }}</button>
                @endforeach
            </div>
        </div>

        <div class="filters-group" style="margin-top:0.75rem;">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" onchange="updateQuery('categoria_id', this.value)">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @if(request('categoria_id') == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="filters-group" style="margin-top:0.75rem;">
            <label for="estado">Estado</label>
            <select id="estado" onchange="updateQuery('estado', this.value)">
                <option value="">Todos</option>
                <option value="DISPONIBLE" @if(request('estado')=='DISPONIBLE') selected @endif>Disponible</option>
                <option value="RESERVADO" @if(request('estado')=='RESERVADO') selected @endif>Reservado</option>
                <option value="CERRADO" @if(request('estado')=='CERRADO') selected @endif>Cerrado</option>
            </select>
        </div>

        <hr style="margin:1rem 0; border:none; border-top:1px solid var(--border);">

        <h2>Publicar anuncio</h2>
        <small>Crea un nuevo anuncio de venta, compra, intercambio o donación.</small>

        <button onclick="window.location.href='{{ route('market.create') }}'" class="btn-primary" style="width:100%; margin-top:0.8rem;">
            Crear nueva publicación
        </button>

        <button onclick="clearFilters()" class="btn-outline" style="width:100%; margin-top:0.5rem;">
            Limpiar filtros
        </button>

    </aside>

    {{-- Listado de anuncios en estilo marketplace --}}
    <section>
        <div class="cards-header">
            <div>
                <h2>Anuncios de estudiantes</h2>
                <small>Compra, venta, intercambio y donaciones dentro de la comunidad.</small>
            </div>
            <div>
                <button class="btn-outline" onclick="location.reload()">Actualizar</button>
            </div>
        </div>

        @if($anuncios->isEmpty())
            <div class="empty">Todavía no hay anuncios publicados. Crea el primero desde el panel izquierdo.</div>
        @else
            <div class="cards-grid">
                @foreach($anuncios as $anuncio)
                    @php($tipo = $anuncio->tipo_operacion)
                    @php($isFavorite = auth()->check() ? auth()->user()->favoritos()->where('anuncio_id', $anuncio->id)->exists() : false)
                    <article class="card" style="position: relative;">
                        <div class="card-img" style="position: relative;">
                        @php($first = $anuncio->imagenes->first())
                        @if($first)
                            <img src="{{ asset('storage/' . $first->url) }}" 
                                style="width:100%; height:100%; object-fit:cover; border-radius:0.5rem;">
                        @else
                            Sin imagen
                        @endif
                        
                        @auth
                            <button type="button" 
                                class="btn-favorite" 
                                data-anuncio-id="{{ $anuncio->id }}"
                                data-is-favorite="{{ $isFavorite ? 'true' : 'false' }}"
                                onclick="toggleFavorite(event, {{ $anuncio->id }})"
                                style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.5rem; transition: transform 0.2s, background 0.2s; z-index: 10;">
                                <span class="heart-icon">{{ $isFavorite ? '❤️' : '🤍' }}</span>
                            </button>
                        @endauth
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
                            <span>Id anuncio #{{ $anuncio->id }}</span>
                            <span style="color:var(--text-muted);">{{ optional($anuncio->user)->name ?? 'Usuario #' . $anuncio->user_id }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top:1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;">
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ $anuncios->previousPageUrl() ? $anuncios->previousPageUrl() . '&' . request()->getQueryString() : '#' }}" 
                        class="btn-outline" 
                        style="padding: 0.4rem 0.75rem; opacity: {{ $anuncios->onFirstPage() ? '0.5' : '1' }}; pointer-events: {{ $anuncios->onFirstPage() ? 'none' : 'auto' }};">
                        « Anterior
                    </a>
                    <a href="{{ $anuncios->nextPageUrl() ? $anuncios->nextPageUrl() . '&' . request()->getQueryString() : '#' }}" 
                        class="btn-outline" 
                        style="padding: 0.4rem 0.75rem; opacity: {{ $anuncios->hasMorePages() ? '1' : '0.5' }}; pointer-events: {{ $anuncios->hasMorePages() ? 'auto' : 'none' }};">
                        Siguiente »
                    </a>
                </div>

                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Página {{ $anuncios->currentPage() }} de {{ $anuncios->lastPage() }}
                </div>
            </div>
        @endif

            <div style="margin-top:1.5rem;" class="panel">
            <h2>Categorías disponibles</h2>
            @if($categorias->isEmpty())
                <div class="empty" style="margin:0; border:none;">Aún no hay categorías registradas.</div>
            @else
                <div class="chips" style="margin-top:0.5rem;">
                    @foreach($categorias as $categoria)
                        <a href="?categoria_id={{ $categoria->id }}" class="chip">{{ $categoria->nombre }}</a>
                    @endforeach
                </div>
            @endif
        </div>
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
