<?php

namespace App\Http\Controllers;

use App\Models\ProductoCatalogo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class ProductoCatalogoController extends Controller
{
    protected function altaNuevoProducto(Request $request)
    {
        try{
            $datos = $request->all();
            $this->validarProducto($datos);
            ProductoCatalogo::create([
                'nombre'        => $datos['nombre'],
                'descripcion'   => $datos['descripcion'],
                'costo'         => $datos['costo'],
                'stock'         => $datos['stock'],
                'img'           => $datos['img'],
                'Activo'        => 1
            ]);
            return view('Productos.Producto')->with('mensaje', 'Se realizo la alta del producto.');
        }catch(Exception $e){
            $mensajeError = ($e->getCode() == 400) ? $e->getMessage() : "";
            return Redirect::back()->withErrors("Fallo el alta del producto. {$mensajeError}")->withInput();
        }
    }

    protected function vistaEditarProducto(int $id){
        $producto = ProductoCatalogo::find($id);

        if(!$producto){
            return Redirect::route('accionAltaProducto')->withErrors('No se encontro el producto indicado');
        }
        return view('Productos.Producto', compact('producto'));
    }

    protected function vistaListadoProductos(Request $request)
    {
        $productos = ProductoCatalogo::all();
        return view('Productos.listadoProductos', compact('productos'));
    }

    protected function alternarEstadoProducto(Request $request)
    {
        try{
            $datos = $request->all();
            $producto = ProductoCatalogo::findOrFail($datos['id']);

            $producto->deleted_at = ($producto->deleted_at == null) ? Carbon::now() : null;
            $producto->save();

            return response()->json(['respuesta' => 'Se realizo el cambio de estado en el servicio.', 'servicio' => $producto], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    protected function editarProducto(Request $request, int $id)
    {
        try{
            $datos = $request->all();
            $producto = ProductoCatalogo::findOrFail($id);
            $this->validarProducto($datos);
            $this->cargarNuevosDatos($producto, $datos);
            $producto->save();
            return view('Productos.Producto', compact('producto'))->with('mensaje', 'Se guardaron los cambios del producto.');
        }catch(Exception $e){
            if($e->getCode() == 400){
                return Redirect::route('accionEditarProducto')->withErrors("No se edito el producto {$e->getMessage()}");
            }
            return Redirect::route('accionAltaProducto')->withErrors('No se encontro el producto indicado');
        }
        
    }

    private function cargarNuevosDatos(ProductoCatalogo &$producto, $datos){
        $producto->nombre = $datos['nombre'];
        $producto->descripcion = $datos['descripcion'];
        $producto->costo = $datos['costo'];
        $producto->stock = $datos['stock'];
        $producto->img = $datos['img'];
    }

    private function validarProducto($datos){

        if(!isset($datos['nombre'])){
            throw new Exception('Debe ingresar el nombre del producto.', 400);
        }

        if(!isset($datos['costo']) || $datos['costo'] < 1){
            throw new Exception('El costo indicado no es valido.', 400);
        }

        if(!isset($datos['img'])){
            throw new Exception('Debe indicar una url de imagen para el producto.', 400);
        }
    }
}


