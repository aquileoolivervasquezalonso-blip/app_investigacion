<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investigador extends Model
{
    protected $table = 'investigadores';

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'grado_academico',
        'especialidad',
        'email',
        'telefono',
        'cv',
        'foto',
        'cuerpo_academico_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cuerpoAcademico(): BelongsTo
    {
        return $this->belongsTo(CuerpoAcademico::class, 'cuerpo_academico_id');
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'investigador_id');
    }

    public function publicaciones(): HasMany
    {
        return $this->hasMany(Publicacion::class, 'investigador_id');
    }
}
