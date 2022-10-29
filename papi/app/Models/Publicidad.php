<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    use HasFactory;

    protected $table = 'Publicidad';
    protected $primaryKey = 'id';

    protected $fillable = [
        'img', 'url', 'usuario_admin_id', 'fecha_desde', 'fecha_hasta', 'created_at'
    ];
}
