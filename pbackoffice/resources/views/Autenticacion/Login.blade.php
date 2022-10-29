<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Payday Admin | Login</title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- ================== CSS BASE ================== -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link href="{{ asset("assets/$AdminPanel/css/default/app.min.css")}}" rel="stylesheet" />
		<link href="{{ asset("assets/$AdminPanel/css/default/theme/green.min.css")}}" rel="stylesheet" />
		<!-- ================== FIN BASE CSS ================== -->
	</head>
	<body class="pace-top">	
		<div id="page-container" class="fade">
			<div class="login login-with-news-feed">
				<div class="news-feed">
				<div class="news-image" style="background-image: url({{asset('img/login-bg-9.jpg')}})"></div>
					<div class="news-caption">
						<h4 class="caption-title"><b>Payday</b> App</h4>
						<p>
							La mejor forma de pagar tus cuentas
						</p>
				</div>
			</div>
			<div id="cajita" class="right-content">
				<div class="login-header">
					<div class="brand">
						<h3>PAYDAY</h3>
						{{-- <img class="col-12 p-0 mb-5" src="{{ asset('img/LogoFondoTransparente.png')}}" alt=""> --}}
						<small>Bienvenido, inicia sesión</small>
					</div>			
				</div>
				<div class="login-content">
					<form action="{{ruta('iniciarSesion')}}" onsubmit="return IniciarSesion()" method="GET" class="margin-bottom-0">
						<div class="form-group m-b-15">
							<input type="text" name="email" class="form-control form-control-lg" placeholder="Email" required />
						</div>
						<div class="form-group m-b-15">
							<input data-toggle="password" name="password" data-placement="after" class="form-control form-control-lg" type="password" value="" placeholder="Contraseña" required />
						</div>
						@if ($errors->any())
							<div id="errorLogin" class="text-red mb-1">						
									{!! $errors->first() !!}							
							</div>		
							<!-- SCRIPT DE ERROR -->				
							<script>
								window.setTimeout(function() {
									$("#errorLogin").fadeTo(500, 0).slideUp(500, function(){
										$(this).remove(); 
									});
								}, 8000);
							</script>  
						@endif
						<div class="checkbox checkbox-css m-b-30">
							<input type="checkbox" id="remember_me_checkbox" value="" />
							<label for="remember_me_checkbox">
							Recordarme
							</label>
						</div>	
						<div class="login-buttons text-center">
                            <button type="submit" class="btn btn-success btn-block btn-lg mb-2"><span id="iconoIniciar">Iniciar <i class="fa fa-sign-in-alt ml-2 fa-lg"></i></span> 
							</button>
                            {{-- <a href="#">Olvidé mi contraseña</a> --}}
						</div>
                        <div class=" text-inverse">						
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- end login -->

	

		<!-- begin scroll to top btn -->

		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

		<!-- end scroll to top btn -->

	</div>

	<!-- end page container -->

	

	<!-- ================== BEGIN BASE JS ================== -->

	<script src="{{ asset("assets/$AdminPanel/js/app.min.js")}}"></script>

	<script src="{{ asset("assets/$AdminPanel/js/theme/default.min.js")}}"></script>

	<script src="{{ asset("assets/$AdminPanel/plugins/bootstrap-show-password/dist/bootstrap-show-password.js") }}"></script>

	<!-- ================== END BASE JS ================== -->

	<script>

		function IniciarSesion(){

			$("#iconoIniciar").html('<i class="fas fa-circle-notch fa-spin fa-lg"></i>');
			return true;
		}

	</script>



</body>

</html>