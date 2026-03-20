@extends('layouts.app')

@section('title', 'Reportar Anuncio - JODAXI')

@section('content')
<div style="grid-column: 1 / -1; max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h1>Reportar Anuncio Inapropiado</h1>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Ayúdanos a mantener JODAXI seguro reportando contenido inapropiado.
        </p>

        <form action="{{ route('report.store', $anuncio->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label><strong>Anuncio:</strong></label>
                <div style="padding: 1rem; background: var(--border); border-radius: 0.4rem; margin-bottom: 0.5rem;">
                    {{ $anuncio->titulo }}
                </div>
            </div>

            <div class="form-group">
                <label for="razon"><strong>Razón del reporte*</strong></label>
                <select id="razon" name="razon" required>
                    <option value="">Selecciona una razón</option>
                    <option value="Contenido inapropiado">Contenido inapropiado</option>
                    <option value="Fraude o estafa">Fraude o estafa</option>
                    <option value="Producto falsificado">Producto falsificado</option>
                    <option value="Ofensivo o abusivo">Ofensivo o abusivo</option>
                    <option value="Información falsa">Información falsa</option>
                    <option value="Precio inflado">Precio inflado</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion"><strong>Descripción del problema*</strong></label>
                <textarea id="descripcion" name="descripcion" required 
                    placeholder="Cuéntanos por qué reportas este anuncio..."
                    style="min-height: 150px;"></textarea>
            </div>

            <div style="background: var(--border); padding: 1rem; border-radius: 0.4rem; margin-bottom: 1rem; font-size: 0.9rem;">
                <strong>Nota:</strong> Los reportes falsos pueden resultar en la restricción de tu cuenta. 
                Revisa nuestras normas comunitarias antes de reportar.
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn-primary">Enviar Reporte</button>
                <a href="javascript:history.back()" class="btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
