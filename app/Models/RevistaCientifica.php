<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevistaCientifica extends Model
{
    protected $table = 'revistas_cientificas';

    protected $fillable = [
        'nombre',
        'area_conocimiento',
        'indexacion',
        'issn',
        'enlace',
        'descripcion',
    ];
}
