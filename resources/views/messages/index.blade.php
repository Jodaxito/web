@extends('layouts.app')

@section('title', 'Mensajes - JODAXI')

@section('content')
<div style="grid-column: 1 / -1;">
    <h1>Mis Mensajes</h1>
    
    @if($conversaciones->isEmpty())
        <div class="empty">Aún no tienes conversaciones. ¡Comienza a comunicarte con otros usuarios!</div>
    @else
        <div style="display: grid; gap: 1rem;">
            @foreach($conversaciones as $msg)
                @php
                    $otroUsuario = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender;
                @endphp
                <a href="{{ route('messages.show', $otroUsuario->id) }}" 
                   style="display: block; padding: 1rem; background: var(--card); border: 1px solid var(--border); border-radius: 0.75rem; text-decoration: none; color: inherit; transition: all 0.3s;">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div style="display: flex; gap: 1rem; align-items: start; flex: 1;">
                            @if($otroUsuario->foto_perfil)
                                <img src="{{ asset('storage/' . $otroUsuario->foto_perfil) }}" 
                                    style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 700;">
                                    {{ strtoupper(substr($otroUsuario->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong style="display: block;">{{ $otroUsuario->name }}</strong>
                                @if($msg->anuncio)
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">Re: {{ $msg->anuncio->titulo }}</span>
                                @endif
                            </div>
                        </div>
                        <span style="color: var(--text-muted); font-size: 0.85rem; white-space: nowrap;">{{ $msg->updated_at->format('d M') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
