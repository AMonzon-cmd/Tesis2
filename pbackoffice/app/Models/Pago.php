<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'Pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id', 'servicio_id', 'moneda_id', 'monto', 'estado', 'medio_de_pago_id', 'puntaje_generado'
    ];


    public function cliente(){
        return $this->hasOne(User::class, 'id' ,'usuario_id');
    }

    public function servicio(){
        return $this->hasOne(Servicio::class, 'id' ,'servicio_id');
    }

    public function moneda(){
        return $this->hasOne(Moneda::class, 'id' ,'moneda_id');
    }

    public function anular(){
        if($this->estado == 'Anulado'){
            throw new Exception('El pago ya se encuentra anulado');
        }

        $this->estado = 'Anulado';
        $this->save();
    }

    public function notificarAnulacion(){
        $emailCliente = $this->cliente->email;
        //Enviar Mail al cliente;
    }
}
