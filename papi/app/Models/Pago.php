<?php

namespace App\Models;

use App\Mail\ComprobantePago;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id', 'servicio_id', 'moneda_id', 'monto', 'estado', 'medio_de_pago_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y G:i',
    ];


    public function determinarPuntosGenerados()
    {
        $porcentajePuntaje = env('PORCENTAJE_PUNTAJE', 0.005);
        $montoGeneraPuntaje = $this->monto;
        if ($this->moneda_id != 1){
            $cotizacionActual = CotizacionMoneda::where('moneda_id', $this->moneda_id)->orderBy('created_at', 'desc')->first();
            $montoGeneraPuntaje = $cotizacionActual->venta * $this->monto;
        }
        return round($montoGeneraPuntaje * $porcentajePuntaje);
    }

    public function notificar()
    {
        $usuario = User::findOrFail($this->usuario_id);
        Mail::to($usuario->email)->send(new ComprobantePago($this));
        return true;
    }

    public function servicio()
    {
        return $this->hasOne('App\Models\Servicio', 'id', 'servicio_id');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\PersonaFisica', 'idUsuario', 'usuario_id');
    }

    public function moneda()
    {
        return $this->hasOne('App\Models\Moneda', 'id', 'moneda_id');
    }
}
