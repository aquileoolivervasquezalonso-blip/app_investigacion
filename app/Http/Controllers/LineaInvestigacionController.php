<?php
namespace App\Http\Controllers;

use App\Models\LineaInvestigacion;
use App\Models\CuerpoAcademico;
use Illuminate\Http\Request;

class LineaInvestigacionController extends Controller
{
    public function index()
    {
        $lineas = LineaInvestigacion::with('cuerpoAcademico')->orderBy('nombre')->get();
        $cuerpos = CuerpoAcademico::orderBy('nombre')->get();
        return view('publico.lineas_investigacion', compact('lineas', 'cuerpos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
        ]);
        LineaInvestigacion::create($data);
        return back()->with('ok', 'Línea de investigación registrada correctamente.');
    }

    public function show(LineaInvestigacion $lineaInvestigacion)
    {
        return response()->json($lineaInvestigacion);
    }

    public function update(Request $request, LineaInvestigacion $lineaInvestigacion)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
        ]);
        $lineaInvestigacion->update($data);
        return back()->with('ok', 'Línea de investigación actualizada correctamente.');
    }

    public function destroy(LineaInvestigacion $lineaInvestigacion)
    {
        $lineaInvestigacion->delete();
        return back()->with('ok', 'Línea de investigación eliminada correctamente.');
    }
}
