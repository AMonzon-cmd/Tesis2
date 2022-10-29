<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedioDePago extends Model
{
    protected $table = 'MediosDePago';
    protected $primaryKey = 'IdMedioPago';

    protected $fillable = [
        'Nombre', 'Descripcion', 'UrlPago', 'Activo'
    ];

}
