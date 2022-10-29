<?php

use App\Http\Controllers\PagosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function () {
    Route::get('/1', function(){
        echo "OK";
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/', [UsuarioController::class, 'altaPersonaFisica']);
        Route::put('/', [UsuarioController::class, 'altaPersonaFisica']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/logout', [UsuarioController::class, 'cerrarSesion'])->middleware('auth:api');
        Route::get('/getInfo', [UsuarioController::class, 'getInfo'])->middleware('auth:api');
        Route::get('/nombre',[UsuarioController::class, 'getNombre'])->middleware('auth:api');
        Route::get('/{id?}', [UsuarioController::class, 'obtenerUsuarios']);
        Route::post('/', [UsuarioController::class, 'altaPersonaFisica']);
        Route::put('/', [UsuarioController::class, 'altaPersonaFisica']);
        Route::delete('/', [UsuarioController::class, 'altaPersonaFisica']);
        Route::get('/{userId}/services', [ServicioController::class, 'listarServicios'])->middleware('auth:api');
        Route::get('/{userId}/products', [ProductoController::class, 'listarProductosUsuario']);//->middleware('auth:api');
        Route::get('/{userId}/pays', [PagosController::class, 'listarPagosUsuario']);//->middleware('auth:api');
        // Route::post('/{userId}/recovery', [UsuarioController::class, 'recuperarContrasenia'])->middleware('auth:api');
        //Route::get('/{userId}/services', [ServicioController::class, 'listarServicios']);//->middleware('auth:api');
    });

    Route::group(['prefix' => 'recovery'], function () {
        Route::get('/', [UsuarioController::class, 'generarRecuperarContrasenia']);
        Route::get('/token', [UsuarioController::class, 'tokenRecuperarContraseniaValido']);
        Route::post('/', [UsuarioController::class, 'cambiarContraseña']);
    });

    Route::group(['prefix' => 'service'], function () {
        Route::get('/', [ServicioController::class, 'listarServicios']);
        Route::get('/best', [ServicioController::class, 'topServicios']);
        Route::post('/{servicioId}', [ServicioController::class, 'listarServicios']);
        Route::get('/currency', [ServicioController::class, 'listarMonedas']);
        Route::get('/publicity', [ServicioController::class, 'listadoPublicidad']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/{productoId?}', [ProductoController::class, 'listarProductos']);
        Route::post('/{productoId}', [ProductoController::class, 'reclamarProducto'])->middleware('auth:api');
    });

    
    Route::group(['prefix' => 'pay'], function(){
        Route::post('/', [PagosController::class, 'relizarPago'])->middleware('auth:api');
        Route::put('/', [PagosController::class, 'mail'])->middleware('auth:api');
    });

});