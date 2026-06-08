<?php

namespace App\Http\Controllers;

use App\Models\PlanTrabajo;
use App\Models\Investigador;
use Illuminate\Http\Request;

class PlanTrabajoController extends Controller
{
    public function index()
    {
        $planes = PlanTrabajo::with('investigador')->orderByDesc('anio')->get();
        $investigadores = Investigador::orderBy('nombre_completo')->get();
        return view('privado.planes_trabajo', compact('planes', 'investigadores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Anual,Individual',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'objetivos' => 'nullable|string',
            'actividades' => 'nullable|string',
            'metas' => 'nullable|string',
            'estado' => 'required|in:Borrador,Enviado,Aprobado',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);
        PlanTrabajo::create($data);
        return back()->with('ok', 'Plan de trabajo registrado correctamente.');
    }

    public function show(PlanTrabajo $planTrabajo)
    {
        return response()->json($planTrabajo);
    }

    public function update(Request $request, PlanTrabajo $planTrabajo)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Anual,Individual',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'objetivos' => 'nullable|string',
            'actividades' => 'nullable|string',
            'metas' => 'nullable|string',
            'estado' => 'required|in:Borrador,Enviado,Aprobado',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);
        $planTrabajo->update($data);
        return back()->with('ok', 'Plan de trabajo actualizado correctamente.');
    }

    public function destroy(PlanTrabajo $planTrabajo)
    {
        $planTrabajo->delete();
        return back()->with('ok', 'Plan de trabajo eliminado correctamente.');
    }
}
