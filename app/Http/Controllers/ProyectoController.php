<?php
namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Investigador;
use App\Models\LineaInvestigacion;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::with(['investigador', 'lineaInvestigacion'])->orderByDesc('id')->get();
        $investigadores = Investigador::orderBy('nombre_completo')->get();
        $lineas = LineaInvestigacion::orderBy('nombre')->get();
        return view('publico.proyectos', compact('proyectos', 'investigadores', 'lineas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:En curso,Concluido',
            'financiamiento' => 'nullable|string|max:255',
            'monto' => 'nullable|numeric',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'resultados' => 'nullable|string',
            'investigador_id' => 'nullable|exists:investigadores,id',
            'linea_investigacion_id' => 'nullable|exists:lineas_investigacion,id',
        ]);
        Proyecto::create($data);
        return back()->with('ok', 'Proyecto registrado correctamente.');
    }

    public function show(Proyecto $proyecto)
    {
        return response()->json($proyecto);
    }

    public function update(Request $request, Proyecto $proyecto)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:En curso,Concluido',
            'financiamiento' => 'nullable|string|max:255',
            'monto' => 'nullable|numeric',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'resultados' => 'nullable|string',
            'investigador_id' => 'nullable|exists:investigadores,id',
            'linea_investigacion_id' => 'nullable|exists:lineas_investigacion,id',
        ]);
        $proyecto->update($data);
        return back()->with('ok', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return back()->with('ok', 'Proyecto eliminado correctamente.');
    }
}
