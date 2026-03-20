<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class MessageController extends Controller
{
    /**
     * Mostrar lista de conversaciones
     */
    public function index(): View
    {
        $user = auth()->user();
        
        $conversaciones = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver', 'anuncio'])
            ->latest()
            ->get()
            ->unique(function ($item) use ($user) {
                return $item->sender_id === $user->id ? $item->receiver_id : $item->sender_id;
            });

        return view('messages.index', compact('conversaciones'));
    }

    /**
     * Mostrar conversación con un usuario específico
     */
    public function show(User $user): View
    {
        $currentUser = auth()->user();
        
        $mensajes = Message::where(function ($query) use ($currentUser, $user) {
            $query->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($currentUser, $user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $currentUser->id);
        })->with(['sender', 'receiver', 'anuncio'])
          ->orderBy('created_at', 'asc')
          ->get();

        // Marcar mensajes como leídos
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->whereNull('leido_at')
            ->update(['leido_at' => now()]);

        return view('messages.show', compact('mensajes', 'user'));
    }

    /**
     * Guardar nuevo mensaje
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id|different:sender_id',
            'anuncio_id' => 'nullable|exists:anuncios,id',
            'contenido' => 'required|string|max:1000'
        ], [
            'receiver_id.different' => 'No puedes enviarte mensajes a ti mismo',
            'contenido.required' => 'El mensaje no puede estar vacío'
        ]);

        $validated['sender_id'] = auth()->id();

        Message::create($validated);

        return back()->with('success', 'Mensaje enviado correctamente');
    }
}
