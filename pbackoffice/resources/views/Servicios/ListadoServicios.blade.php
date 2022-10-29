@extends('layouts/layout')

@section('menu-servicios')
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
            <h1>Listado de Servicios</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Servicios</a></li>
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
      <br>
      <button class="ml-3 btn btn-success" data-toggle="modal" data-target="#mdlServicio" onclick="resetearId()">Crear Servicio +</button>
      <div class="panel-body table-responsive">
        <table id="serviciosTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>Logo</th>
                <th>Servicio</th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Editar</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($servicios as $servicio)
              @if($servicio->deleted_at != null)
                <tr class="table-danger" id="tr{{$servicio->id}}">
              @else
                <tr id="tr{{$servicio->id}}">
              @endif
                <td>
                  <img src="{{$servicio->logo}}" alt="" style="max-width: 40px">
                </td>
                <td>
                  {{$servicio->nombre}}
                </td>
                <td>
                    {{$servicio->descripcion}}
                </td>

                <td>
                    @if ($servicio->deleted_at == null)
                        <span class="text-green">Activo</span>
                    @else
                        <span class="text-red">Inactivo</span>
                    @endif
                </td>
        
            <td class="text-center pt-3">
              <a data-toggle="modal" data-target="#mdlServicio" href="javascript:;" onclick="mostrarModificarServicio({{$servicio->id}}, '{{$servicio->nombre}}', '{{$servicio->descripcion}}', '{{$servicio->logo}}')" class="text-secondary mt-1"><i class="fas fa-user-edit fa-lg"></i></a>
              @if ($servicio->deleted_at == null)
                <a href="javascript:;" onclick="cambiarEstado({{$servicio->id}}, 'alta')" class="text-danger ml-2 mt-1"><i class="fas fa-ban fa-lg"></i></a>
              @else
                <a href="javascript:;" onclick="cambiarEstado({{$servicio->id}}, 'baja')" class="text-success ml-2 mt-1"><i class="fas fa-check-circle fa-lg"></i></a>
              @endif
            </td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="mdlServicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="txtIdServicio" value="" hidden>
            <div class="col-12">
              <label for="txtNombre">Nombre servicio</label>
              <input class="form-control" type="text" placeholder="" name="nombre" id="txtNombre">
            </div>

            <div class="col-12">
              <label for="txtDescripcion">Descripción:</label>
              <textarea class="form-control" name="descripcion" id="txtDescripcion" cols="10" rows="3"></textarea>
            </div>

            <div class="col-12">
              <label for="">Logo</label>
              <input class="form-control" type="text" placeholder="" name="logo" id="txtLogo">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
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
      $('#serviciosTable').DataTable({
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
              ]
  
      });   
      
      $("#btnGuardar").click(altaServicio);
  });
  
      function altaServicio(){
        let nombre = $("#txtNombre").val().trim();
        let logo  = $("#txtLogo").val().trim();
        let des = $("#txtDescripcion").val().trim();
        let idServicio = $("#txtIdServicio").val();

        if(nombre == ""){
          Swal.fire(
            'Debe escribir un nombre', '',
            'error'
          );
          return;
        }

        if(logo == ""){
          valido = false;
          Swal.fire(
            'Debe cologar un logo', '',
            'error'
          );
          return;
        }
        $("#btnGuardar").html('Guardando...');
        if($("#txtIdServicio").val() == ""){
          $.ajax({
            url: '{!! ruta('servicio') !!}',
            type:'post',
            dataType: "json",
            data:{
				      'nombre': nombre, 'logo': logo, 'descripcion': des
			      },
            success: function (response) {
              $("#btnGuardar").html('Guardar');
              Swal.fire(
                'Alta de servicio generada',
                '',
                'sucess'
              );
              location.reload();
            },
            statusCode: {
                400: function(response) {
                  $("#btnGuardar").html('Guardar');
                  Swal.fire(
                    'Error al dar de alta',
                    response.responseJSON.respuesta,
                    'error'
                  )
                  console.log(response);
                },
                500: function(response){
                  $("#btnGuardar").html('Guardar');
                  console.log(response);
                }
            }
			    });
        }
        else{
          $.ajax({
            url: '{!! ruta('modificarServicio') !!}',
            type:'post',
            dataType: "json",
            data:{
				      'id': idServicio, 'nombre': nombre, 'logo': logo, 'descripcion': des
			      },
            success: function (response) {
              $("#btnGuardar").html('Guardar');
              Swal.fire(
                'Se modifico el servicio correctamente',
                '',
                'success'
              );
              location.reload();
            },
            statusCode: {
                400: function(response) {
                  $("#btnGuardar").html('Guardar');
                  Swal.fire(
                    'Error modificar servicio',
                    response.responseJSON.respuesta,
                    'error'
                  )
                  console.log(response);
                },
                500: function(response){
                  $("#btnGuardar").html('Guardar');
                  console.log(response);
                }
            }
			    });
        }

    }

      function mostrarModificarServicio(servicio, nombre, descripcion, logo){
        $("#txtIdServicio").val(servicio);
        $("#txtNombre").val(nombre);
        $("#txtDescripcion").val(descripcion);
        $("#txtLogo").val(logo);
      }

      function resetearId(){
        $("#txtIdServicio").val('');
        $("#txtNombre").val("");
        $("#txtDescripcion").val("");
        $("#txtLogo").val("");
      }

      function cambiarEstado(idServicio, estadoActual){
        if(idServicio != 0){
          var estaDandoBaja = estadoActual == 'alta';
          Swal.fire({
            title: (estaDandoBaja) ? 'Desea dar de baja el servicio' : '¿Desea dar de alta el servicio?',
            text: (estaDandoBaja) ? 'No se podran realizar pagos a este servicio' : 'Se podran hacer pagos a este servicio',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: (estaDandoBaja) ? 'Bajar servicio' : 'Dar de alta',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta('cambiarEstadoServicio') !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idServicio
              },
              success: function (response) {
                Swal.fire(
                  estaDandoBaja ? 'Baja de servicio' : 'Alta de servicio',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      estaDandoBaja ? 'Baja de servicio' : 'Alta de servicio',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      estaDandoBaja ? 'Baja de servicio' : 'Alta de servicio',
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