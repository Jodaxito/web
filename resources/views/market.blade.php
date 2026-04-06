@extends('layouts.app')

@section('title', 'Marketplace - JODAXI')

@push('styles')
<style>
    /* Estilos mejorados para el marketplace */
    .tabs-container {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--border);
        padding-bottom: 0.5rem;
    }
    
    .tab-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        background: transparent;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        border-radius: 0.75rem 0.75rem 0 0;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .tab-btn:hover {
        color: var(--primary);
        background: var(--primary-soft);
    }
    
    .tab-btn.active {
        color: var(--primary);
        background: var(--primary-soft);
    }
    
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary);
        border-radius: 3px 3px 0 0;
    }
    
    .tab-btn .count {
        background: var(--primary);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    .tab-btn:not(.active) .count {
        background: var(--text-muted);
    }
    
    .btn-favorite {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: rgba(255,255,255,0.95);
        border: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .btn-favorite:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .btn-favorite.is-favorite {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: white;
    }
    
    .btn-favorite:not(.is-favorite) {
        color: #f43f5e;
    }
    
    .heart-icon {
        font-size: 1.4rem;
        transition: all 0.3s ease;
    }
    
    .btn-favorite.is-favorite .heart-icon {
        animation: heartbeat 0.3s ease-in-out;
    }
    
    @keyframes heartbeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
    
    /* Tarjeta mejorada */
    .card-user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-light);
    }
    
    .card-user-avatar-placeholder {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .card-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border);
    }
    
    .btn-card-action {
        flex: 1;
        padding: 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        border: none;
    }
    
    .btn-card-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-card-action.primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
    }
    
    .btn-card-action.secondary {
        background: var(--bg);
        color: var(--text-muted);
        border: 2px solid var(--border);
    }
    
    .btn-card-action.secondary:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    /* Empty state mejorado */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--card);
        border-radius: 1.5rem;
        border: 2px dashed var(--border);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        font-size: 1.3rem;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }
    
    /* Stats cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, var(--primary-soft) 0%, #dbeafe 100%);
        padding: 1rem;
        border-radius: 1rem;
        text-align: center;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .stat-card h4 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin: 0;
    }
    
    .stat-card p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0.25rem 0 0 0;
    }
</style>
@endpush

@section('content')
    {{-- Sidebar mejorado de filtros --}}
    <aside class="panel">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <h2 style="margin: 0;">Explorar</h2>
        </div>
        <small style="display: block; margin-bottom: 1.5rem;">Encuentra exactamente lo que buscas filtrando por tipo, categoría o estado.</small>

        <div class="filters-group">
            <label>Tipo de Operación</label>
            <div class="chips">
                @foreach(['VENTA'=>'Venta','COMPRA'=>'Compra','INTERCAMBIO'=>'Intercambio','DONACION'=>'Donación'] as $key => $label)
                    <button type="button" onclick="updateQuery('tipo_operacion','{{ $key }}')" 
                        class="chip" 
                        style="@if(request('tipo_operacion')==$key) font-weight:700; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; border-color: var(--primary); @endif">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="filters-group">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" onchange="updateQuery('categoria_id', this.value)">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @if(request('categoria_id') == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="filters-group">
            <label for="estado">Estado</label>
            <select id="estado" onchange="updateQuery('estado', this.value)">
                <option value="">Todos</option>
                <option value="DISPONIBLE" @if(request('estado')=='DISPONIBLE') selected @endif>Disponible</option>
                <option value="RESERVADO" @if(request('estado')=='RESERVADO') selected @endif>Reservado</option>
                <option value="CERRADO" @if(request('estado')=='CERRADO') selected @endif>Cerrado</option>
            </select>
        </div>

        <hr style="margin:1.5rem 0; border:none; border-top:2px solid var(--border);">

        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
            <h2 style="margin: 0;">Publicar</h2>
        </div>
        <small style="display: block; margin-bottom: 1rem;">Comparte tus artículos con la comunidad estudiantil.</small>

        <button onclick="window.location.href='{{ route('market.create') }}'" class="btn-primary" style="width:100%; margin-bottom:0.5rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.5rem;">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nueva Publicación
        </button>

        <button onclick="clearFilters()" class="btn-outline" style="width:100%;">
            Limpiar Filtros
        </button>

        <hr style="margin:1.5rem 0; border:none; border-top:2px solid var(--border);">

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <h3 style="margin: 0; font-size: 1rem; color: var(--primary-dark);">Información útil</h3>
        </div>
        <ul style="list-style: none; padding: 0; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
            <li style="margin-bottom: 0.75rem;"><strong>Tip:</strong> Añade fotos claras para vender más rápido</li>
            <li style="margin-bottom: 0.75rem;"><strong>Seguridad:</strong> Verifica siempre a los compradores</li>
            <li style="margin-bottom: 0.75rem;"><strong>Reputación:</strong> Las buenas reseñas te ayudan a vender</li>
        </ul>
    </aside>

    {{-- Sección principal mejorada --}}
    <section>
        {{-- Tabs para Mis Publicaciones y Comunidad --}}
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('comunidad')" id="tab-comunidad">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.5rem; vertical-align: middle;">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Comunidad
                <span class="count">{{ \App\Models\Anuncio::where('user_id', '!=', auth()->id())->count() }}</span>
            </button>
            <button class="tab-btn" onclick="switchTab('mis-publicaciones')" id="tab-mis-publicaciones">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.5rem; vertical-align: middle;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Mis Publicaciones
                <span class="count">{{ auth()->user()->anuncios()->count() }}</span>
            </button>
        </div>

        {{-- Contenido de Comunidad --}}
        <div id="content-comunidad">
            <div class="cards-header">
                <div>
                    <h2>Anuncios de la Comunidad</h2>
                    <small>Descubre productos, servicios y oportunidades de intercambio entre estudiantes.</small>
                </div>
                <div>
                    <button class="btn-outline" onclick="location.reload()" title="Actualizar listado">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.25rem;">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                        </svg>
                        Actualizar
                    </button>
                </div>
            </div>

            @php($anunciosComunidad = \App\Models\Anuncio::with('categoria')->where('user_id', '!=', auth()->id())->latest()->paginate(20))
            
            @if($anunciosComunidad->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>No hay anuncios en la comunidad</h3>
                    <p>¡Sé el primero en publicar algo para la comunidad!</p>
                    <a href="{{ route('market.create') }}" class="btn-primary">Crear mi primer anuncio</a>
                </div>
            @else
                <div class="cards-grid" id="cards-comunidad">
                    @foreach($anunciosComunidad as $anuncio)
                        @php($tipo = $anuncio->tipo_operacion)
                        @php($isFavorite = auth()->user()->favoritos()->where('anuncio_id', $anuncio->id)->exists())
                        <article class="card" data-id="{{ $anuncio->id }}">
                            <div class="card-img" style="position: relative;">
                                @php($first = $anuncio->imagenes->first())
                                @if($first)
                                    <img src="{{ asset('storage/' . $first->url) }}" alt="{{ $anuncio->titulo }}"
                                        style="width:100%; height:100%; object-fit:cover; border-radius:0.75rem;">
                                @else
                                    <div style="width:100%; height:100%; background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="card-badge">
                                    @switch($tipo)
                                        @case('VENTA') Venta @break
                                        @case('COMPRA') Compra @break
                                        @case('INTERCAMBIO') Intercambio @break
                                        @case('DONACION') Donación @break
                                    @endswitch
                                </div>

                                <button type="button" 
                                    class="btn-favorite {{ $isFavorite ? 'is-favorite' : '' }}" 
                                    data-anuncio-id="{{ $anuncio->id }}"
                                    onclick="event.stopPropagation(); toggleFavorite({{ $anuncio->id }})">
                                    <span class="heart-icon">
                                        @if($isFavorite)
                                            ❤️
                                        @else
                                            🤍
                                        @endif
                                    </span>
                                </button>
                            </div>

                            <div class="card-title" title="{{ $anuncio->titulo }}">{{ Str::limit($anuncio->titulo, 45) }}</div>
                            
                            <div class="card-price">
                                @if($anuncio->tipo_operacion === 'DONACION')
                                    <span style="color: #16a34a; font-weight: 700;">🎁 Gratis</span>
                                @elseif(is_null($anuncio->precio))
                                    <span style="color: #f97316;">💬 Precio a acordar</span>
                                @else
                                    <span>💰 ${{ number_format($anuncio->precio, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            
                            <div class="card-meta">
                                <span style="display: inline-block; background: #dcfce7; color: #16a34a; padding: 0.3rem 0.6rem; border-radius: 0.4rem; font-weight: 600; font-size: 0.75rem;">
                                    @switch(strtolower($anuncio->estado))
                                        @case('disponible') ✅ Disponible @break
                                        @case('reservado') ⏳ Reservado @break
                                        @case('cerrado') ✅ Cerrado @break
                                        @default {{ $anuncio->estado }}
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
                                <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
                                    @if($anuncio->user->foto_perfil)
                                        <img src="{{ asset('storage/' . $anuncio->user->foto_perfil) }}" class="card-user-avatar" alt="{{ $anuncio->user->name }}">
                                    @else
                                        <div class="card-user-avatar-placeholder">
                                            {{ strtoupper(substr($anuncio->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    {{ $anuncio->user->name }}
                                </span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">
                                    {{ $anuncio->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($anunciosComunidad->hasPages())
                    <div style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ $anunciosComunidad->previousPageUrl() }}" 
                            class="btn-outline" 
                            style="@if($anunciosComunidad->onFirstPage()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                            ← Anterior
                        </a>
                        @for ($i = 1; $i <= $anunciosComunidad->lastPage(); $i++)
                            @if ($i == $anunciosComunidad->currentPage())
                                <button style="background: var(--primary); color: white; padding: 0.5rem 0.75rem; border-radius: 0.5rem; border: none; font-weight: 700; cursor: default;">{{ $i }}</button>
                            @else
                                <a href="{{ $anunciosComunidad->url($i) }}" class="btn-outline" style="padding: 0.5rem 0.75rem;">{{ $i }}</a>
                            @endif
                        @endfor
                        <a href="{{ $anunciosComunidad->nextPageUrl() }}" 
                            class="btn-outline" 
                            style="@if(!$anunciosComunidad->hasMorePages()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                            Siguiente →
                        </a>
                    </div>
                    <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                        Página <strong>{{ $anunciosComunidad->currentPage() }}</strong> de <strong>{{ $anunciosComunidad->lastPage() }}</strong>
                    </div>
                @endif
            @endif
        </div>

        {{-- Contenido de Mis Publicaciones --}}
        <div id="content-mis-publicaciones" style="display: none;">
            <div class="cards-header">
                <div>
                    <h2>Mis Publicaciones</h2>
                    <small>Gestiona tus anuncios publicados en el marketplace.</small>
                </div>
                <div>
                    <a href="{{ route('market.create') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.25rem;">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Nuevo Anuncio
                    </a>
                </div>
            </div>

            @php($misAnuncios = auth()->user()->anuncios()->with('categoria')->latest()->paginate(20))
            
            @if($misAnuncios->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📝</div>
                    <h3>No has publicado nada aún</h3>
                    <p>¡Empieza a vender, comprar o intercambiar con la comunidad estudiantil!</p>
                    <a href="{{ route('market.create') }}" class="btn-primary">Crear mi primer anuncio</a>
                </div>
            @else
                {{-- Stats de mis publicaciones --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>{{ auth()->user()->anuncios()->count() }}</h4>
                        <p>Total</p>
                    </div>
                    <div class="stat-card">
                        <h4>{{ auth()->user()->anuncios()->where('estado', 'DISPONIBLE')->count() }}</h4>
                        <p>Disponibles</p>
                    </div>
                    <div class="stat-card">
                        <h4>{{ auth()->user()->anuncios()->where('estado', 'RESERVADO')->count() }}</h4>
                        <p>Reservados</p>
                    </div>
                    <div class="stat-card">
                        <h4>{{ auth()->user()->anuncios()->where('estado', 'CERRADO')->count() }}</h4>
                        <p>Cerrados</p>
                    </div>
                </div>

                <div class="cards-grid" id="cards-mis-publicaciones">
                    @foreach($misAnuncios as $anuncio)
                        @php($tipo = $anuncio->tipo_operacion)
                        @php($isFavorite = auth()->user()->favoritos()->where('anuncio_id', $anuncio->id)->exists())
                        <article class="card" data-id="{{ $anuncio->id }}">
                            <div class="card-img" style="position: relative;">
                                @php($first = $anuncio->imagenes->first())
                                @if($first)
                                    <img src="{{ asset('storage/' . $first->url) }}" alt="{{ $anuncio->titulo }}"
                                        style="width:100%; height:100%; object-fit:cover; border-radius:0.75rem;">
                                @else
                                    <div style="width:100%; height:100%; background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="card-badge">
                                    @switch($tipo)
                                        @case('VENTA') Venta @break
                                        @case('COMPRA') Compra @break
                                        @case('INTERCAMBIO') Intercambio @break
                                        @case('DONACION') Donación @break
                                    @endswitch
                                </div>

                                <button type="button" 
                                    class="btn-favorite {{ $isFavorite ? 'is-favorite' : '' }}" 
                                    data-anuncio-id="{{ $anuncio->id }}"
                                    onclick="event.stopPropagation(); toggleFavorite({{ $anuncio->id }})">
                                    <span class="heart-icon">
                                        @if($isFavorite)
                                            ❤️
                                        @else
                                            🤍
                                        @endif
                                    </span>
                                </button>
                            </div>

                            <div class="card-title" title="{{ $anuncio->titulo }}">{{ Str::limit($anuncio->titulo, 45) }}</div>
                            
                            <div class="card-price">
                                @if($anuncio->tipo_operacion === 'DONACION')
                                    <span style="color: #16a34a; font-weight: 700;">🎁 Gratis</span>
                                @elseif(is_null($anuncio->precio))
                                    <span style="color: #f97316;">💬 Precio a acordar</span>
                                @else
                                    <span>💰 ${{ number_format($anuncio->precio, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            
                            <div class="card-meta">
                                <span style="display: inline-block; background: #dcfce7; color: #16a34a; padding: 0.3rem 0.6rem; border-radius: 0.4rem; font-weight: 600; font-size: 0.75rem;">
                                    @switch(strtolower($anuncio->estado))
                                        @case('disponible') ✅ Disponible @break
                                        @case('reservado') ⏳ Reservado @break
                                        @case('cerrado') ✅ Cerrado @break
                                        @default {{ $anuncio->estado }}
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
                                    {{ $anuncio->created_at->diffForHumans() }}
                                </span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">
                                    👁 {{ $anuncio->imagenes->count() }} imágenes
                                </span>
                            </div>

                            <div class="card-actions">
                                <button class="btn-card-action primary" onclick="event.stopPropagation(); window.location.href='{{ route('user.profile', auth()->user()) }}'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Ver
                                </button>
                                <form action="{{ route('anuncios.destroy', $anuncio) }}" method="POST" style="flex: 1;" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-card-action secondary" onclick="return confirm('¿Estás seguro de eliminar este anuncio?')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($misAnuncios->hasPages())
                    <div style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ $misAnuncios->previousPageUrl() }}" 
                            class="btn-outline" 
                            style="@if($misAnuncios->onFirstPage()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                            ← Anterior
                        </a>
                        @for ($i = 1; $i <= $misAnuncios->lastPage(); $i++)
                            @if ($i == $misAnuncios->currentPage())
                                <button style="background: var(--primary); color: white; padding: 0.5rem 0.75rem; border-radius: 0.5rem; border: none; font-weight: 700; cursor: default;">{{ $i }}</button>
                            @else
                                <a href="{{ $misAnuncios->url($i) }}" class="btn-outline" style="padding: 0.5rem 0.75rem;">{{ $i }}</a>
                            @endif
                        @endfor
                        <a href="{{ $misAnuncios->nextPageUrl() }}" 
                            class="btn-outline" 
                            style="@if(!$misAnuncios->hasMorePages()) opacity: 0.5; cursor: not-allowed; pointer-events: none; @endif">
                            Siguiente →
                        </a>
                    </div>
                    <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                        Página <strong>{{ $misAnuncios->currentPage() }}</strong> de <strong>{{ $misAnuncios->lastPage() }}</strong>
                    </div>
                @endif
            @endif
        </div>

        {{-- Categorías disponibles --}}
        @if($categorias->count() > 0)
            <div style="margin-top: 2.5rem;" class="panel">
                <h2 style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    Categorías Disponibles
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
        // Función para cambiar entre tabs
        function switchTab(tab) {
            // Remover clase active de todos los tabs
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            // Agregar clase active al tab seleccionado
            document.getElementById('tab-' + tab).classList.add('active');
            
            // Ocultar todos los contenidos
            document.getElementById('content-comunidad').style.display = 'none';
            document.getElementById('content-mis-publicaciones').style.display = 'none';
            
            // Mostrar el contenido seleccionado
            document.getElementById('content-' + tab).style.display = 'block';
            
            // Guardar la preferencia en localStorage
            localStorage.setItem('activeTab', tab);
        }

        // Restaurar tab activo al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const activeTab = localStorage.getItem('activeTab') || 'comunidad';
            switchTab(activeTab);
        });

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

        async function toggleFavorite(anuncioId) {
            try {
                const response = await fetch('{{ route("favorite.toggle", ":id") }}'.replace(':id', anuncioId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const button = document.querySelector(`[data-anuncio-id="${anuncioId}"]`);
                    const heartIcon = button.querySelector('.heart-icon');

                    if (data.isFavorite) {
                        button.classList.add('is-favorite');
                        heartIcon.textContent = '❤️';
                    } else {
                        button.classList.remove('is-favorite');
                        heartIcon.textContent = '🤍';
                    }

                    // Mostrar notificación
                    showNotification(data.message, 'success');
                } else {
                    showNotification('Error al guardar. Por favor intenta nuevamente.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error de conexión. Por favor intenta nuevamente.', 'error');
            }
        }

        function showNotification(message, type) {
            // Crear notificación toast
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 0.75rem;
                background: ${type === 'success' ? 'linear-gradient(135deg, #22c55e 0%, #16a34a 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'};
                color: white;
                font-weight: 600;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                z-index: 1000;
                animation: slideInUp 0.3s ease-out;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideInUp 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
    @endpush
@endsection
