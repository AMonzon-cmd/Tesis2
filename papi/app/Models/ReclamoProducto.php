<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclamoProducto extends Model
{
    use HasFactory;

    protected $table = 'RelProductoUsuario';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id', 'producto_id', 'puntos_usuario', 'puntos_producto'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y G:i',
    ];

    public function producto()
    {
        return $this->hasOne('App\Models\ProductoCatalogo', 'id', 'producto_id');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\PersonaFisica', 'idUsuario', 'usuario_id');
    }
}
