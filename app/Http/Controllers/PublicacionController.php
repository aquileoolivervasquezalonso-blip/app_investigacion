<?php
namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Investigador;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::with('investigador')->orderByDesc('anio')->get();
        $investigadores = Investigador::orderBy('nombre_completo')->get();
        return view('publico.publicaciones', compact('publicaciones', 'investigadores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Artículo,Libro,Patente,Desarrollo Tecnológico',
            'autores' => 'nullable|string|max:255',
            'medio' => 'nullable|string|max:255',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'doi_isbn' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);
        Publicacion::create($data);
        return back()->with('ok', 'Publicación registrada correctamente.');
    }

    public function show(Publicacion $publicacion)
    {
        return response()->json($publicacion);
    }

    public function update(Request $request, Publicacion $publicacion)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Artículo,Libro,Patente,Desarrollo Tecnológico',
            'autores' => 'nullable|string|max:255',
            'medio' => 'nullable|string|max:255',
            'anio' => 'nullable|integer|min:1900|max:2100',
            'doi_isbn' => 'nullable|string|max:255',
            'resumen' => 'nullable|string',
            'investigador_id' => 'nullable|exists:investigadores,id',
        ]);
        $publicacion->update($data);
        return back()->with('ok', 'Publicación actualizada correctamente.');
    }

    public function destroy(Publicacion $publicacion)
    {
        $publicacion->delete();
        return back()->with('ok', 'Publicación eliminada correctamente.');
    }
}
