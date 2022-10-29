<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosDeRoles extends Model
{
    use HasFactory;

    protected $table = 'PermisosDeRoles';
    protected $primaryKey = 'permiso_id';

    protected $fillable = [
        'rol_id', 'permiso_id'
    ];
}
