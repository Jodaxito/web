<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Anuncio;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Anuncio $anuncio)
    {
        return view('reports.create', compact('anuncio'));
    }

    public function store(Request $request, Anuncio $anuncio)
    {
        $request->validate([
            'razon' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500'
        ]);

        Report::create([
            'user_id' => auth()->id(),
            'anuncio_id' => $anuncio->id,
            'razon' => $request->razon,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('market.index')
            ->with('success', 'Reporte enviado. Nuestro equipo lo revisará');
    }

    public function admin()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $reportes = Report::with(['user', 'anuncio.user'])
            ->orderBy('estado')
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reportes'));
    }

    public function updateStatus(Report $report, Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $report->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado');
    }
}
