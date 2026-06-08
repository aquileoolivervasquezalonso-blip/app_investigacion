<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanTrabajo extends Model
{
    protected $table = 'planes_trabajo';

    protected $fillable = [
        'titulo',
        'tipo',
        'anio',
        'objetivos',
        'actividades',
        'metas',
        'estado',
        'investigador_id',
    ];

    public function investigador(): BelongsTo
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }
}

