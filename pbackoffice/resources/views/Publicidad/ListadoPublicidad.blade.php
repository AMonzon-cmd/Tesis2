@extends('layouts/layout')

@section('menu-publicidad')
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
            <h1>Listado de Publicidades</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Publicidad</a></li>
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
      <button class="ml-3 btn btn-success" data-toggle="modal" data-target="#mdlServicio" onclick="resetearId()">Nueva Publicidad +</button>
      <div class="panel-body table-responsive">
        <table id="serviciosTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>imagen</th>
                <th>link</th>
                <th>Usuario Carga</th>
                <th>Desde/Hasta</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($publicidades as $publicidad)
              @if($publicidad->deleted_at != null)
                <tr class="table-danger" id="tr{{$publicidad->id}}">
              @else
                <tr id="tr{{$publicidad->id}}">
              @endif
                <td>
                  <a href="{{$publicidad->img}}"><img src="{{$publicidad->img}}" alt="" style="max-width: 150px"></a>
                </td>
                <td>
                    @if($publicidad->url == null || $publicidad->url == "")
                        <span class="text-danger">SIN LINK</span>
                    @else
                        {{$publicidad->url}}
                    @endif
                  
                </td>
                <td>
                    {{$publicidad->usuario->getNombre()}}
                </td>
                <td>
                    {{$publicidad->fecha_desde  . "-" . $publicidad->fecha_hasta}}
                </td>
            <td class="text-center pt-3">
              @if ($publicidad->deleted_at == null)
                <a href="javascript:;" onclick="cambiarEstado({{$publicidad->id}}, 'alta')" class="text-danger ml-2 mt-1"><i class="fas fa-ban fa-lg"></i></a>
              @else
                <a href="javascript:;" onclick="cambiarEstado({{$publicidad->id}}, 'baja')" class="text-success ml-2 mt-1"><i class="fas fa-check-circle fa-lg"></i></a>
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
          <h5 class="modal-title" id="exampleModalLongTitle">Nueveva publicidad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="row justify-content-center mb-2">
                <div class="col-5">
                    <label for="">fecha Desde</label>
                    <input class="form-control" type="date" placeholder="" name="desde" id="desde">
                  </div>
                  <div class="col-5">
                      <label for="">fecha Hasta</label>
                      <input class="form-control" type="date" placeholder="" name="logo" id="hasta">
                    </div>
            </div>
            <input type="text" id="txtIdServicio" value="" hidden>
            <div class="col-12">
              <label for="img">Url imagen</label>
              <input class="form-control" type="text" placeholder="" name="nombre" id="img">
            </div>

            <div class="col-12 mb-1">
              <label for="url">link redireccion:</label>
              <input class="form-control" name="descripcion" id="url" type="text"/>
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
        let desde = $("#desde").val();
        let hasta =  $("#hasta").val();
        let img =  $("#img").val().trim();
        let url = $("#url").val().trim();

        if(img == ""){
          Swal.fire(
            'Debes indicar la url de la imagen', '',
            'error'
          );
          return;
        }

        if(desde == ""){
          Swal.fire(
            'Debes indicar una fecha desde que inicia la publicidad.', '',
            'error'
          );
          return;
        }

        if(hasta == ""){
          Swal.fire(
            'Debes indicar una fecha hasta que estara la publicidad.', '',
            'error'
          );
          return;
        }

        if($("#hasta").val() < $("#desde").val())
        {
            Swal.fire(
            'La fecha hasta no puede ser menor a la fecha de comienzo', '',
            'error'
          );
          return;
        }

        $("#btnGuardar").html('Guardando...');
        if($("#txtIdServicio").val() == ""){
          $.ajax({
            url: '{!! ruta('altaPublicidad') !!}',
            type:'post',
            dataType: "json",
            data:{
				      'desde': desde, 'hasta': hasta, 'img': img, 'link': url
			      },
            success: function (response) {
              $("#btnGuardar").html('Guardar');
              Swal.fire(
                'Alta de publicidad generada',
                '',
                'success'
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
            title: (estaDandoBaja) ? 'Desea dar de baja la publicidad' : '¿Desea habilitar la publicidad?',
            text: (estaDandoBaja) ? 'No se visualizara la publicdad en la pagina' : 'Los clientes visualizaran la publicidad',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: (estaDandoBaja) ? 'Deshabilitar publicidad' : 'Habilitar publicidad',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta('modificarPublicidad') !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idServicio
              },
              success: function (response) {
                Swal.fire(
                  estaDandoBaja ? 'Deshabilitar publicidad' : 'Habilitar publicidad',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      estaDandoBaja ? 'Deshabilitar publicidad' : 'Habilitar publicidad',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      estaDandoBaja ? 'Deshabilitar publicidad' : 'Habilitar publicidad',
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