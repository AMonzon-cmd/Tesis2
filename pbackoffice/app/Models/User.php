<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


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


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
