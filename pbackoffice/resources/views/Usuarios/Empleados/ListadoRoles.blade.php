@extends('layouts/layout')

@section('menu-configuracion')
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
            <h1>Listado de Roles</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Configuracion</a></li>
                <li class="breadcrumb-item active">Roles</li>
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
        <button class="btn btn-green text-center col-md-2 col-12 mb-2" onclick="nuevoRol()">+ Nuevo rol</button>
        <table id="equipoTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>Nombre</th>
                <th>Fecha creacion</th>
                <th>En uso</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($roles as $rol)
            <tr>
                <td>
                    {{$rol->nombre}}
                </td>

                <td>
                    {{$rol->created_at}}
                </td>

                <td>
                @if ($rol->seEstaUsando())
                    <span class="text-green"
                    >En uso</span>
                @else
                    <span class="text-red">Inactivo</span>
                @endif
                </td>
            <td class="text-center">
                <a href="{{ruta('listadoPermisos', $rol->id)}}" class="text-secondary">
                    <i class="fas fa-user-edit fa-lg"></i>
                </a>  
            <a data-toggle="tooltip" data-placement="top" title="Dar de baja" class="text-secondary ml-2" onclick="cambiarEstado({{$rol->id}})">
                <i class="fas fa-ban fa-lg"></i>
            </a>  
            </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

<div class="modal fade" id="mdlNuevoRol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                Alta de rol
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="txtNombreRol">Nombre</label>
                <input class="form-control" type="text" name="" id="txtNombreRol">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="ocultar()">Close</button>
                <button type="button" class="btn btn-primary" onclick="ejecutarNuevoRol()">Agregar </button>
            </div>
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
                { className: "text-center align-middle", "targets": [0,1,2,3] },
                { className: "align-middle", "targets": [0,1,2,3] },
              ]
  
      });     
  
  });

  function ocultar()
  {
    $("#mdlNuevoRol").modal('hide');
  }

  function nuevoRol()
  {
    $("#txtNombreRol").val("");
    $("#mdlNuevoRol").modal('show');
  }

  function ejecutarNuevoRol()
  {
    var nombreRol = $("#txtNombreRol").val();
    Swal.fire({
        title: '¿Dar de alta Rol?',
        text: 'Podra asignarlo a los usuarios del sistema',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Agregar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
            url: '{!! ruta("agregarRol") !!}',
            type:'post',
            dataType: "json",
            data:{
            'nombre': nombreRol
            },
            success: function (response) {
            Swal.fire(
                'Alta de rol',
                'Operacion realizada correctamente.',
                'success'
            )
            location.reload();
            },
            statusCode: {
                400: function(response) {
                Swal.fire(
                    'Alta de rol',
                    response.responseJSON.respuesta,
                    'error'
                )
                //console.log(response);
                },
                500: function(response){
                Swal.fire(
                    'Alta de rol',
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

  function cambiarEstado(idRol){
        if(idRol != 0){
          Swal.fire({
            title: '¿Dar de baja Rol?',
            text: 'No podra utilizarlo para asignar a un usuario',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta("eliminarRol") !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idRol
              },
              success: function (response) {
                Swal.fire(
                  'Baja de rol',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                        'Baja de rol',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                     'Baja de rol',
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