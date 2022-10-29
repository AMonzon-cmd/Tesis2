<?php

namespace App\Http\Controllers\AjaxController;

use App\Http\Controllers\Controller;
use App\Mail\nuevaPassBackoffice;
use App\Modelos\PersonaEmpleado;
use App\Models\PermisosDeRoles;
use App\Models\Rol;
use App\Models\Usuario;
use App\User;
use App\Utilidades\Constantes;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    protected function AltaEmpleado(Request $request){
        $datos = $request->all();
        // if(!Auth::user()->tienePermiso('alta_empleado')){
        //     return response()->json(['respuesta' => 'No tiene Permisos.'], 400);
        // }
        $this->ValidarDatosEmpleado($datos);
        if ($this->CrearUsuarioEmpleado($datos) != null){
            return response()->json(['respuesta' => 'Alta de usuario exitosa.'], 200);
        }else{
            return response()->json(['respuesta' => 'No se pudo realizar el alta.'], 500);
        }

    }

    protected function ModificarEmpleado(Request $request){
        try{
            $datos = $request->all();
        
            $empleadoModificar = Usuario::findOrFail($datos['id']);
            
            $this->validarDatosModificar($empleadoModificar, $datos);
            $this->modificarDatos($empleadoModificar, $datos);
            return response()->json(['respuesta' => 'Modificacion de usuario exitosa.'], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMEssage()], 500);
        }
    }

    private function validarDatosModificar($empleadoModificar, $datos){
        if($empleadoModificar->email != $datos['email']){
            $empleadoTmp = Usuario::where('email', $datos['email'])->first();

            if($empleadoTmp){
                throw new Exception('El email ya esta siendo utilizado');
            }
        }

        if($empleadoModificar->documento != $datos['documento']){
            $empleadoTmp2 = Usuario::where('documento', $datos['documento'])->first();
            if($empleadoTmp2){
                throw new Exception('El documento ya esta siendo utilizado');
            }
        }
    }

    protected function ActualizarPermisosRoles(Request $request)
    {
        $datos = $request->all();
        PermisosDeRoles::where('rol_id', $datos['id'])->delete();
        foreach ($datos['permisos'] as $key => $permiso) {
            DB::insert("INSERT INTO PermisosDeRoles (rol_id, permiso_id) values ({$datos['id']}, {$permiso})");
        }
        return response()->json(['respuesta' => 'Permisos actualizados.'], 200);
    }

    private function modificarDatos($empleadoModificar, $datos){
        $empleadoModificar->email = $datos['email'];
        $empleadoModificar->nombre = $datos['nombre'];
        $empleadoModificar->apellido = $datos['apellido'];
        $empleadoModificar->documento = $datos['documento'];
        $empleadoModificar->rol_id = $datos['rol'];
        $empleadoModificar->save();
    }

    protected function ValidarDatosEmpleado($datos){
        return Validator::make($datos, [
            'email' => ['required', 'unique:UsuariosBackoffice,email','email'],
            'nombre' => ['required'],
            'documento' => ['required', 'numeric', 'unique:UsuariosBackoffice,documento'],
            'fechaNacimiento' => ['required'],
            'rol' => ['required'],
        ])->validate(); 
    }

    protected function CrearUsuarioEmpleado(array $datos){
        $usuario = Usuario::create([
            'email' => $datos['email'],
            'pass' =>  Hash::make('WelcomePayDay2020'),
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'documento'=> $datos['documento'],
            'rol_id' => $datos['rol'],
            'usuario_genera_id' => Auth::user()->id,
        ]);

        return $usuario;
    }

    protected function cambiarEstadoEmpleado(Request $request){
        try{
            $datos = $request->all();
            if(Auth::user()->id == $datos['id']){
                return response()->json(['respuesta' => 'No puedes darte de baja a ti mismo...'], 400);
            }
            $empleado = Usuario::findOrFail($datos['id']);

            $empleado->deleted_at = ($empleado->deleted_at == null) ? Carbon::now() : null;
            $empleado->save();

            return response()->json(['respuesta' => '.', 'empleado' => $empleado], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    protected function generarNuevaPassword(Request $request){
        try{
            $datos = $request->all();
            $empleado = Usuario::findOrFail($datos['id']);
            $nuevaPass = Str::random(3) . rand(0,19) . Str::random(3) . '#' . rand(0,19);
            $empleado->pass = Hash::make($nuevaPass);
            $empleado->save();

            //enviar mail al empleado
            try{
                Mail::to($empleado->email)->send(new nuevaPassBackoffice($nuevaPass));
            }catch(Exception $e){
                return response()->json(['respuesta' => $e->getMessage()], 400);
            }
            return response()->json(['respuesta' => '.', 'empleado' => $empleado], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    protected function actualizarPassword(Request $request){
        try{
            $datos = $request->all();
            $empleado = Usuario::findOrFail(Auth::user()->id);
            $empleado->pass = Hash::make($datos['pass']);
            $empleado->save();

            return response()->json(['respuesta' => '.', 'empleado' => $empleado], 200);
        }catch(Exception $e){
            return response()->json(['respuesta' => $e->getMessage()], 500);
        }
    }

    protected function CrearRol(Request $request){
        $datos = $request->all();
        $rol = Rol::where('nombre', $datos['nombre'])->first();
        if($rol){
            return response()->json(['respuesta' => 'Ya existe un rol con ese nombre.'], 400);
        }
        Rol::create(['nombre' => $datos['nombre']]);
        return response()->json(['respuesta' => 'Usuario generado.'], 200);
    }

    protected function EliminarRol(Request $request){
        $datos = $request->all();
        $rol = Rol::find($datos['id']);

        if(!$rol){
            return response()->json(['respuesta' => 'No existe el rol.'], 400);
        }

        if ($rol->seEstaUsando()){
            return response()->json(['respuesta' => 'El rol esta siendo utilizado por usuarios del sistema.'], 400);
        }
        $rol->delete();
        return response()->json(['respuesta' => 'Rol dado de baja.'], 200);
    }

    // public function GenerarPersonaEmpleado(int $idUsuario,array $datos){
    //     $empleado = PersonaEmpleado::create([
    //         'IdUsuario' => $idUsuario,
    //         'Nombre' => $datos['nombre'],
    //         'Apellido' => $datos['apellido'],
    //         'Documento' => $datos['documento'],
    //         'Sexo' => $datos['sexo'],
    //         'FechaNacimiento' => $datos['fechaNacimiento'],
    //         'IdRol' => $datos['rol'],
    //     ]);
    // }
}
