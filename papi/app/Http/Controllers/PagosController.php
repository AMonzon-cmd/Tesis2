<?php

namespace App\Http\Controllers;

use App\Http\Requests\AltaPago;
use App\Mail\ComprobanteCanje;
use App\Mail\ComprobantePago;
use App\Models\ExceptionLog;
use App\Models\Moneda;
use App\Models\Pago;
use App\Models\ReclamoProducto;
use App\Models\ServicioAgendado;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PagosController extends Controller
{
    protected function listarPagosUsuario($idUsuario){
        try {
            if(!$idUsuario){
                throw new Exception("No se pudieron obtener los pagos. Contacte a soporte", 1);
            }
            $pagos = Pago::where('usuario_id', $idUsuario)->get();
            return response()->json(['respuesta' => 'Pagos obtenidos correctamente', 'pagos' => $pagos], 200);
        } catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarPagosUsuario', $e->getMessage());
            return response()->json(['respuesta' => 'No se pudieron obtener los pagos. Contacte a soporte'], 500);
        }
    }

    protected function mail(){
        $pago = ReclamoProducto::find(1);
        Mail::to('clferreri94@hotmail.com')->send(new ComprobanteCanje($pago));
    }

    protected function relizarPago(AltaPago $request){
        try {
            DB::beginTransaction();
            $datos = $request->all();
            if(!is_numeric($datos['monto'])){
                return response()->json(['respuesta' => 'El monto ingresado no es valido.'],400);
            }
            $pago = $this->_realizarPago($datos);
            $this->_actualizarPuntaje($pago);
            $this->_agendarServicio($datos['idServicio']);
            try{
                $pago->notificar();
            }catch(Exception $e){
                (new ExceptionLog())->cargarExcepcion('relizarPago', 'No se pudo enviar email de pago. Motivo: ' . $e->getMessage());
            }
            DB::commit(); 
            return response()->json(['respuesta' => 'Pago realizado correctamente.'],200);
        } catch (\Throwable $th) {
            DB::rollback();
            (new ExceptionLog())->cargarExcepcion('relizarPago', $th->getMessage());
            return response()->json(['respuesta' => 'No se pudo realizar el pago.'], 500);
        }
    }

    private function _realizarPago(array $datos){
        return Pago::create([
            'usuario_id'        => Auth::user()->id,
            'servicio_id'       => $datos['idServicio'],
            'moneda_id'         => $datos['moneda'],
            'monto'             => $datos['monto'],
            'estado'            => 'Confirmado',
            'medio_de_pago_id'  => null
        ]);
    }

    private function _actualizarPuntaje(Pago $pago){
        $usuario = User::findOrFail($pago->usuario_id);
        $puntajeGenerado = $pago->determinarPuntosGenerados();
        $usuario->puntos += $puntajeGenerado;
        $usuario->save();
        $pago->puntaje_generado = $puntajeGenerado;
        $pago->save();
    }

    private function _agendarServicio($idServicio){
        $servicioAgendado = ServicioAgendado::where('idUsuario', Auth::user()->id)->where('idServicio', $idServicio)->first();

        if(!$servicioAgendado){
            ServicioAgendado::create([
                'idUsuario' => Auth::user()->id,
                'idServicio' => $idServicio
            ]);
        }
    }
}
