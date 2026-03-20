<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::all());
    }

    public function show(Categoria $categoria)
    {
        return response()->json($categoria);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $categoria = Categoria::create($data);

        if ($request->wantsJson()) {
            return response()->json($categoria, 201);
        }

        return redirect('/market')->with('success', 'Categoría creada correctamente');
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $categoria->update($data);

        return response()->json($categoria);
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}
