<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConvocatoriaCongreso extends Model
{
    protected $table = 'convocatorias_congresos';

    protected $fillable = [
        'nombre',
        'sede',
        'descripcion',
        'fecha_evento',
        'fecha_limite',
        'estado',
        'enlace',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'fecha_limite' => 'date',
    ];
}
