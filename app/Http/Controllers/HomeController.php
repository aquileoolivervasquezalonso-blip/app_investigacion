<?php
namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Proyecto;
use App\Models\Publicacion;
use App\Models\Investigador;

class HomeController extends Controller
{
    public function index()
    {
        $destacadas = Noticia::where('destacada', true)->orderByDesc('fecha_publicacion')->take(3)->get();
        $noticias = Noticia::orderByDesc('fecha_publicacion')->take(6)->get();
        $totales = [
            'proyectos' => Proyecto::count(),
            'publicaciones' => Publicacion::count(),
            'investigadores' => Investigador::count(),
        ];
        return view('publico.inicio', compact('destacadas', 'noticias', 'totales'));
    }

    public function nosotros()
    {
        return view('publico.nosotros');
    }

    public function contacto()
    {
        return view('publico.contacto');
    }
}
