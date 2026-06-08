<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformeInvestigacion extends Model
{
    protected $table = 'informes_investigacion';

    protected $fillable = [
        'titulo',
        'descripcion',
        'anio',
        'archivo',
        'investigador_id',
        'proyecto_id',
    ];

    public function investigador(): BelongsTo
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}
