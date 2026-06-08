<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvocatoriaProdep extends Model
{
    protected $table = 'convocatorias_prodep';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_publicacion',
        'fecha_limite',
        'estado',
        'archivo',
        'enlace',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_limite' => 'date',
    ];
}
