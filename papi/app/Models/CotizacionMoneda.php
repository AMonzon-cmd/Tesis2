<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionMoneda extends Model
{
    use HasFactory;

    protected $table = 'CotizacionMonedas';
    protected $primaryKey = 'moneda_id';

    protected $fillable = [
        'moneda_id', 'compra', 'venta'
    ];
}
