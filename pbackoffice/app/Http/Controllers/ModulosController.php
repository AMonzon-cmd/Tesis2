<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Permiso;
use App\Models\PermisosDeRoles;
use App\Models\Publicidad;
use App\Models\ReclamoProducto;
use App\Models\Rol;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ModulosController extends Controller
{
    protected function Dashboard(){
        $dashboard = new stdClass();
        $dashboard->pagosDelDia = Pago::whereDate('created_at', Carbon::now())->where('estado', '!=', 'Anulado')->count();
        $dashboard->pagosTotales = Pago::where('estado', '!=', 'Anulado')->count();
        $dashboard->pagosAnulados = Pago::where('estado', 'Anulado')->count();
        $dashboard->clientesNuevos = Cliente::whereDate('created_at', Carbon::now())->whereNull('deleted_at')->count();
        $serviciosPagos = $this->getServiciosPagados();
        $dashboard->pagosPopulares = $serviciosPagos->servicios;
        $dashboard->cantidadPagosPopulares = $serviciosPagos->cantidad;
        
        $pagosPorFechas = $this->getPagosPorFechas();
        $dashboard->fechasPagos = $pagosPorFechas->fechas;
        $dashboard->valoresPagos = $pagosPorFechas->cantidades;
        
        return view("Dashboard", compact('dashboard'));
    }

    private function getServiciosPagados()
    {
        $datos = DB::select('SELECT COUNT(Pagos.id) AS cantidad, Servicios.nombre 
        FROM Pagos
        INNER JOIN Servicios ON Servicios.id = Pagos.servicio_id
        WHERE Pagos.deleted_at IS NULL
        GROUP BY Pagos.servicio_id');

        $pagos = new stdClass();
        $pagos->servicios = [];
        $pagos->cantidad = [];
        foreach($datos as $dato){
            $pagos->cantidad[] = $dato->cantidad;
            $pagos->servicios[] = $dato->nombre;
        }

        return $pagos;
    }

    private function getPagosPorFechas()
    {
        $datos = DB::select('SELECT COUNT(0) AS cantidad, DATE(Pagos.created_at) as fecha
        FROM Pagos 
        WHERE Pagos.deleted_at IS NULL 
        AND MONTH(Pagos.created_at) = MONTH(NOW())
        AND YEAR(Pagos.created_at) = YEAR(NOW())
        GROUP BY date(Pagos.created_at)
        ORDER BY date(Pagos.created_at) ASC');

        $pagos = new stdClass();
        $pagos->cantidades = [];
        $pagos->fechas = [];
        foreach($datos as $dato){
            $pagos->cantidades[] = $dato->cantidad;
            $pagos->fechas[] = $dato->fecha;
        }

        return $pagos;
    }

    protected function AltaEmpleado(){

        if(!Auth::user()->Rol->tienePermiso(11)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $roles = Rol::whereNull('deleted_at')->get();
        return view("Usuarios.Empleados.ABMUsuario", compact("roles"));
    }

    protected function ModificarEmpleado($idUsuario){
        if(!Auth::user()->Rol->tienePermiso(11)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $roles = Rol::whereNull('deleted_at')->get();
        $usuario = Usuario::where('id', $idUsuario)->first();

        return view("Usuarios.Empleados.ABMUsuario", compact("roles", "usuario"));
    }

    protected function ListadoEmpleados(){
        if(!Auth::user()->Rol->tienePermiso(13)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $empleados = Usuario::all();
        return view("Usuarios.Empleados.ListadoEmpleados", compact("empleados"));
    }

    protected function ListadoClientes(){
        if(!Auth::user()->Rol->tienePermiso(1)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $clientes = Cliente::where('tipo', 1)->with('datos')->get();
        return view("Usuarios.Clientes.ListadoClientes", compact("clientes"));
    }

    protected function ModificarCliente($idUsuario){
        if(!Auth::user()->Rol->tienePermiso(14)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $usuario = Cliente::find($idUsuario);
        return view("Usuarios.Clientes.ModificarCliente", compact("usuario"));
    }

    protected function ListadoServicios(){
        if(!Auth::user()->Rol->tienePermiso(2)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $servicios = Servicio::all();
        return view("Servicios.ListadoServicios", compact("servicios"));
    }

    protected function ListadoPagos(){
        if(!Auth::user()->Rol->tienePermiso(6)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $pagos = Pago::all();
        return view('Pagos.ListadoPagos', compact('pagos'));
    }

    protected function ListarPagosCliente($idUsuario){
        if(!Auth::user()->Rol->tienePermiso(6)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $pagos = Pago::where('usuario_id', $idUsuario)->get();
        return view('Pagos.ListadoPagos', compact('pagos'));
    }

    protected function ListarCanjesCliente($idUsuario){
        if(!Auth::user()->Rol->tienePermiso(6)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $reclamos = ReclamoProducto::where('usuario_id', $idUsuario)->get();
        return view('Productos/listadoProductosReclamados', compact('reclamos'));
    }

    protected function AltaProductoCatalogo(){
        if(!Auth::user()->Rol->tienePermiso(4)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        return view('Productos.Producto');
    }

    protected function ListadoPublicidad(){
        if(!Auth::user()->Rol->tienePermiso(8)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $publicidades = Publicidad::all();
        return view('Publicidad.ListadoPublicidad', compact('publicidades'));
    }

    protected function ListadoRoles()
    {
        if(!Auth::user()->Rol->tienePermiso(15)){
            return redirect('http://www.payday.com.uy/backoffice');
        }
        $roles = Rol::all();
        return view("Usuarios.Empleados.ListadoRoles", compact('roles'));
    }

    protected function ListadoPermisosRoles(int $idrol)
    {
        if(!Auth::user()->Rol->tienePermiso(16)){
            return redirect('http://www.payday.com.uy/backoffice');
        }

        $idRol = $idrol;
        $permisos = Permiso::all();
        $permisosRol = DB::table('PermisosDeRoles')->where('rol_id', $idrol)->pluck('permiso_id')->toArray();
        return view("Usuarios.Empleados.ListadoPermisosRol", compact('permisos', 'permisosRol', 'idRol'));
    }
    
    
}
