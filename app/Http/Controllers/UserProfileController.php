<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $resenas = $user->resenasPara()
            ->with('reviewer')
            ->latest()
            ->paginate(10);

        $anuncios = $user->anuncios()
            ->with(['categoria', 'imagenes'])
            ->where('estado', 'DISPONIBLE')
            ->latest()
            ->paginate(12);

        $calificacionPromedio = $user->obtenerCalificacionPromedio();
        $totalResenas = $user->resenasPara()->count();
        $totalVentas = $user->obtenerTotalVentas();

        return view('users.profile', compact(
            'user',
            'resenas',
            'anuncios',
            'calificacionPromedio',
            'totalResenas',
            'totalVentas'
        ));
    }

    public function edit()
    {
        return view('users.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];

        // Validar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $data = $request->only(['name', 'bio', 'telefono']);

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('perfiles', 'public');
            $data['foto_perfil'] = $path;
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $user->refresh();

        return redirect()->route('user.profile', $user->id)
            ->with('success', 'Perfil actualizado correctamente');
    }
}
