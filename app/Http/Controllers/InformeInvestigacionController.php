<?php

namespace App\Http\Controllers;

use App\Models\InformeInvestigacion;
use App\Models\Investigador;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformeInvestigacionController extends Controller
{
    public function index()
    {
        $informes = InformeInvestigacion::with(['investigador', 'proyecto'])->orderByDesc('anio')->get();
        $investigadores = Investigador::orderBy('nombre_completo')->get();
        $proyectos = Proyecto::orderBy('titulo')->get();
        return view('privado.informes_investigacion', compact('informes', 'investigadores', 'proyectos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'archivo' => 'nullable|string|max:255',
            'archivo_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'investigador_id' => 'nullable|exists:investigadores,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
        ]);

        if ($request->hasFile('archivo_file')) {
            $data['archivo'] = $request->file('archivo_file')->store('informes', 'public');
        }
        unset($data['archivo_file']);

        InformeInvestigacion::create($data);
        return back()->with('ok', 'Informe registrado correctamente.');
    }

    public function show(InformeInvestigacion $informeInvestigacion)
    {
        return response()->json($informeInvestigacion);
    }

    public function update(Request $request, InformeInvestigacion $informeInvestigacion)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'archivo' => 'nullable|string|max:255',
            'archivo_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'investigador_id' => 'nullable|exists:investigadores,id',
            'proyecto_id' => 'nullable|exists:proyectos,id',
        ]);

        if ($request->hasFile('archivo_file')) {
            // si el archivo anterior era un archivo subido (no URL externa), bórralo
            if ($informeInvestigacion->archivo && !str_starts_with($informeInvestigacion->archivo, 'http')) {
                Storage::disk('public')->delete($informeInvestigacion->archivo);
            }
            $data['archivo'] = $request->file('archivo_file')->store('informes', 'public');
        }
        unset($data['archivo_file']);

        $informeInvestigacion->update($data);
        return back()->with('ok', 'Informe actualizado correctamente.');
    }

    public function destroy(InformeInvestigacion $informeInvestigacion)
    {
        if ($informeInvestigacion->archivo && !str_starts_with($informeInvestigacion->archivo, 'http')) {
            Storage::disk('public')->delete($informeInvestigacion->archivo);
        }
        $informeInvestigacion->delete();
        return back()->with('ok', 'Informe eliminado correctamente.');
    }
}