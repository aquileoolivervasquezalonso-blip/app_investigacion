<?php
namespace App\Http\Controllers;

use App\Models\Investigador;
use App\Models\CuerpoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvestigadorController extends Controller
{
    public function index()
    {
        $investigadores = Investigador::with('cuerpoAcademico')->orderBy('nombre_completo')->get();
        $cuerpos = CuerpoAcademico::orderBy('nombre')->get();
        return view('publico.investigadores', compact('investigadores', 'cuerpos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'cv' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('investigadores', 'public');
        }

        Investigador::create($data);
        return back()->with('ok', 'Investigador registrado correctamente.');
    }

    public function show(Investigador $investigador)
    {
        return response()->json($investigador);
    }

    public function update(Request $request, Investigador $investigador)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'grado_academico' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'cv' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
        ]);

        if ($request->hasFile('foto')) {
            // borrar foto anterior si existe
            if ($investigador->foto) {
                Storage::disk('public')->delete($investigador->foto);
            }
            $data['foto'] = $request->file('foto')->store('investigadores', 'public');
        } else {
            // si no suben nueva foto, conservar la actual
            unset($data['foto']);
        }

        $investigador->update($data);
        return back()->with('ok', 'Investigador actualizado correctamente.');
    }

    public function destroy(Investigador $investigador)
    {
        if ($investigador->foto) {
            Storage::disk('public')->delete($investigador->foto);
        }
        $investigador->delete();
        return back()->with('ok', 'Investigador eliminado correctamente.');
    }
}