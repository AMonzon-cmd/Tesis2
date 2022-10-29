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
        'fecha_reclamo' => 'datetime:d/m/Y G:i',
    ];

    public function producto()
    {
        return $this->hasOne('App\Models\ProductoCatalogo', 'id', 'producto_id');
    }

    public function getEstado()
    {
        if($this->fecha_reclamo != null){
            return '<span class="text-success"> Retirado </span>';
        }

        if($this->deleted_at != null){
            return '<span class="text-danger"> Anulado </span>';
        }

        return '<span class="text-warning"> Pendiente Retiro </span>';
    }
}
