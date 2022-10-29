<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'Usuarios';
    protected $primaryKey = 'id';
    protected $remember_token = true;
    protected $guarded = ['id'];

    protected $fillable = [
        'tipo', 'email', 'contrasena','tokenActivacion', 'rememberToken', 'puntos'
    ];

    protected $hidden = [
        'password', 'contrasena', 'deleted_at', 'updated_at', 'remember_token',
    ];

    public function datos(){
        return $this->hasOne(PersonaFisica::class, 'idUsuario' ,'id');
    }

    public function servicios(){
        return $this->belongsToMany(Servicio::class, 'ServiciosAgendados', 'idUsuario', 'idServicio');
    }
    
    public function estaDeBaja(){
        return $this->deleted_at != null;
    }
}
