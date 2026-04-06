<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AnuncioController extends Controller
{
    public function index(Request $request)
    {
        $query = Anuncio::with('categoria')->filter($request->only([ 'tipo_operacion', 'categoria_id', 'estado' ]));

        // paginate results for the HTML view (JSON will ignore pagination)
        $anuncios = $request->wantsJson() ? $query->get() : $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($anuncios);
        }

        // serving HTML view
        $categorias = Categoria::all();
        return view('market', compact('categorias', 'anuncios'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('publicar', compact('categorias'));
    }

    public function show(Anuncio $anuncio)
    {
        return response()->json($anuncio);
    }

    public function store(Request $request)
    {
        // validation matches the column names used by the model
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_operacion' => 'required|in:COMPRA,VENTA,INTERCAMBIO,DONACION',
            'precio' => 'nullable|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagenes.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $datos = $request->only([
            'categoria_id',
            'titulo',
            'descripcion',
            'tipo_operacion',
            'precio',
            'ubicacion',
        ]);
        
        // Asignar automáticamente el user_id del usuario autenticado
        $datos['user_id'] = auth()->id();

        // default estado when creating a new anuncio
        $datos['estado'] = 'DISPONIBLE';

        $anuncio = Anuncio::create($datos);

        // handle one or more uploaded images
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store('anuncios', 'public');
                $anuncio->imagenes()->create(['url' => $path]);
            }
        }

        return redirect('/market')->with('success', 'Anuncio publicado correctamente');
    }


    public function update(Request $request, Anuncio $anuncio)
    {
        // Verificar que el usuario sea dueño del anuncio
        if ($anuncio->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este anuncio');
        }

        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'tipo_operacion' => 'sometimes|required|in:COMPRA,VENTA,INTERCAMBIO,DONACION',
            'precio' => 'nullable|numeric|min:0',
            'estado' => 'nullable|in:DISPONIBLE,RESERVADO,CERRADO',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $anuncio->update($data);

        return response()->json($anuncio);
    }

    public function destroy(Anuncio $anuncio)
    {
        // Verificar que el usuario sea dueño del anuncio
        if ($anuncio->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar este anuncio');
        }
        
        $anuncio->delete();

        return response()->json(['message' => 'Anuncio eliminado correctamente']);
    }

    /**
     * Mostrar las publicaciones del usuario autenticado
     */
    public function misPublicaciones(Request $request)
    {
        $query = Anuncio::with('categoria')
            ->where('user_id', auth()->id())
            ->filter($request->only(['tipo_operacion', 'categoria_id', 'estado']));

        $anuncios = $request->wantsJson() ? $query->get() : $query->paginate(20);
        $categorias = Categoria::all();

        if ($request->wantsJson()) {
            return response()->json($anuncios);
        }

        return view('market', [
            'anuncios' => $anuncios,
            'categorias' => $categorias,
            'misPublicaciones' => true
        ]);
    }

    /**
     * Mostrar publicaciones de otros usuarios
     */
    public function comunidad(Request $request)
    {
        $query = Anuncio::with('categoria')
            ->where('user_id', '!=', auth()->id())
            ->filter($request->only(['tipo_operacion', 'categoria_id', 'estado']));

        $anuncios = $request->wantsJson() ? $query->get() : $query->paginate(20);
        $categorias = Categoria::all();

        if ($request->wantsJson()) {
            return response()->json($anuncios);
        }

        return view('market', [
            'anuncios' => $anuncios,
            'categorias' => $categorias,
            'misPublicaciones' => false
        ]);
    }
}
