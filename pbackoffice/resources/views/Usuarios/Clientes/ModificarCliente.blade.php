@extends('layouts/layout')

@section('menu-usuarios')
    active
@endsection

@section('link-usuarios-generar')
    active
@endsection


@section('contenido')  

 <!-- CUERPO DE LA PAGINA-->

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Cliente</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Cliente</a></li>
            <li class="breadcrumb-item"><a href="{{ruta('clientes')}}">Listado de Clientes</a></li>
            <li class="breadcrumb-item active">Editar Cliente</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <div class="row">
    <div class="col-12 p-0">
      <div class="card card-primary">
        <div class="card-header pb-0">
          <a class="float-right align-middle mt-1" href="{{ruta('clientes')}}"><i class="fas fa-arrow-alt-circle-left fa-lg"></i> Ir al listado</a>
          <input type="text" value="{{$usuario->IdUsuario}}"  id="idUsuario" hidden>   
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <input type="text" id="txtId" value="{{$usuario->id}}" hidden>
          <input type="text" id="urii" value="{{ruta('modificarClienteAjax')}}" hidden>
          <div class="row">
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputEmail1">Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text d-none d-sm-block"><i class="fas fa-envelope"></i></span>
                </div>
                <input required type="email" value="{{$usuario->email}}" class="form-control" id="txtEmail" placeholder="Ingresa un correo" name="email" onblur="casillaCorreo();">
              </div>
            </div>
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputEmail1">Fecha Nacimiento</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input readonly type="date" value="{{$usuario->datos->fechaNacimiento}}" class="form-control" id="dtpFechaNacimiento" placeholder="Ingresa la fecha de nacimiento" name="fechaNacimiento" onblur="casillaFechaNac();">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputPassword1">Nombre</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                </div>
                <input readonly type="text" value="{{$usuario->datos->nombre}}" class="form-control" id="txtNombre" placeholder="Nombre del Cliente" name="nombre" onblur="casillaNombre();">
              </div>
            </div>
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputPassword1">Apellido</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                </div>
                <input readonly type="text" value="{{$usuario->datos->apellido}}" class="form-control" id="txtApellido" placeholder="Apellido" name="apellido" onblur="casillaApellido();">
              </div>        
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputPassword1">Documento</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                  </div>
                  <input type="text" value="{{$usuario->datos->documento}}" class="form-control" id="txtDocumento" placeholder="Documento" name="documento" onblur="casillaApellido();">
                </div>                  
            </div>

            <div class="form-group col-12 col-md-6">
                <label for="exampleInputPassword1">Puntaje</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" value="{{$usuario->puntos}}" class="form-control" id="txtPuntaje" placeholder="Documento" name="documento" onblur="casillaApellido();">
                  </div>                  
              </div>
          </div>
        </div>
        <!-- form start -->
        <form role="form" id="formularioNuevoCliente">
          <div class="card-body">                  
          </div><!-- /.card-body -->
          <div id="pnlPieBotones" class="card-footer text-right">
            <a href="{{ruta('clientes')}}" class="btn btn-success m-auto col-12 col-md-6 col-xl-3">Volver</a>
            <button type="button" id="btnModificarCliente" class="btn btn-green m-auto col-12 col-md-6 col-xl-3">Actualizar</button>
          </div>
        </form>
      </div><!-- /.card -->
    </div>
  </div>

@endsection





  @section('scripts')
    <script src="{{ asset('js/Usuarios/Cliente.js') }}"></script>     

    <script src="{{ asset('js/UtilScripts/validacionesGenerales.js') }}"></script>

    
  @endsection
