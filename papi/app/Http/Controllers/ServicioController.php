<?php

namespace App\Http\Controllers;

use App\Models\ExceptionLog;
use App\Models\Moneda;
use App\Models\Pago;
use App\Models\Publicidad;
use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    public function listarServicios($userId = null){
        try{
            if ($userId){
                $usuario = User::findOrFail($userId);
                return response()->json(['respuesta' => 'Servicios del cliente obtenidos correctamente', 'servicios' => $usuario->servicios], 200);
            }else{
                return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'servicios' => Servicio::where('deleted_at',null)->get()], 200);
            }        
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarServicios', $e->getMessage());
            return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'servicios' => Servicio::where('deleted_at',null)->get()], 200);
        }
    }

    public function listarMonedas(Request $request)
    {
        try{
            return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'monedas' => Moneda::whereNull('deleted_at')->get()], 200);
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarMonedas', $e->getMessage());
            return response()->json(['respuesta' => 'Servicios obtenidos correctamente', 'monedas' => Servicio::where('deleted_at',null)->get()], 200);
        }
    }

    public function pagarServicio(Request $request){
        $datos = $request->all();

        
    }

    public function listadoPublicidad(Request $request)
    {
        try{
            $fecha = Carbon::today();
            $publicidades = Publicidad::whereDate('fecha_desde', '<=', $fecha)->whereDate('fecha_hasta', '>=', $fecha)->whereNull('deleted_at')->get();
            return response()->json(['respuesta' => 'Publicidad obtenida correctamente', 'publicidades' => $publicidades], 200);
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarPublicidad', $e->getMessage());
            return response()->json(['respuesta' => 'Problema al obtener las publicidades. Contacte a soporte'], 500);
        }
    }

    public function topServicios(Request $request)
    {
        try{
            $pagos = Pago::where('estado', 'Confirmado')->whereNull('deleted_at')->groupBy('servicio_id')
            ->selectRaw('count(id) AS count')->orderBy('count', 'DESC')->take(5)->get();
            return response()->json(['respuesta' => 'Publicidad obtenida correctamente', 'pagos' => $pagos], 200);
        }catch(Exception $e){
            dd($e);
            (new ExceptionLog())->cargarExcepcion('topServicios', $e->getMessage());
            return response()->json(['respuesta' => 'Problema al obtener el top de los servicios. Contacte a soporte'], 500);
        }
    }
}
