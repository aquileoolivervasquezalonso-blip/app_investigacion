<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LineaInvestigacion extends Model
{
    protected $table = 'lineas_investigacion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cuerpo_academico_id',
    ];

    public function cuerpoAcademico(): BelongsTo
    {
        return $this->belongsTo(CuerpoAcademico::class, 'cuerpo_academico_id');
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'linea_investigacion_id');
    }
}
