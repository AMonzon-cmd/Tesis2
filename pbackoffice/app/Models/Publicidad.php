<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publicidad extends Model
{
    protected $table = 'Publicidad';
    protected $primaryKey = 'id';

    protected $fillable = [
        'img', 'url', 'usuario_admin_id', 'fecha_desde', 'fecha_hasta'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y G:i',
        'fecha_desde' => 'datetime:d/m/Y',
        'fecha_hasta' => 'datetime:d/m/Y',
    ];

    public function usuario(){
        return $this->hasOne(Usuario::class, 'id' ,'usuario_admin_id');
    }
}
