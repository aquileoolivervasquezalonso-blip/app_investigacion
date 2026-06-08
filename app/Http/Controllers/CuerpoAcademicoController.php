<?php
namespace App\Http\Controllers;

use App\Models\CuerpoAcademico;
use Illuminate\Http\Request;

class CuerpoAcademicoController extends Controller
{
    public function index()
    {
        $cuerpos = CuerpoAcademico::orderBy('nombre')->get();
        return view('publico.cuerpos_academicos', compact('cuerpos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'nullable|string|max:255',
            'grado_consolidacion' => 'required|in:En Formación,En Consolidación,Consolidado',
            'descripcion' => 'nullable|string',
        ]);
        CuerpoAcademico::create($data);
        return back()->with('ok', 'Cuerpo académico registrado correctamente.');
    }

    public function show(CuerpoAcademico $cuerpoAcademico)
    {
        return response()->json($cuerpoAcademico);
    }

    public function update(Request $request, CuerpoAcademico $cuerpoAcademico)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'nullable|string|max:255',
            'grado_consolidacion' => 'required|in:En Formación,En Consolidación,Consolidado',
            'descripcion' => 'nullable|string',
        ]);
        $cuerpoAcademico->update($data);
        return back()->with('ok', 'Cuerpo académico actualizado correctamente.');
    }

    public function destroy(CuerpoAcademico $cuerpoAcademico)
    {
        $cuerpoAcademico->delete();
        return back()->with('ok', 'Cuerpo académico eliminado correctamente.');
    }
}
