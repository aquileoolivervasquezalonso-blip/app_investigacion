<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsistenciaCongreso extends Model
{
    protected $table = 'asistencias_congresos';

    protected $fillable = [
        'nombre_congreso',
        'sede',
        'fecha',
        'tipo_participacion',
        'titulo_ponencia',
        'constancia',
        'investigador_id',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function investigador(): BelongsTo
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }
}
