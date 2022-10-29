<?php

namespace App\Http\Controllers\AjaxController;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\PersonaFisica;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected function ModificarCliente(Request $request){
        try{
            $datos = $request->all();
            $cliente = Cliente::findOrFail($datos['id']);
            $datosCliente = $cliente->datos;
            // dd($datosCliente);die;
            $this->modificarDatosCliente($datos['id'], $datos);
            $this->modificarUsuario($cliente, $datos);
            return response()->json(['respuesta' => 'Modificacion de cliente exitosa.'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    protected function CambiarEstado(Request $request){
        try{
            $datos = $request->all();
            $cliente = Cliente::findOrFail($datos['id']);

            $cliente->deleted_at = ($cliente->deleted_at == null) ? Carbon::now() : null;
            $cliente->save();

            return response()->json(['respuesta' => '.', 'cliente' => $cliente], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    private function modificarDatosCliente($datosCliente, $datos){
        $persona = PersonaFisica::find($datosCliente);
        if($persona->documento != $datos['documento']){
            $persona->documento = '534534';
            $persona->documento;
            $persona->save();
            dd($persona);
        }
    }

    private function modificarUsuario($cliente, $datos){
        $cliente->email = $datos['email'];
        $cliente->puntos = $datos['puntos'];
        $cliente->save();
    }
    
}
