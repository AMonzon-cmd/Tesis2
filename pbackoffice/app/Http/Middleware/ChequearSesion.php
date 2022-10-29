<?php

namespace App\Http\Middleware;

use App\Utilidades\Constantes;
use Closure;
use Illuminate\Support\Facades\Auth;

class ChequearSesion
{
    /**
     * Middleware que se encarga de controlar que el usuario este logeado y que sea un empleado de la empresa
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed // Si no cumple lo envia al login. Si cumple lo deja ingresar.
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()){
            return $next($request);
        }else{
            return redirect('inicioSesion');
        }
    }
}
