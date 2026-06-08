<?php
namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::orderByDesc('fecha_publicacion')->get();
        return view('publico.noticias', compact('noticias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date',
            'destacada' => 'nullable|boolean',
        ]);
        $data['destacada'] = $request->boolean('destacada');
        Noticia::create($data);
        return back()->with('ok', 'Noticia registrada correctamente.');
    }

    public function show(Noticia $noticia)
    {
        return response()->json($noticia);
    }

    public function update(Request $request, Noticia $noticia)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date',
            'destacada' => 'nullable|boolean',
        ]);
        $data['destacada'] = $request->boolean('destacada');
        $noticia->update($data);
        return back()->with('ok', 'Noticia actualizada correctamente.');
    }

    public function destroy(Noticia $noticia)
    {
        $noticia->delete();
        return back()->with('ok', 'Noticia eliminada correctamente.');
    }
}
