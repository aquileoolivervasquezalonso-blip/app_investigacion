<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'fecha_publicacion',
        'destacada',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'destacada' => 'boolean',
    ];
}
