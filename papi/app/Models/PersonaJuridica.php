<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaJuridica extends Model
{
    protected $table = 'PersonasJuridicas';
    protected $primaryKey = 'IdPersonaJuridica';

    protected $fillable = [
        'IdUsuario', 'RazonSocial', 'NombreFantasia', 'Rut', 'FormaJuridica', 'FechaConformacion'
    ];

}
