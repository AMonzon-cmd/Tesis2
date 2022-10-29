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
      
      <div class="panel-body">
        <div class="row ml-4">
          @foreach ($permisos as $permiso)
          <div class="form-check col-6 ml-4 m-auto">
            <div class="justify-content-center">
            <input class="form-check-input" type="checkbox" value="{{$permiso->id}}" id="chk{{$permiso->id}}" {{in_array($permiso->id, $permisosRol) ? 'checked' : ''}}>
            <label class="form-check-label" for="flexCheckDefault">
              {{$permiso->nombre}}
            </label>
            </div>
          </div>
          @endforeach
      </div>
      <div class="row mt-2">
        <button class="btn btn-green col-12 mt-2" onclick="actualizarPermisos({{$idRol}})">Actualizar</button>
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


  function actualizarPermisos(idRol)
  {
    var permisos = [];
    $('input[type=checkbox]').each(function () {
        if($(this).prop('checked')){
          permisos.push($(this).val());
        }
    });
    Swal.fire({
        title: 'Actualizar permisos',
        text: 'Los usuarios con el rol se veran afectados',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Agregar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
            url: '{!! ruta("actualizarPermisos") !!}',
            type:'post',
            dataType: "json",
            data:{
            'permisos': permisos,
            'id': idRol
            },
            success: function (response) {
            Swal.fire(
                'Actualizar permisos',
                'Operacion realizada correctamente.',
                'success'
            )
            location.reload();
            },
            statusCode: {
                400: function(response) {
                Swal.fire(
                    'Actualizar permisos',
                    response.responseJSON.respuesta,
                    'error'
                )
                //console.log(response);
                },
                500: function(response){
                Swal.fire(
                    'Actualizar permisos',
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