<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publicacion extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'tipo',
        'autores',
        'medio',
        'anio',
        'doi_isbn',
        'resumen',
        'investigador_id',
    ];

    public function investigador(): BelongsTo
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }
}
