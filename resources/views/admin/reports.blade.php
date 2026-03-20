@extends('layouts.app')

@section('title', 'Panel de Reportes - JODAXI Admin')

@section('content')
<div style="grid-column: 1 / -1;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1>Panel de Reportes</h1>
            <span style="background: var(--primary); color: white; padding: 0.5rem 1rem; border-radius: 0.4rem; font-weight: bold;">
                {{ $reports->total() }} reportes
            </span>
        </div>

        @if($reports->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                    <thead>
                        <tr style="background: var(--border);">
                            <th style="padding: 1rem; text-align: left;">ID</th>
                            <th style="padding: 1rem; text-align: left;">Reportado por</th>
                            <th style="padding: 1rem; text-align: left;">Anuncio</th>
                            <th style="padding: 1rem; text-align: left;">Razón</th>
                            <th style="padding: 1rem; text-align: left;">Descripción</th>
                            <th style="padding: 1rem; text-align: left;">Fecha</th>
                            <th style="padding: 1rem; text-align: left;">Estado</th>
                            <th style="padding: 1rem; text-align: center;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 1rem;">#{{ $report->id }}</td>
                                <td style="padding: 1rem;">
                                    <a href="{{ route('user.profile', $report->user) }}" 
                                        style="color: var(--primary); text-decoration: none;">
                                        {{ $report->user->name }}
                                    </a>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($report->anuncio)
                                        <a href="{{ route('anuncio.show', $report->anuncio) }}" 
                                            style="color: var(--primary); text-decoration: none;">
                                            {{ Str::limit($report->anuncio->titulo, 30) }}
                                        </a>
                                    @else
                                        <span style="color: var(--text-muted);">Anuncio eliminado</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="background: #fff3e0; color: #e65100; padding: 0.25rem 0.75rem; border-radius: 0.2rem; font-size: 0.85rem;">
                                        {{ $report->razon }}
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    {{ Str::limit($report->descripcion, 40) }}
                                </td>
                                <td style="padding: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="padding: 1rem;">
                                    <form action="{{ route('report.updateStatus', $report->id) }}" method="POST" style="display: flex; gap: 0.5rem;">
                                        @csrf
                                        <select name="estado" class="select-small" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;">
                                            <option value="pendiente" {{ $report->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="revisado" {{ $report->estado === 'revisado' ? 'selected' : '' }}>Revisado</option>
                                            <option value="rechazado" {{ $report->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                        </select>
                                        <button type="submit" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; background: var(--primary); color: white; border: none; border-radius: 0.2rem; cursor: pointer;">Actualizar</button>
                                    </form>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <button onclick="verDetalles({{ $report->id }})" style="padding: 0.4rem 0.8rem; background: #2196F3; color: white; border: none; border-radius: 0.2rem; cursor: pointer; font-size: 0.85rem;">
                                        Ver
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div style="margin-top: 1.5rem;">
                {{ $reports->links() }}
            </div>

        @else
            <div style="text-align: center; padding: 2rem; background: var(--border); border-radius: 0.4rem;">
                <p style="color: var(--text-muted); font-size: 1.1rem;">No hay reportes pendientes</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal para ver detalles completos -->
<div id="detallesModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 0.8rem; max-width: 500px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <h2 style="margin-top: 0;">Detalles del Reporte</h2>
        <div id="detallesContent"></div>
        <button onclick="cerrarDetalles()" style="width: 100%; padding: 0.8rem; background: var(--primary); color: white; border: none; border-radius: 0.4rem; cursor: pointer; margin-top: 1rem;">Cerrar</button>
    </div>
</div>

<script>
function verDetalles(reportId) {
    const report = @json($reports->toArray()['data'] ?? []);
    const r = report.find(x => x.id === reportId);
    if (r) {
        document.getElementById('detallesContent').innerHTML = `
            <p><strong>Reportado por:</strong> ${r.user?.name || 'Usuario'}</p>
            <p><strong>Razón:</strong> ${r.razon}</p>
            <p><strong>Descripción:</strong> ${r.descripcion}</p>
            <p><strong>Estado:</strong> <span style="background: ${r.estado === 'pendiente' ? '#ffeb3b' : r.estado === 'revisado' ? '#4caf50' : '#f44336'}; color: white; padding: 0.25rem 0.75rem; border-radius: 0.2rem;">${r.estado}</span></p>
            <p><strong>Fecha:</strong> ${new Date(r.created_at).toLocaleDateString('es-MX')}</p>
        `;
        document.getElementById('detallesModal').style.display = 'flex';
    }
}

function cerrarDetalles() {
    document.getElementById('detallesModal').style.display = 'none';
}

document.addEventListener('click', function(e) {
    const modal = document.getElementById('detallesModal');
    if (e.target === modal) {
        cerrarDetalles();
    }
});
</script>

<style>
.select-small {
    border: 1px solid var(--border);
    border-radius: 0.2rem;
    font-family: inherit;
}
</style>
@endsection
