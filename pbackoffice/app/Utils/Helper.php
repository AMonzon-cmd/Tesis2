<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

/** Helper destinado a auxiliar con las rutas del backoffice permitiendo manipular las mismas en base al guard */


/**
 * Devuelve la ruta http a utilizar con ese nombre dependiendo del guard que se este consultando
 *
 * @param string $nombre
 * @return string
 */
function ruta(string $path, $parametro = "", $extra = "") : string
{
    $ruta = env('APP_URL', 'http://www.payday.com.uy/backoffice/') . $path;
    if($parametro != ""){
        $ruta = $ruta . '/' . $parametro;
        if($extra != ""){
            $ruta .= "/" . $extra;
        }
    }
    return $ruta;
}

function poseePermiso(array $permisos, array $permisosUsuario){
    foreach ($permisos as $key => $permiso) {
        if(in_array($permiso, $permisosUsuario)){
            return true;
        }
    }
    return false;
}

/**
 * Devuelve un redirect http para la ruta que se inidique dependiendo del guard que se esta consultando
 *
 * @param string $nombre Nombre de la ruta que se esta queriendo redireccionar
 * @return RedirectResponse redirect correspondiente
 */
function redirectBackoffice(string $nombre) : Redirector|RedirectResponse 
{
    $nombreCompleto = Auth::getDefaultDriver() . '_' . $nombre;
    return redirect()->route($nombreCompleto);
}

/**
 * Marca como activa la ruta uqe se pasa como parametro, para poder dar un efecto visual
 *
 * @param string $nombreRuta nombre de la ruta que se desea verificar si esta activa o no.
 * @return string valor active o vacio dependiendo que corresponda (se utiliza en class)
 */
function setActiva(string $nombreRuta) : string
{
    return request()->routeIs($nombreRuta . ".*") ? 'active' : '';
}

/**
 * Devuelve la ruta http a utilizar para el login
 *
 * @return string
 */
function redirectLogin() : RedirectResponse
{
    return redirect()->route(Auth::getDefaultDriver() . '_vista_login');
}


function getRutaDashboard() : string
{
    return Auth::getDefaultDriver() . '_vista_dashboard';
}