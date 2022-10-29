<?php

namespace App\Http\Controllers;

use App\Mail\ComprobanteCanje;
use App\Models\ExceptionLog;
use App\Models\PersonaFisica;
use App\Models\ProductoCatalogo;
use App\Models\ReclamoProducto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductoController extends Controller
{
    public function listarProductos($productoId = null){
        try{
            if ($productoId){
                $producto = ProductoCatalogo::findOrFail($productoId);
                return response()->json(['respuesta' => 'Producto de catalogo obtenido correctamente', 'producto' => $producto], 200);
            }else{
                return response()->json(['respuesta' => 'Productos obtenidos correctamente', 'productos' => ProductoCatalogo::where('deleted_at',null)->get()], 200);
            }        
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarProductos', $e->getMessage());
            return response()->json(['respuesta' => 'No se pudieron obtener los productos. Contacte a soporte'], 500);
        }
    }

    public function reclamarProducto($productoId){
        try{
            $producto = ProductoCatalogo::findOrFail($productoId);
            if($producto->stock <= 0){
                return response()->json(['respuesta' => 'No tenemos mas stock del producto seleccionado'], 400);
            }
            $usuario = User::find(Auth::user()->id);
            if($usuario->puntos < $producto->costo){
                return response()->json(['respuesta' => 'No posee saldo suficiente para reclamar el producto'], 400);
            }

            $reclamo = ReclamoProducto::create([
                'usuario_id' => $usuario->id,
                'producto_id'    => $producto->id,
                'puntos_usuario'  => $usuario->puntos,
                'puntos_producto' => $producto->costo
            ]);

            $usuario->puntos -= $producto->costo;
            $usuario->save();

            $producto->stock -=1;
            $producto->save();

            $cliente = PersonaFisica::where('idUsuario', $usuario->id)->first();
            // Mail::to('hernan.aguirrezabala@payday.com.uy')->send(new ComprobanteCanje());
            try{
                Mail::to($usuario->email)->send(new ComprobanteCanje($reclamo));
            }catch(Exception $e){
                (new ExceptionLog())->cargarExcepcion('reclamarProducto', 'No se pudo enviar email de reclamo. Motivo: ' . $e->getMessage());
            }
            return response()->json(['respuesta' => 'Producto de catalogo reclamado', 'producto' => $producto], 200);
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('reclamarProducto', $e->getMessage());
            return response()->json(['respuesta' => 'Error al intentar reclamar el producto. Contacte a soporte'], 500);
        }
    }

    public function listarProductosUsuario($idUsuario){
        try{
            if (!$idUsuario){
                return response()->json(['respuesta' => 'No se pueden obtener los productos', 'productos' => ''], 400);
            }  
            $productos = "";
            return response()->json(['respuesta' => 'Productos reclamados obtenidos', 'productos' => $productos], 200);
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('listarProductosUsuario', $e->getMessage());
            return response()->json(['respuesta' => 'No se pudieron obtener los productos. Contacte a soporte'], 500);
        }
    }
}
