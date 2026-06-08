<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'financiamiento',
        'monto',
        'fecha_inicio',
        'fecha_fin',
        'resultados',
        'investigador_id',
        'linea_investigacion_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto' => 'decimal:2',
    ];

    public function investigador(): BelongsTo
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }

    public function lineaInvestigacion(): BelongsTo
    {
        return $this->belongsTo(LineaInvestigacion::class, 'linea_investigacion_id');
    }
}
