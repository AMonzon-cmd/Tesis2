<?php

namespace App\Http\Controllers;

use App\Modelos\PersonaEmpleado;
use App\Models\PermisosDeRoles;
use App\Models\Rol;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    protected function AltaUsuario(Request $request){
        return response()->json(['respuesta' => 'Usuario generado.'], 200);
            $datos = $request->all();
            $this->ValidarDatosEmpleado($datos);
            $usuario = $this->CrearUsuario($datos);
            return response()->json(['respuesta' => 'Usuario generado.'], 200);
        }

    protected function ListadoEquipo(){
        return response()->json(['Equipo' => User::where('IdTipoUsuario', 3)->with('Empleado')->get()], 200);
    }

    protected function ListadoClientes(){
        return response()->json(['Clientes' => User::where('IdTipoUsuario', 1)->with('PersonaFisica')->get()], 200);
    }


    protected function CrearUsuario(array $datos){
        
        $usuario = User::create([
            'Email' => $datos['email'],
            'Password' => Hash::make("Bienvenido2020"),
            'FechaRegistro' => Carbon::now(),
            'Activo' => 1,
            ]); 
            $this->CrearPersonaEmpleado($datos, $usuario);

        return $usuario;
    }

    

    protected function PermisosRol(Request $request){
        $datos = $request->all();
        $permisos = PermisosDeRoles::where('rol_id', $datos['id'])->get();
        return response()->json(['respuesta' => 'Listado de Roles.', 'permisos' => $permisos], 200);
    }

    protected function CrearPersonaEmpleado(array $datos, User $usuario){
        PersonaEmpleado::create([
            'Nombre' => $datos['nombre'],
            'Apellido' => $datos['apellido'],
            'Documento' => $datos['documento'],
            'Sexo' => $datos['sexo'],
            'FechaNacimiento' => $datos['fechaNacimiento'],
            'IdRol' => $datos['rol'],
        ]);
    }

    protected function ValidarDatosEmpleado(array $datos){
        return Validator::make($datos, [
            'email' => ['required','unique:Usuarios,Email','email:rfc,dns'],
            'nombre' => ['required'],
            'apellido' => ['required'],
            'documento' => ['required', 'numeric'], 
            'fechaNacimiento' => ['required'], 
            'sexo' => ['required'], 
            'rol' => ['required', 'numeric', 'exists:Roles,IdRol'],

        ])->validate(); 

    }

    

}
