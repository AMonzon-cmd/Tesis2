<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoCatalogo extends Model
{
    protected $table = 'ProductosCatalogo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre', 'descripcion', 'costo', 'stock', 'img'
    ];

}
