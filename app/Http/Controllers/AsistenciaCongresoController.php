<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaCongreso;
use App\Models\Investigador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsistenciaCongresoController extends Controller
{
    public function index()
    {
        $asistencias = AsistenciaCongreso::with('investigador')->orderByDesc('fecha')->get();
        $investigadores = Investigador::orderBy('nombre_completo')->get();
        return view('privado.asistencias_congresos', compact('asistencias', 'investigadores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_congreso' => 'required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'tipo_participacion' => 'required|in:Asistente,Ponente,Cartel',
            'titulo_ponencia' => 'nullable|string|max:255',
            'constancia' => 'nullable|string|max:255',
            'constancia_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);

        if ($request->hasFile('constancia_file')) {
            $data['constancia'] = $request->file('constancia_file')->store('constancias', 'public');
        }
        unset($data['constancia_file']);

        AsistenciaCongreso::create($data);
        return back()->with('ok', 'Asistencia registrada correctamente.');
    }

    public function show(AsistenciaCongreso $asistenciaCongreso)
    {
        return response()->json($asistenciaCongreso);
    }

    public function update(Request $request, AsistenciaCongreso $asistenciaCongreso)
    {
        $data = $request->validate([
            'nombre_congreso' => 'required|string|max:255',
            'sede' => 'nullable|string|max:255',
            'fecha' => 'nullable|date',
            'tipo_participacion' => 'required|in:Asistente,Ponente,Cartel',
            'titulo_ponencia' => 'nullable|string|max:255',
            'constancia' => 'nullable|string|max:255',
            'constancia_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);

        if ($request->hasFile('constancia_file')) {
            if ($asistenciaCongreso->constancia && !str_starts_with($asistenciaCongreso->constancia, 'http')) {
                Storage::disk('public')->delete($asistenciaCongreso->constancia);
            }
            $data['constancia'] = $request->file('constancia_file')->store('constancias', 'public');
        }
        unset($data['constancia_file']);

        $asistenciaCongreso->update($data);
        return back()->with('ok', 'Asistencia actualizada correctamente.');
    }

    public function destroy(AsistenciaCongreso $asistenciaCongreso)
    {
        if ($asistenciaCongreso->constancia && !str_starts_with($asistenciaCongreso->constancia, 'http')) {
            Storage::disk('public')->delete($asistenciaCongreso->constancia);
        }
        $asistenciaCongreso->delete();
        return back()->with('ok', 'Asistencia eliminada correctamente.');
    }
}