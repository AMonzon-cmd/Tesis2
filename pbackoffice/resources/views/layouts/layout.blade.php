<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>PaydayAdmin | Admin panel</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

  <!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset("assets/$AdminPanel/css/default/app.min.css")}}" rel="stylesheet" />
  <link href="{{ asset("assets/$AdminPanel/css/default/theme/green.min.css")}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->

  <link rel="stylesheet" type="text/css" href="{{ asset("css/Inputs/iconoInterno.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/Inputs/botones.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/Align/alineacion.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/Utilidades/modals.css")}}">
  <link rel="stylesheet" href="{{ asset("css/Inputs/estiloLetras.css") }}">
  <link rel="stylesheet" href="{{asset("css/Complementos/Animaciones/animate.css")}}">

  @yield('styles') <!-- POR SI NECESITO AGREGAR MAS CSS -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<div class="modal fade" id="mantaLoading" tabindex="5" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false">
      <div class="modal-dialog modal-dialog-centered" style="justify-content:center;" role="document">
          <img width="150" src="{{ asset('img/Spin-1s-200px.svg') }}"/>
      </div>
    </div>  
		  <!--inicio de header-->
          @include('layouts/header')
          <!--fin de header-->

          <!--inicio de aside-->
          @include('layouts/asaid')
          <!--fin de aside-->

		<div id="content" class="content">
      <div class="modal fade" id="mdlPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Actualizacion de contraseña</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="txtNuevaPass">Nueva contraseña:</label>
              <div class="form-group m-b-15">
                <input data-toggle="password" name="password" data-placement="after" class="form-control form-control-lg" type="password" value="" placeholder="Contraseña" id="txtNuevaPass" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="actualizarPass()">Actualizar</button>
            </div>
          </div>
        </div>
      </div>
			@yield('contenido')
		</div>
      
    @include('layouts/footer')

	</div>

<!-- ================== BEGIN BASE JS ================== -->
  <script src="{{ asset("assets/$AdminPanel/js/app.min.js")}}"></script>
  <script src="{{ asset("assets/$AdminPanel/js/theme/default.min.js")}}"></script>
  <script src="{{asset("assets/$AdminPanel/plugins/popper/umd/popper.js")}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="{{asset("assets/$AdminPanel/plugins/popper/umd/popper-utils.js")}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script type="text/javascript" src="{{asset("js/UtilScripts/alertas.js")}}"></script>
  <script type="text/javascript" src="{{asset("js/UtilScripts/formatos.js")}}"></script>
  <script src="{{ asset("assets/$AdminPanel/plugins/bootstrap-show-password/dist/bootstrap-show-password.js") }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>

    $(document).ready(function() {    
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    });
    function cambiarPassModal(){
      $("#txtNuevaPass").val('');
      $("#mdlPass").modal('show');
    }

    function actualizarPass(){
      let nuevaPass = $("#txtNuevaPass").val();
      if(nuevaPass.trim().length < 8){
        // la pass debe tener minimo 8 digitos
      }

      Swal.fire({
            title: 'Actualizar contraseña',
            text: '¿Esta seguro de actualizar la contraseña actual?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Actualizar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
              url: '{!! ruta("actualizarPassword") !!}',
              type:'post',
              dataType: "json",
              data:{
                'pass': nuevaPass
              },
              success: function (response) {
                Swal.fire(
                  'Actualizar contraseña',
                  'Operacion realizada correctamente.',
                  'success'
                )
                location.reload();
              },
              statusCode: {
                  400: function(response) {
                    Swal.fire(
                      'Actualizar contraseña',
                      response.responseJSON.respuesta,
                      'error'
                    )
                    //console.log(response);
                  },
                  500: function(response){
                    Swal.fire(
                      'Actualizar contraseña',
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
  </script>
  <!-- ================== END BASE JS ================== -->
  
  @yield('scripts')
</body>
</html>















    