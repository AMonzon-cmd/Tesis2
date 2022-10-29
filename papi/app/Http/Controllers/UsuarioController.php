<?php

namespace App\Http\Controllers;

use App\Http\Requests\AltaClienteFisicoRequest;
use App\Http\Requests\AltaUsuarioRequest;
use App\Mail\RecuperarContrasenia;
use App\Models\ExceptionLog;
use App\Models\IntentoRecupero;
use App\Models\Pago;
use App\Models\PersonaFisica;
use App\Models\ReclamoProducto;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use stdClass;

class UsuarioController extends Controller
{

    protected function cerrarSesion()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['respuesta' => 'Cerro sesion.'],200);
    }
    
    protected function altaPersonaFisica(AltaClienteFisicoRequest $request){
        try{
            DB::beginTransaction();
            $datosNuevoUsuario = $request->all();
            $nuevoUsuario = $this->_crearUsuario($datosNuevoUsuario);
            $this->_crearPersonaFisica($nuevoUsuario->id, $datosNuevoUsuario);
            DB::commit(); 
            return response()->json(['respuesta' => 'Alta generada correctamente.'],200);
        }catch(Exception $e){
            DB::rollback();
            (new ExceptionLog())->cargarExcepcion('altaPersonaFisica', $e->getMessage());
            return response()->json(['respuesta' => 'Error al generar el alta, contacte a soporte.'], 500);
        }
    }

    protected function getInfo(){
        try{
            $usuario = Auth::user();
            $datos = $usuario->datos;
            $resp = new stdClass();
            $resp->nombre = $datos->nombre . ' ' . $datos->apellido;
            $resp->email = $usuario->email;
            $resp->documento = $datos->documento;
            $resp->fechaNacimiento = $datos->fechaNacimiento;
            $resp->puntos = $usuario->puntos;
            $pagos = $this->obtenerPagosRealizados($usuario->id);
            $resp->pagosRealizados = $pagos->count();
            $canjes = $this->obtenerCanjesRealizados($usuario->id);
            return response()->json(['respuesta' => 'Datos Obtenidos.', 'usuario' => $resp, 'pagos' => $pagos->toArray(), 'canjes' => $canjes->toArray()],200);
        }catch(Exception $e){
            (new ExceptionLog())->cargarExcepcion('getInfo', $e->getMessage());
            return response()->json(['respuesta' => 'Error al generar el alta, contacte a soporte.'], 500);
        }
    }

    protected function getNombre(){
        $usuario = Auth::user();
        if($usuario == null){
            $nombre = 'Cliente ';
        }else{
            $nombre = $usuario->datos->nombre . " ";
        }
        return response()->json(['respuesta' => 'Datos Obtenidos.', 'nombre' => $nombre],200);
    }

    private function obtenerPagosRealizados($idUsuario)
    {
        return Pago::with('servicio')->where('usuario_id', $idUsuario)->where('estado', 'Confirmado')->orderBy('id','desc')->get();
    }

    private function obtenerCanjesRealizados($idUsuario)
    {
        return ReclamoProducto::with('producto')->where('usuario_id', $idUsuario)->get();
    }


    protected function altaPersonaJuridica(AltaUsuarioRequest $request){
        try{
            $datosNuevoUsuario = $request->all();   
            $nuevoUsuario = $this->_crearUsuario($datosNuevoUsuario);
            
            if(!$nuevoUsuario){
                return response()->json(['respuesta' => 'Error generar el usuario.'], 400);
            }

            $datosUsuario = ($datosNuevoUsuario['tipo'] == 1) ? $this->crearPersonaFisica($nuevoUsuario) : $this->crearPersonaJuridica($nuevoUsuario);
            
            if(!$datosUsuario){
                return response()->json(['respuesta' => 'Error al cargar los datos el cliente.'], 400);
            }

            return response()->json(['respuesta' => 'Alta generada correctamente.'. 200]);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'Error al generar el alta, contacte a soporte.'], 500);
        }
    }

    protected function baja(Request $request){

    }


    protected function modificaion(){

    }


    protected function obtenerUsuarios($id = null){
        try{
            if(!$id){
                $usuarios = User::with('datos')->get();
                return response()->json(["respuesta" => 'Listado de usuarios obtenido correctamente.', 'usuarios' => $usuarios], 200);
            }
            $usuario = User::findOrFail($id);
            $usuario->datos;
            return response()->json(['respuesta' => 'Usuario obtenido correctamente.', 'usuario' => $usuario], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => 'El usuario/s no existen en el sistema.'], 500);
        }
    }

    protected function obtenerUsuarioWithToken($token){
        try{
            $datos = DB::select('SELECT u.id, u.email, pf.* FROM oauth_access_tokens as t 
            INNER JOIN Usuarios u ON u.id = t.user_id 
            INNER JOIN PersonasFisicas pf ON pf.idUsuario = u.id
            WHERE t.revoked = 0 ORDER BY t.id DESC LIMIT 1');
            return response()->json(['respuesta' => $datos[0]]);
        }catch(Exception $e)
        {
            return response()->json(['respuesta' => 'El usuario/s no existen en el sistema.'], 500);
        }
    }

    protected function generarRecuperarContrasenia(Request $request)
    {
        try {
            $email = $request->input('email');
            $usuario = User::where('email', $email)->first();
            if(!$usuario){
                return response()->json(['respuesta' => 'Si el usuario es correcto recibira un email para recuperar su contraseña.'], 200);
            }
            $intento = IntentoRecupero::where('email', $email)
                ->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())
                ->whereNull('deleted_at')
                ->first();

            if(!$intento){
                $this->generarTokenRecuperoContraseña($email, $usuario->id);
            }
            return response()->json(['respuesta' => 'Si el usuario es correcto recibira un email para recuperar su contraseña.'], 200);

        } catch (\Throwable $th) {
            (new ExceptionLog())->cargarExcepcion('generaRecuperarContrasenia', $th->getMessage());
            return response()->json(['respuesta' => 'Si el usuario es correcto recibira un email para recuperar su contraseña.'], 500);
        }
    }

    protected function tokenRecuperarContraseniaValido(Request $request)
    {
        try {
            $token = $request->input('tk');
            $intento = IntentoRecupero::where('token', $token)
                ->where('created_at', '>=', Carbon::now()->subMinutes(10)->toDateTimeString())
                ->whereNull('deleted_at')
                ->first();

            if(!$intento){
                return response()->json(['respuesta' => 'Token no valido.'], 400);
            }
            return response()->json(['respuesta' => 'Token valido.', 'token' => $token], 200);
        } catch (\Throwable $th) {
            (new ExceptionLog())->cargarExcepcion('tokenRecuperarContraseniaValido', $th->getMessage());
            return response()->json(['respuesta' => 'Token no valido.'], 500);
        }
    }

    protected function cambiarContraseña(Request $request)
    {
        try {
            $token = $request->input('token');
            $token = str_replace('%24', '$', $token);
            $pass1 = $request->input('pass1');
            $pass2 = $request->input('pass2');
            if($pass1 != $pass2){
                return response()->json(['respuesta' => 'Las contraseñas no coinciden.'], 400);
            }

            $intento = IntentoRecupero::where('token', $token)->where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->whereNull('deleted_at')->first();
            if(!$intento){
                return response()->json(['respuesta' => 'Token no valido.'], 400);
            }

            $usuario = User::where('email', $intento->email)->first();
            if(!$usuario){
                return response()->json(['respuesta' => 'Token no valido.'], 400);
            }

            $usuario->contrasena = Hash::make($pass1);
            $usuario->save();
            $intento->delete();

            return response()->json(['respuesta' => 'Contraseña actualizada.'], 200);
        } catch (\Throwable $th) {
            (new ExceptionLog())->cargarExcepcion('tokenRecuperarContraseniaValido', $th->getMessage());
            return response()->json(['respuesta' => 'Token no valido.'], 500);
        }
    }




    /////////////////////////////////////////////////////////////////////
    ////////////////////// METODOS PRIVADOS ////////////////////////////
    ////////////////////////////////////////////////////////////////////

    private function _crearUsuario($datos){
        return User::create([
            'idTipo' => 1,
            'email' => $datos['email'],
            'contrasena' =>  Hash::make($datos['contrasena']),
            'fechaRegistro' => Carbon::today(),
            'puntos'=> 0
        ]);
    }

    private function _crearPersonaFisica($idUsuario, $datos){
        return PersonaFisica::create([
            'idUsuario' => $idUsuario,
            'nombre'    => $datos['nombre'],
            'apellido'  => $datos['apellido'],
            'documento' => $datos['documento'],
            'fechaNacimiento' => $datos['fechaNacimiento']
        ]);
    }

    private function generarTokenRecuperoContraseña($email, $idUsuario)
    {
        $numero1 = rand(1000, 99999);
        $token = Hash::make($email[rand(1,5)] . $numero1 . $email[rand(1,5)] . Carbon::now()->toDateTimeString());
        IntentoRecupero::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        
        $cliente = PersonaFisica::where('idUsuario', $idUsuario)->first();
        Mail::to($email)->send(new RecuperarContrasenia($cliente->nombre, $token));
    }

}
