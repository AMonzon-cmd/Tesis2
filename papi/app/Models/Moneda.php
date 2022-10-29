<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $table = 'Monedas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre', 'simbolo', 'isoCodigo', 'isoNumerico'
    ];

}
