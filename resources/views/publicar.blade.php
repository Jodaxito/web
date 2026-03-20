@extends('layouts.app')

@section('title', 'Publicar - JODAXI')

@section('content')
<div class="publish-container">
    <h1>Publicar anuncio</h1>
    <p class="sub">Crea un nuevo anuncio de venta, compra, intercambio o donación dentro de la comunidad universitaria.</p>

    <div class="card publicar-card">
        <form action="{{ route('anuncios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @if(old('categoria_id') == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="titulo">Título del anuncio</label>
                <input id="titulo" name="titulo" type="text" required placeholder="Ej. Libro de cálculo I" value="{{ old('titulo') }}">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required placeholder="Estado, detalles, forma de entrega...">{{ old('descripcion') }}</textarea>
            </div>
            <div class="form-group">
                <label for="tipo_operacion">Tipo de operación</label>
                <select id="tipo_operacion" name="tipo_operacion" required>
                    <option value="VENTA" @if(old('tipo_operacion')=='VENTA') selected @endif>Venta</option>
                    <option value="COMPRA" @if(old('tipo_operacion')=='COMPRA') selected @endif>Compra</option>
                    <option value="INTERCAMBIO" @if(old('tipo_operacion')=='INTERCAMBIO') selected @endif>Intercambio</option>
                    <option value="DONACION" @if(old('tipo_operacion')=='DONACION') selected @endif>Donación</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio">Precio (opcional)</label>
                <input id="precio" name="precio" type="number" step="0.01" placeholder="0.00" value="{{ old('precio') }}">
            </div>
            <div class="form-group">
                <label>Imágenes (puedes seleccionar varias)</label>
                <input type="file" name="imagenes[]" multiple>
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación dentro del campus</label>
                <input id="ubicacion" name="ubicacion" type="text" placeholder="Ej. Biblioteca central" value="{{ old('ubicacion') }}">
            </div>
            <button type="submit" class="btn-primary">Publicar anuncio</button>
        </form>
    </div>
</div>

<style>
    .publish-container {
        grid-column: 1 / -1;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .publicar-card {
        width: 100%;
        max-width: none;
    }
    .sub {
        color: var(--text-muted);
        margin-bottom: 2rem;
    }
</style>
@endsection
