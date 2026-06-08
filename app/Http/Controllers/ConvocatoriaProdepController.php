<?php

namespace App\Http\Controllers;

use App\Models\ConvocatoriaProdep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvocatoriaProdepController extends Controller
{
    public function index()
    {
        $convocatorias = ConvocatoriaProdep::orderByDesc('fecha_limite')->get();
        return view('privado.convocatorias_prodep', compact('convocatorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_publicacion' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'estado' => 'required|in:Abierta,Cerrada',
            'archivo' => 'nullable|string|max:255',
            'archivo_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'enlace' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('archivo_file')) {
            $data['archivo'] = $request->file('archivo_file')->store('prodep', 'public');
        }
        unset($data['archivo_file']);

        ConvocatoriaProdep::create($data);
        return back()->with('ok', 'Convocatoria PRODEP registrada correctamente.');
    }

    public function show(ConvocatoriaProdep $convocatoriaProdep)
    {
        return response()->json($convocatoriaProdep);
    }

    public function update(Request $request, ConvocatoriaProdep $convocatoriaProdep)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_publicacion' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'estado' => 'required|in:Abierta,Cerrada',
            'archivo' => 'nullable|string|max:255',
            'archivo_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'enlace' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('archivo_file')) {
            if ($convocatoriaProdep->archivo && !str_starts_with($convocatoriaProdep->archivo, 'http')) {
                Storage::disk('public')->delete($convocatoriaProdep->archivo);
            }
            $data['archivo'] = $request->file('archivo_file')->store('prodep', 'public');
        }
        unset($data['archivo_file']);

        $convocatoriaProdep->update($data);
        return back()->with('ok', 'Convocatoria PRODEP actualizada correctamente.');
    }

    public function destroy(ConvocatoriaProdep $convocatoriaProdep)
    {
        if ($convocatoriaProdep->archivo && !str_starts_with($convocatoriaProdep->archivo, 'http')) {
            Storage::disk('public')->delete($convocatoriaProdep->archivo);
        }
        $convocatoriaProdep->delete();
        return back()->with('ok', 'Convocatoria PRODEP eliminada correctamente.');
    }
}