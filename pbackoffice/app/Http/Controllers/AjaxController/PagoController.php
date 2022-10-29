<?php

namespace App\Http\Controllers\AjaxController;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use Exception;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    protected function anularPago(Request $request){
        try{
            $datos = $request->all();
            $pago = Pago::findOrFail($datos['id']);
            $this->ejecutarAnulacion($pago, $datos['usuario_id']);
            $pago->notificarAnulacion();
            return response()->json(['respuesta' => 'Se anulo el pago correctamente.'], 200);
        }catch(Exception $e){
            if($e->getCode() == 400){
                return response()->json(['respuesta' => $e->getMessage()], 400);
            }

            return response()->json(['respuesta' => 'Error al realizar la anulacion'], 500);
        }
    }

    private function ejecutarAnulacion(Pago $pago, $idUsuario){
        if($pago->estado == 'Anulado'){
            throw new Exception('El pago ya se encuentra anulado', 400);
        }
        $cliente = $pago->cliente;

        if($pago->usuario_id != $idUsuario || $idUsuario <= 0){
            throw new Exception('El pago y el cliente no coinciden', 400);
        }

        $cliente->puntos =  ($cliente->puntos < $pago->puntaje_generado) ? 0 : $cliente->puntos - $pago->puntaje_generado;

        $pago->estado = 'Anulado';

        $cliente->save();
        $pago->save();
    }
}
