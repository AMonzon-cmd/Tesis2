<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    protected function IniciarSesionView(){
        return view('Autenticacion.Login');
    }

    protected function IniciarSesion(Request $request){
        $usuario = Usuario::where('email', $request->email)->first();
        if(!$usuario){
            return Redirect::back()->withErrors(['Las credenciales son incorrectas.']);
        }

        if($usuario->deleted_at != null){
            return Redirect::back()->withErrors(['Usuario deshabilitado. Contacte con el administrador.']);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/dashboard');
        }
        else{
            return Redirect::back()->withErrors(['Las credenciales son incorrectas.']);
        }
    }

    Protected function CerrarSesion(){
        Auth::logout();
        return redirect("/inicioSesion");
    }
}
