<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaFisica extends Model
{

    protected $table = 'PersonasFisicas';
    protected $primaryKey = 'idUsuario';

    protected $fillable = [
        'idUsuario', 'nombre', 'apellido', 'documento', 'sexo', 'fechaNacimiento'
    ];

}
