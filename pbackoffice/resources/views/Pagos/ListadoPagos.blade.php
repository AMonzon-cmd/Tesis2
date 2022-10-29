@extends('layouts/layout')

@section('menu-pagos')
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
      <div class="panel-body table-responsive">
        <table id="serviciosTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
                <th>Servicio</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Puntos</th>
                <th>Estado</th>
                <th>Accion</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pagos as $pago)
              @if($pago->estado == 'Anulado')
                <tr class="table-danger"> 
              @else
                <tr>
              @endif
            
                <td>
                  {{$pago->servicio->nombre}}
                </td>
                <td>
                    {{$pago->cliente->datos->nombre . " " . $pago->cliente->datos->apellido}} - (CI: {{$pago->cliente->datos->documento}})
                </td>

                <td>
                    {{$pago->moneda->simbolo . " " . $pago->monto}}
                </td>

                <td>
                    {{$pago->puntaje_generado}}
                </td>

                <td>
                    @if ($pago->estado == "Confirmado")
                        <span class="text-green">Confirmado</span>
                    @else
                      @if($pago->estado == "Pendiente")
                        <span class="text-yellow">Pendiente</span>
                      @else
                        <span class="text-red">Anulado</span>
                      @endif
                    @endif
                </td>
        
            <td class="text-center">
              @if($pago->estado != 'Anulado')
                <a href="javascript:;" class="text-red" onclick="anularPago({{$pago->id}}, {{$pago->usuario_id}})"><i class="fas fa-ban fa-lg"></i></a>  
              @endif
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
                { className: "text-center align-middle", "targets": [0,1,2,3,4,5] },
              ]
  
      });
  });
  
  function anularPago(idPago, idUsu){
        if(idPago != 0){
          Swal.fire({
            title: '¿Desea anular el pago?',
            text: "Se notificara al cliente de la anulacion",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, anular',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta('anularPagoAjax') !!}',
              type:'post',
              dataType: "json",
              data:{
                'id': idPago, 'usuario_id': idUsu
              },
              success: function (response) {
                Swal.fire(
                'Anulacion',
                'Se anulo el pago solicitado.',
                'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      'Anulacion',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      'Anulacion',
                      'Error al realizar la anulacion.',
                      'danger'
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