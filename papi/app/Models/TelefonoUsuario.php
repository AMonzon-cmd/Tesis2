<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelefonoUsuario extends Model
{
    
    protected $table = 'TelefonosUsuarios';
    protected $primaryKey = 'IdTelefono';

    protected $fillable = [
        'IdUsuario', 'Telefono', 'Activo'
    ];

}
