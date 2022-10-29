<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntentoRecupero extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'restablecimientoContrasenias';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'email', 'token', 'created_at'
    ];

}
