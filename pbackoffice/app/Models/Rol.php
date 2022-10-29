<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $table = 'Roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y G:i',
    ];

    public function ListarPermisos(){
        return DB::table('Permisos')->join('PermisosDeRoles', 'PermisosDeRoles.permiso_id', '=', 'Permisos.id')->join('Roles', 'Roles.id', '=', 'PermisosDeRoles.rol_id')->where('PermisosDeRoles.rol_id', $this->id)->pluck('Permisos.nombre');
    }

    public function tienePermiso(int $permiso){
        return DB::table('PermisosDeRoles')->where('rol_id', $this->id)->where('permiso_id', $permiso)->exists();
    }

    public function seEstaUsando()
    {
        return DB::table('UsuariosBackoffice')->where('rol_id', $this->id)->count() > 0;
    }
}
