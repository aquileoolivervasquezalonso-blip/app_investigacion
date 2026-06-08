<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vinculacion extends Model
{
    protected $table = 'vinculaciones';

    protected $fillable = [
        'nombre',
        'tipo',
        'institucion',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];
}
