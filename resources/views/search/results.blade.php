@extends('layouts.app')

@section('title', 'Buscar Anuncios - JODAXI')

@section('content')
<div style="grid-column: 1 / -1;">
    <form action="{{ route('search') }}" method="GET" class="panel" style="margin-bottom: 1.5rem;">
        <h2>Búsqueda Avanzada</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label>Buscar por palabra clave</label>
                <input type="text" name="q" placeholder="Título o descripción..." value="{{ request('q') }}">
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <select name="categoria_id">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @if(request('categoria_id') == $cat->id) selected @endif>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tipo de operación</label>
                <select name="tipo_operacion">
                    <option value="">Todos</option>
                    <option value="VENTA" @if(request('tipo_operacion') == 'VENTA') selected @endif>Venta</option>
                    <option value="COMPRA" @if(request('tipo_operacion') == 'COMPRA') selected @endif>Compra</option>
                    <option value="INTERCAMBIO" @if(request('tipo_operacion') == 'INTERCAMBIO') selected @endif>Intercambio</option>
                    <option value="DONACION" @if(request('tipo_operacion') == 'DONACION') selected @endif>Donación</option>
                </select>
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
                    <option value="DISPONIBLE" @if(request('estado') == 'DISPONIBLE') selected @endif>Disponible</option>
                    <option value="RESERVADO" @if(request('estado') == 'RESERVADO') selected @endif>Reservado</option>
                    <option value="CERRADO" @if(request('estado') == 'CERRADO') selected @endif>Cerrado</option>
                </select>
            </div>

            <div class="form-group">
                <label>Precio Mínimo</label>
                <input type="number" name="precio_min" placeholder="0" value="{{ request('precio_min') }}" step="0.01">
            </div>

            <div class="form-group">
                <label>Precio Máximo</label>
                <input type="number" name="precio_max" placeholder="Sin límite" value="{{ request('precio_max') }}" step="0.01">
            </div>

            <div class="form-group">
                <label>Ordenar por</label>
                <select name="ordenamiento">
                    <option value="reciente" @if(request('ordenamiento') == 'reciente') selected @endif>Más reciente</option>
                    <option value="antiguo" @if(request('ordenamiento') == 'antiguo') selected @endif>Más antiguo</option>
                    <option value="precio_asc" @if(request('ordenamiento') == 'precio_asc') selected @endif>Precio menor</option>
                    <option value="precio_desc" @if(request('ordenamiento') == 'precio_desc') selected @endif>Precio mayor</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 1rem;">
            <button type="submit" class="btn-primary">Buscar</button>
            <a href="{{ route('search') }}" class="btn-outline">Limpiar filtros</a>
        </div>
    </form>

    @if($anuncios->isEmpty())
        <div class="empty">No se encontraron anuncios. Intenta con otros filtros.</div>
    @else
        <h3>Resultados: {{ $anuncios->total() }} anuncios encontrados</h3>
        <div class="cards-grid">
            @foreach($anuncios as $anuncio)
                @php($tipo = $anuncio->tipo_operacion)
                <article class="card">
                    <div class="card-img">
                        @php($first = $anuncio->imagenes->first())
                        @if($first)
                            <img src="{{ asset('storage/' . $first->url) }}" 
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

        <div style="margin-top: 1.5rem;">
            {{ $anuncios->links() }}
        </div>
    @endif
</div>
@endsection
