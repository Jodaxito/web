@extends('layouts.app')

@section('title', 'Chat con ' . $user->name . ' - JODAXI')

@section('content')
<div style="grid-column: 1 / -1; max-width: 800px; margin: 0 auto;">
    <!-- Header del chat -->
    <div class="panel" style="margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                @if($user->foto_perfil)
                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" 
                        style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; color: var(--primary); font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <strong>{{ $user->name }}</strong>
                    <div style="color: var(--text-muted); font-size: 0.85rem;">⭐ {{ number_format($user->obtenerCalificacionPromedio(), 1) }}/5</div>
                </div>
            </div>
            <a href="{{ route('user.profile', $user->id) }}" class="btn-outline">Ver Perfil</a>
        </div>
    </div>

    <!-- Mensajes -->
    <div style="background: var(--card); border: 1px solid var(--border); border-radius: 0.75rem; padding: 1rem; height: 400px; overflow-y: auto; margin-bottom: 1rem;">
        @forelse($mensajes as $msg)
            <div style="margin-bottom: 1rem; display: flex; {{ $msg->sender_id === auth()->id() ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}">
                <div style="max-width: 70%; background: {{ $msg->sender_id === auth()->id() ? 'var(--primary)' : 'var(--border)' }}; color: {{ $msg->sender_id === auth()->id() ? 'white' : 'var(--text-main)' }}; padding: 0.75rem 1rem; border-radius: 0.5rem;">
                    <p style="margin: 0; word-break: break-word;">{{ $msg->contenido }}</p>
                    <span style="font-size: 0.75rem; opacity: 0.8;">{{ $msg->created_at->format('H:i') }}</span>
                </div>
            </div>
        @empty
            <div style="text-align: center; color: var(--text-muted); padding: 2rem;">
                Comienza a escribir para iniciar la conversación
            </div>
        @endforelse
    </div>

    <!-- Formulario de envío -->
    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <div style="display: flex; gap: 0.5rem;">
            <textarea name="contenido" placeholder="Escribe tu mensaje..." 
                style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); border-radius: 0.4rem; font-family: inherit; max-height: 100px;" 
                required></textarea>
            <button type="submit" class="btn-primary" style="align-self: flex-end;">Enviar</button>
        </div>
    </form>
</div>
@endsection
