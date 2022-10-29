<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioAgendado extends Model
{
    use HasFactory;

    protected $table = 'ServiciosAgendados';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idUsuario', 'idServicio'
    ];
}
