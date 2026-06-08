<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuerpoAcademico extends Model
{
    protected $table = 'cuerpos_academicos';

    protected $fillable = [
        'nombre',
        'clave',
        'grado_consolidacion',
        'descripcion',
    ];

    public function lineasInvestigacion(): HasMany
    {
        return $this->hasMany(LineaInvestigacion::class, 'cuerpo_academico_id');
    }

    public function investigadores(): HasMany
    {
        return $this->hasMany(Investigador::class, 'cuerpo_academico_id');
    }
}
