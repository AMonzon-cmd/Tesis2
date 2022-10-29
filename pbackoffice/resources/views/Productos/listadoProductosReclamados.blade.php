@extends('layouts/layout')

@section('menu-catalogo')
    active
@endsection

@section('link-catalogo-listado')
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
            <h1>Listado de Productos de catalogo</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Productos Catalogo</a></li>
            </ol>
        </div>
    </div>
</div><!-- /.container-fluid -->
</section>



  <div class="row">
    <div class="panel panel-primary w-100">
      <div class="panel-heading">
        <h4 class="panel-title">Listado de productos reclamados</h4>
        <div class="panel-heading-btn">
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-reload" onclick=""><i class="fa fa-redo"></i></a>
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
      </div>
      <br>
      <a class="ml-3 btn btn-success" href="{{ruta('producto')}}">Nuevo Producto</a>
      <div class="panel-body table-responsive">
        <table id="productosTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>Imagen</th>
                <th>Producto</th>
                <th>Puntaje cobrado</th>
                <th>Estado</th>
                {{-- <th>Acciones</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($reclamos as $reclamo)
              @if($reclamo->deleted_at != null)
                <tr class="table-danger" id="tr{{$reclamo->id}}">
              @else
                <tr id="tr{{$reclamo->id}}">
              @endif
                <td>
                  <img src="{{$reclamo->producto->img}}" alt="" style="max-width: 40px">
                </td>
                <td>
                  {{$reclamo->producto->nombre}}
                </td>

                <td>
                    {{$reclamo->puntos_producto}}
                </td>

                <td>
                  {!! $reclamo->getEstado() !!}
                </td>

                {{-- <td>
                    @if ($reclamo->deleted_at == null && $reclamo->fecha_retiro == null)
                        <a data-toggle="tooltip" data-placement="top" title="Dar de baja" class="text-secondary ml-2"><i class="fas fa-ban fa-lg"></i></a> 
                        <a data-toggle="tooltip" data-placement="top" title="Dar de baja" class="text-secondary ml-2"><i class="fas fa-ban fa-lg"></i></a> 
                    @endif
                </td> --}}
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
      $('#productosTable').DataTable({
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

      function cambiarEstado(idServicio, estadoActual){
        if(idServicio != 0){
          var estaDandoBaja = estadoActual == 'alta';
          Swal.fire({
            title: (estaDandoBaja) ? 'Desea dar de baja el producto' : '¿Desea dar de alta el producto?',
            text: (estaDandoBaja) ? 'No se podra canjear este producto' : 'Se podra canjear el producto',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: (estaDandoBaja) ? 'Bajar producto' : 'Dar de alta',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta('cambiarEstadoProducto') !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idServicio
              },
              success: function (response) {
                Swal.fire(
                  estaDandoBaja ? 'Baja de producto' : 'Alta de producto',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      estaDandoBaja ? 'Baja de producto' : 'Alta de producto',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      estaDandoBaja ? 'Baja de producto' : 'Alta de producto',
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