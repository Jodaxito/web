<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Anuncio::with(['categoria', 'imagenes', 'user']);

        // Búsqueda por texto
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($q_builder) use ($q) {
                $q_builder->where('titulo', 'like', "%$q%")
                    ->orWhere('descripcion', 'like', "%$q%");
            });
        }

        // Filtros existentes
        if ($request->filled('tipo_operacion')) {
            $query->where('tipo_operacion', $request->tipo_operacion);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtros de precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Ordenamiento
        $ordenamiento = $request->ordenamiento ?? 'reciente';
        switch ($ordenamiento) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'antiguo':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        $anuncios = $query->paginate(20);
        $categorias = Categoria::all();

        return view('search.results', compact('anuncios', 'categorias'));
    }

    public function autocomplete(Request $request)
    {
        if (!$request->filled('q')) {
            return response()->json([]);
        }

        $resultados = Anuncio::where('titulo', 'like', "%{$request->q}%")
            ->select('id', 'titulo')
            ->distinct()
            ->limit(10)
            ->get();

        return response()->json($resultados);
    }
}
