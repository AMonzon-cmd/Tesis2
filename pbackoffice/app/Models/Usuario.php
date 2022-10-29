<?php

namespace App\Models;

use App\Utilidades\Constantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\RequestInterface;
/** 
  * Esta clase es la utilizada para utenticarse en el sistema y es la que contiene toda la inforamcion del usuario.
  * @author NetCode Solutions solutionsnetcode@gmail.com
*/
class Usuario extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'UsuariosBackoffice';
    protected $primaryKey = 'id';
    protected $remember_token = true;
    protected $guarded = ['id'];


    protected $fillable = [
        'email', 'pass', 'nombre', 'apellido', 'documento','rol_id', 'usuario_genera_id'
    ];

    protected $hidden = [
        'pass', 'remember_token',
    ];

    public function getAuthPassword()
    {
        $pass = $this->pass;
        return $pass;
    }

    public function Rol(){
        return $this->hasOne(Rol::class, 'id' ,'rol_id');
    }

    public function listarPermisos()
    {
        return DB::table('Permisos')
        ->join('PermisosDeRoles', 'PermisosDeRoles.permiso_id', '=', 'Permisos.id')
        ->join('Roles', 'Roles.id', '=', 'PermisosDeRoles.rol_id')
        ->where('Roles.id', $this->rol_id)
        ->pluck('Permisos.slug');
    }

    public function tienePermisos(string $permiso)
    {
        // return DB::table('Permisos')
        // ->join('PermisosDeRoles', 'PermisosDeRoles.permiso_id', '=', 'Permisos.id')
        // ->join('Role', 'Role.id', '=', 'PermisosDeRoles.rol_id')
        // ->where('Role.id', $this->rol_id)->where('Permiso')
        // ->pluck('Permisos.slug');
    }

    public function getNombre(){
        return $this->nombre . " " . $this->apellido;
    }

    public function estaDeBaja(){
        return $this->deleted_at != null;
    }


}
