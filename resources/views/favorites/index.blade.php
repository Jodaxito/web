@extends('layouts.app')

@section('title', 'Mis Favoritos - JODAXI')

@push('styles')
<style>
    /* Estilos mejorados para favoritos */
    .favorites-header {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: white;
        padding: 2rem;
        border-radius: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .favorites-header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 2rem;
        font-weight: 800;
    }
    
    .favorites-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .favorites-header .count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 999px;
        margin-top: 1rem;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--card);
        border-radius: 1.5rem;
        border: 2px dashed var(--border);
    }
    
    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }
    
    .btn-explore {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 999px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-lg);
    }
    
    .btn-explore:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(34, 197, 94, 0.4);
    }
    
    /* Tarjetas de favoritos mejoradas */
    .card {
        position: relative;
        overflow: visible;
    }
    
    .card-img {
        position: relative;
    }
    
    .btn-remove-favorite {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.4);
        font-size: 1.2rem;
        z-index: 10;
    }
    
    .btn-remove-favorite:hover {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 0 6px 16px rgba(244, 63, 94, 0.5);
    }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
        margin-top: 0.5rem;
    }
    
    .seller-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .seller-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-light);
    }
    
    .seller-avatar-placeholder {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.85rem;
        font-weight: 700;
    }
    
    .card-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    
    .btn-action {
        flex: 1;
        padding: 0.6rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        border: none;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-action.primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .btn-action.secondary {
        background: var(--bg);
        color: var(--text-muted);
        border: 2px solid var(--border);
    }
    
    .btn-action.secondary:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    /* Toast notification */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        color: white;
        font-weight: 600;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        z-index: 1000;
        animation: slideInUp 0.3s ease-out;
    }
    
    .toast.success {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }
    
    .toast.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    /* Quick stats */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .quick-stat {
        background: var(--card);
        padding: 1.25rem;
        border-radius: 1rem;
        text-align: center;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    .quick-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .quick-stat h4 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0;
    }
    
    .quick-stat p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0.25rem 0 0 0;
    }
    
    /* Paginación mejorada */
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div style="grid-column: 1 / -1;">
    {{-- Header mejorado --}}
    <div class="favorites-header">
        <h1>❤️ Mis Favoritos</h1>
        <p>Guarda los anuncios que te interesen para poder encontrarlos fácilmente después.</p>
        <div class="count">
            <span style="margin-right: 0.5rem;">📌</span>
            {{ $favoritos->total() }} anuncios guardados
        </div>
    </div>

    @if($favoritos->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">💔</div>
            <h3>No tienes favoritos guardados</h3>
            <p>Explora los anuncios de la comunidad y guarda los que más te interesen haciendo clic en el corazón.</p>
            <a href="{{ route('market.index') }}" class="btn-explore">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Explorar Anuncios
            </a>
        </div>
    @else
        {{-- Quick stats --}}
        <div class="quick-stats">
            <div class="quick-stat">
                <h4>{{ $favoritos->total() }}</h4>
                <p>Total guardados</p>
            </div>
            <div class="quick-stat">
                <h4>{{ $favoritos->where('anuncio.tipo_operacion', 'VENTA')->count() }}</h4>
                <p>En venta</p>
            </div>
            <div class="quick-stat">
                <h4>{{ $favoritos->where('anuncio.tipo_operacion', 'DONACION')->count() }}</h4>
                <p>Donaciones</p>
            </div>
            <div class="quick-stat">
                <h4>{{ $favoritos->where('anuncio.tipo_operacion', 'INTERCAMBIO')->count() }}</h4>
                <p>Intercambios</p>
            </div>
        </div>

        <div class="cards-grid">
            @foreach($favoritos as $fav)
                @php($anuncio = $fav->anuncio)
                @php($tipo = $anuncio->tipo_operacion)
                <article class="card">
                    <div class="card-img">
                        @if($anuncio->imagenes->first())
                            <img src="{{ asset('storage/' . $anuncio->imagenes->first()->url) }}" 
                                style="width:100%; height:160px; object-fit:cover; border-radius:0.75rem;">
                        @else
                            <div style="width:100%; height:160px; background: linear-gradient(135deg, #f0fdf4 0%, #dbeafe 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="card-badge">
                            @switch($tipo)
                                @case('VENTA') 💰 Venta @break
                                @case('COMPRA') 🛒 Compra @break
                                @case('INTERCAMBIO') 🔄 Intercambio @break
                                @case('DONACION') 🎁 Donación @break
                            @endswitch
                        </div>

                        <button type="button" 
                            class="btn-remove-favorite" 
                            onclick="removeFavorite({{ $anuncio->id }})"
                            title="Quitar de favoritos">
                            ✕
                        </button>
                    </div>

                    <div class="card-title" style="margin-top: 0.75rem;">{{ Str::limit($anuncio->titulo, 40) }}</div>
                    
                    <div class="card-price">
                        @if($anuncio->tipo_operacion === 'DONACION')
                            <span style="color: #16a34a; font-weight: 700;">🎁 Gratis</span>
                        @elseif(is_null($anuncio->precio))
                            <span style="color: #f97316;">💬 Precio a acordar</span>
                        @else
                            <span>💰 ${{ number_format($anuncio->precio, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    
                    <div class="card-meta" style="font-size: 0.85rem; margin: 0.5rem 0;">
                        📁 {{ optional($anuncio->categoria)->nombre ?? 'Sin categoría' }} 
                        @if($anuncio->ubicacion)
                            • 📍 {{ Str::limit($anuncio->ubicacion, 20) }}
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

                    <div class="card-footer">
                        <div class="seller-info">
                            @if($anuncio->user->foto_perfil)
                                <img src="{{ asset('storage/' . $anuncio->user->foto_perfil) }}" class="seller-avatar" alt="{{ $anuncio->user->name }}">
                            @else
                                <div class="seller-avatar-placeholder">
                                    {{ strtoupper(substr($anuncio->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span style="font-size: 0.85rem; color: var(--text-muted);">
                                {{ $anuncio->user->name }}
                            </span>
                        </div>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            {{ $anuncio->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('user.profile', $anuncio->user_id) }}" class="btn-action secondary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Ver Vendedor
                        </a>
                        <form action="{{ route('favorite.toggle', $anuncio->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn-action primary" style="width: 100%;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                Ver Detalle
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($favoritos->hasPages())
            <div class="pagination-container">
                {{ $favoritos->links() }}
            </div>
        @endif
    @endif
</div>

@push('scripts')
<script>
    async function removeFavorite(anuncioId) {
        if (!confirm('¿Estás seguro de quitar este anuncio de tus favoritos?')) {
            return;
        }

        try {
            const response = await fetch(`/anuncio/${anuncioId}/favorito`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                showToast(data.message, 'success');
                
                // Remover la tarjeta del DOM con animación
                const card = document.querySelector(`article:has([onclick="removeFavorite(${anuncioId})"])`);
                if (card) {
                    card.style.animation = 'slideInUp 0.3s ease-out reverse';
                    setTimeout(() => {
                        card.remove();
                        // Recargar la página para actualizar los contadores
                        location.reload();
                    }, 300);
                }
            } else {
                showToast('Error al quitar de favoritos. Por favor intenta nuevamente.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Error de conexión. Por favor intenta nuevamente.', 'error');
        }
    }

    function showToast(message, type) {
        const existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideInUp 0.3s ease-out reverse';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>
@endpush
@endsection
