<?php
namespace App\Http\Controllers;

use App\Models\ConvocatoriaCongreso;
use Illuminate\Http\Request;

class ConvocatoriaCongresoController extends Controller
{
    public function index()
    {
        $convocatorias = ConvocatoriaCongreso::orderByDesc('fecha_limite')->get();
        return view('publico.convocatorias_congresos', compact('convocatorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'estado' => 'required|in:Abierta,Cerrada',
            'enlace' => 'nullable|string|max:255',
        ]);
        ConvocatoriaCongreso::create($data);
        return back()->with('ok', 'Convocatoria registrada correctamente.');
    }

    public function show(ConvocatoriaCongreso $convocatoriaCongreso)
    {
        return response()->json($convocatoriaCongreso);
    }

    public function update(Request $request, ConvocatoriaCongreso $convocatoriaCongreso)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'estado' => 'required|in:Abierta,Cerrada',
            'enlace' => 'nullable|string|max:255',
        ]);
        $convocatoriaCongreso->update($data);
        return back()->with('ok', 'Convocatoria actualizada correctamente.');
    }

    public function destroy(ConvocatoriaCongreso $convocatoriaCongreso)
    {
        $convocatoriaCongreso->delete();
        return back()->with('ok', 'Convocatoria eliminada correctamente.');
    }
}
