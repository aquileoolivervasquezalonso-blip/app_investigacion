<?php
namespace App\Http\Controllers;

use App\Models\Vinculacion;
use Illuminate\Http\Request;

class VinculacionController extends Controller
{
    public function index()
    {
        $vinculaciones = Vinculacion::orderByDesc('id')->get();
        return view('publico.vinculaciones', compact('vinculaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Servicio Tecnológico,Consultoría,Convenio,Transferencia Tecnológica',
            'institucion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);
        Vinculacion::create($data);
        return back()->with('ok', 'Vinculación registrada correctamente.');
    }

    public function show(Vinculacion $vinculacion)
    {
        return response()->json($vinculacion);
    }

    public function update(Request $request, Vinculacion $vinculacion)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Servicio Tecnológico,Consultoría,Convenio,Transferencia Tecnológica',
            'institucion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);
        $vinculacion->update($data);
        return back()->with('ok', 'Vinculación actualizada correctamente.');
    }

    public function destroy(Vinculacion $vinculacion)
    {
        $vinculacion->delete();
        return back()->with('ok', 'Vinculación eliminada correctamente.');
    }
}
