<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    
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

    public function getAuthPassword()
    {
        $pass = $this->contrasena;
        return $pass;
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function datos(){
        return $this->hasOne('App\Models\PersonaFisica', 'idUsuario', 'id');
    }
}
