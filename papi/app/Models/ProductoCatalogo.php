<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCatalogo extends Model
{
    use HasFactory;

    protected $table = 'ProductosCatalogo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre', 'descripcion', 'costo', 'stock'
    ];
}
