<?php
namespace App\Http\Controllers;

use App\Models\RevistaCientifica;
use Illuminate\Http\Request;

class RevistaCientificaController extends Controller
{
    public function index()
    {
        $revistas = RevistaCientifica::orderBy('area_conocimiento')->orderBy('nombre')->get();
        return view('publico.revistas_cientificas', compact('revistas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'area_conocimiento' => 'nullable|string|max:255',
            'indexacion' => 'nullable|string|max:255',
            'issn' => 'nullable|string|max:50',
            'enlace' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        RevistaCientifica::create($data);
        return back()->with('ok', 'Revista registrada correctamente.');
    }

    public function show(RevistaCientifica $revistaCientifica)
    {
        return response()->json($revistaCientifica);
    }

    public function update(Request $request, RevistaCientifica $revistaCientifica)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'area_conocimiento' => 'nullable|string|max:255',
            'indexacion' => 'nullable|string|max:255',
            'issn' => 'nullable|string|max:50',
            'enlace' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        $revistaCientifica->update($data);
        return back()->with('ok', 'Revista actualizada correctamente.');
    }

    public function destroy(RevistaCientifica $revistaCientifica)
    {
        $revistaCientifica->delete();
        return back()->with('ok', 'Revista eliminada correctamente.');
    }
}
