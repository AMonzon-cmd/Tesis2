<?php

use App\Http\Controllers\AjaxController\ClienteController;
use App\Http\Controllers\AjaxController\PagoController;
use App\Http\Controllers\AjaxController\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\ProductoCatalogoController;
use App\Http\Controllers\ServicioController;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Encontraremos todas las rutas del sistema de administracion
| Todas se encuentran protegidas por el middleware que controla la sesion
|
*/

Route::get('/test', function(){
    echo "hola";die;
});

Route::get('test2', function(){
    dd(DB::connection());
});

Route::get('test2', function(){
    dd(Rol::all());
});

Route::get('test3', function(){
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return 'Completado';
});

//Pagina de Iniciar Sesion
Route::get('/inicioSesion', [LoginController::class, 'IniciarSesionView'])->name('IniciarSesionVista');

//Accion de iniciar sesion
Route::get('/iniciarSesion', [LoginController::class, 'IniciarSesion'])->name('IniciarSesionAccion');

Route::middleware('auth')->group(function () {
    Route::get('/', [ModulosController::class, 'Dashboard']);
    Route::post('/cerrarSesion', [LoginController::class, 'CerrarSesion'])->name('CerrarSesion');
    Route::get('/dashboard', [ModulosController::class, 'Dashboard'])->name('Dashboard');

    Route::get('/agregarEmpleado',[ModulosController::class, 'AltaEmpleado'])->name('AltaEmpleado');
    Route::get('/modificarEmpleado/{idUsuario}', [ModulosController::class, 'ModificarEmpleado'])->name('ModificarEmpleado');
    Route::get('/listadoEmpleados', [ModulosController::class, 'ListadoEmpleados'])->name('ListadoEmpleados');
    
    Route::group(['prefix' => 'clientes'], function () {
        Route::get('/', [ModulosController::class, 'ListadoClientes'])->name('ListadoClientes');
        Route::get('/{idUsuario}', [ModulosController::class, 'ModificarCliente'])->name('ModificarCliente');
        Route::get('/{idUsuario}/pagos', [ModulosController::class, 'ListarPagosCliente'])->name('ListadoPagosCliente');
        Route::get('/{idUsuario}/canjes', [ModulosController::class, 'ListarCanjesCliente'])->name('ListadoCambioProductos');
    });

    Route::get('/listadoServicios', [ModulosController::class, 'ListadoServicios'])->name('ListadoServicios');
    Route::post('/servicio', [ServicioController::class, 'AltaServicio'])->name('AltaServicio');
    Route::get('/listadoPagos', [ModulosController::class, 'ListadoPagos'])->name('ListadoPagos');

    Route::get('/producto', [ModulosController::class, 'AltaProductoCatalogo'])->name('vistaAltaProducto');
    Route::get('/publicidades', [ModulosController::class, 'ListadoPublicidad'])->name('vistaListadoPublicidad');
    Route::get('/productos', [ProductoCatalogoController::class, 'vistaListadoProductos'])->name('vistaListadoProductos');
    Route::post('/producto', [ProductoCatalogoController::class, 'altaNuevoProducto'])->name('accionAltaProducto');
    Route::get('/producto/{id}', [ProductoCatalogoController::class, 'vistaEditarProducto'])->name('vistaEditarProducto');
    Route::put('/producto/{id}', [ProductoCatalogoController::class, 'editarProducto'])->name('accionEditarProducto');
    Route::get('/roles', [ModulosController::class, 'ListadoRoles'])->name('ListadoRoles');
    Route::get('/listadoPermisos/{idRol}', [ModulosController::class, 'ListadoPermisosRoles'])->name('ListadoPermisos');
    
    // Route::put('/producto/{id}', [ProductoCatalogoController::class, 'editarProducto'])->name('accionEditarProducto');


    // PETICIONES POR AJAX //////////////////////
    Route::post('/AltaEmpleadoAjax', [UsuarioController::class, 'AltaEmpleado']);
    Route::post('/ModificarEmpleadoAjax', [UsuarioController::class, 'ModificarEmpleado'])->name('modificacionEmpleado');
    Route::post('/cambiarEstadoEmpleado', [UsuarioController::class, 'cambiarEstadoEmpleado'])->name('cambiarEstadoEmpleado');
    Route::post('/generarNuevaPassword', [UsuarioController::class, 'generarNuevaPassword'])->name('generarNuevaPassword');
    Route::post('/actualizarPassword', [UsuarioController::class, 'actualizarPassword'])->name('actualizarPassword');
    Route::post('/modificarClienteAjax', [ClienteController::class, 'ModificarCliente'])->name('ModificacionCliente');
    Route::post('/cambiarEstadoCliente', [ClienteController::class, 'CambiarEstado'])->name('CambiarEstadoCliente');
    Route::post('/anularPagoAjax', [PagoController::class, 'AnularPago'])->name('AnularPago');
    Route::post('/cambiarEstadoServicio', [ServicioController::class, 'alternarEstadoServicio'])->name('alternarEstadoServicio');
    Route::post('/cambiarEstadoProducto', [ProductoCatalogoController::class, 'alternarEstadoProducto'])->name('alternarEstadoProducto');
    Route::post('/modificarServicio', [ServicioController::class, 'modificarServicio'])->name('modificarServicio');
    Route::post('/modificarPublicidad', [ServicioController::class, 'modificarPublicidad'])->name('cambiarEstadoPublicidad');
    Route::post('/altaPublicidad', [ServicioController::class, 'altaPublicidad'])->name('altaPublicidad');
    Route::post('/eliminarRol', [UsuarioController::class, 'EliminarRol'])->name('eliminaRol');
    Route::post('/agregarRol', [UsuarioController::class, 'CrearRol'])->name('agregarRol');
    Route::post('/actualizarPermisos', [UsuarioController::class, 'ActualizarPermisosRoles'])->name('acualizarRoles');

    ////////////////////////////////////////////
});



