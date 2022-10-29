<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptionLog extends Model
{
    use HasFactory;

    protected $table = 'ExceptionLog';
    protected $primaryKey = 'id';

    protected $fillable = [
        'servicio', 'exepcion', 'usuario_id'
    ];

    public function cargarExcepcion($servicio, $error, $usuario_id = 0)
    {
        $this->servicio = $servicio;
        $this->excepcion = $error;
        $this->usuario_id = $usuario_id;
        $this->save();
    }
}
