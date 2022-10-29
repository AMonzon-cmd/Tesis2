@extends('layouts/layout')

@section('menu-usuarios')
    active
@endsection

@section('link-usuarios-equipo')
    active
@endsection


@section('styles')

  <style>
    .badge:hover{
      cursor: pointer; 
    }

    .link{
      cursor:pointer;
    }
  </style>

	<link href="{{asset("assets/$AdminPanel/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}" rel="stylesheet" />
	<link href="{{asset("assets/$AdminPanel/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css") }}" rel="stylesheet" />
	<link href="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css") }}" rel="stylesheet" />

@endsection


@section('contenido')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de Empleados</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                <li class="breadcrumb-item active">Listado Equipo</li>
            </ol>
        </div>
    </div>
</div><!-- /.container-fluid -->
</section>



  <div class="row">
    <div class="panel panel-primary w-100">
      <div class="panel-heading">
        <h4 class="panel-title">Listado</h4>
        <div class="panel-heading-btn">
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-reload" onclick="RecargarClientes();"><i class="fa fa-redo"></i></a>
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
      </div>
      <div class="panel-body table-responsive">
        <table id="equipoTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>Nombre Completo</th>
                <th>Documento</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Ver/Editar</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($empleados as $empleado)
            <tr>
                <td>
                  {{$empleado->nombre . " " . $empleado->apellido}}
                </td>

                <td>
                    {{$empleado->documento}}
                </td>
                <td>
                    {{$empleado->email}}
                </td>
                <td class="text-center">
                    {{$empleado->Rol->nombre}}
                </td>
                <td class="text-center">

                @if ($empleado->deleted_at == null)
                    <span class="text-green">Activo</span>
                @else
                    <span class="text-red">Inactivo</span>
                @endif

            </td>
            <td class="text-center">
            <a href="{{ruta('modificarEmpleado', $empleado->id)}}" class="text-secondary"><i class="fas fa-user-edit fa-lg"></i></a>  
            <a data-toggle="tooltip" data-placement="top" href="javascript:;" title="Generar nueva Password" onclick="regenerarContraeña({{$empleado->id}})" class="text-secondary ml-2"><i class="fas fa-unlock-alt fa-lg"></i></a> 
            <a data-toggle="tooltip" data-placement="top" title="Dar de baja" onclick="cambiarEstado({{$empleado->id}}, {{$empleado->estaDeBaja()}})" class="text-secondary ml-2"><i class="fas fa-ban fa-lg"></i></a>  
            </td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

<script src="{{asset("assets/$AdminPanel/plugins/datatables.net/js/jquery.dataTables.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-responsive/js/dataTables.responsive.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons/js/dataTables.buttons.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons/js/buttons.colVis.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons/js/buttons.flash.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons/js/buttons.html5.min.js") }}"></script>
<script src="{{asset("assets/$AdminPanel/plugins/datatables.net-buttons/js/buttons.print.min.js") }}"></script>

<script>

  

    $(document).ready(function() {    
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('#equipoTable').DataTable({
        pageLength: 25,
        lengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'Todos']],
      //para cambiar el lenguaje a español
  
          "language": {
  
                  "lengthMenu": "Mostrar _MENU_ registros",
  
                  "zeroRecords": "No se encontraron resultados",
  
                  "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
  
                  "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
  
                  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
  
                  "sSearch": "Buscar:",
  
                  "oPaginate": {
  
                      "sFirst": "Primero",
  
                      "sLast":"Último",
  
                      "sNext":"Siguiente",
  
                      "sPrevious": "Anterior"
  
                   },
  
                   "sProcessing":"Procesando...",
  
              },
              "columnDefs": [
                { className: "text-center align-middle", "targets": [3,4,5] },
                { className: "align-middle", "targets": [0,1,2] },
              ]
  
      });     
  
  });

  

  function cambiarEstado(idCliente, estadoActual){
        if(idCliente != 0){
          var estaDandoBaja = !estadoActual;
          Swal.fire({
            title: (estaDandoBaja) ? 'Desea dar de baja el empleado' : '¿Desea habilitar el empleado?',
            text: (estaDandoBaja) ? 'El empleado no podra utilizar el backoffice' : 'El empleado podra volver a utilizar el backoffice',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: (estaDandoBaja) ? 'Deshabilitar empleado' : 'Habilitar empleado',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta("cambiarEstadoEmpleado") !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idCliente
              },
              success: function (response) {
                Swal.fire(
                  estaDandoBaja ? 'Deshabilitar empleado' : 'Habilitar empleado',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      estaDandoBaja ? 'Deshabilitar empleado' : 'Habilitar empleado',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      estaDandoBaja ? 'Deshabilitar empleado' : 'Habilitar empleado',
                      'Error al realizar la operacion.',
                      'error'
                    )
                    //console.log(response);
                  }
              }
            });
            }
          })
        }
      }

      function regenerarContraeña(idCliente){
        if(idCliente != 0){
          Swal.fire({
            title: 'Regenerar contraseña',
            text: '¿Esta seguro de regenerar la contraseña al usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Regenerar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta("generarNuevaPassword") !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idCliente
              },
              success: function (response) {
                Swal.fire(
                  'Regenerar contraseña',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      'Regenerar contraseña',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      'Regenerar contraseña',
                      'Error al realizar la operacion.',
                      'error'
                    )
                    //console.log(response);
                  }
              }
            });
            }
          })
        }
      }
  
 
  
  </script>

@endsection