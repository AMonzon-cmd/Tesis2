@extends('layouts/layout')

@section('menu-usuarios')
    active
@endsection

@section('link-usuarios-generar')
    active
@endsection


@section('contenido')  

 <!-- CUERPO DE LA PAGINA-->

@isset($usuario)
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Empleado</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Cliente</a></li>
            <li class="breadcrumb-item"><a href="{{ruta('listadoEmpleados')}}">Listado Equipo</a></li>
            <li class="breadcrumb-item active">Editar Empleado</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

@else

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Generar Empleado</h1>
        </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Generar Empleado</li>
        </ol>
      </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

@endisset
    
@isset($usuario)

  <!-- Main content -->
  <div class="row">
    <div class="col-12 p-0">
      <div class="card card-primary">
        <div class="card-header pb-0">
          <a class="float-right align-middle mt-1" href="{{ruta('listadoEmpleados')}}"><i class="fas fa-arrow-alt-circle-left fa-lg"></i> Ir al listado</a>
          <input type="text" value="{{$usuario->IdUsuario}}"  id="idUsuario" hidden>   
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <input type="text" id="txtId" value="{{$usuario->id}}" hidden>
          <input type="text" id="urii" value="{{ruta('ModificarEmpleadoAjax')}}" hidden>
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
                <input type="date" value="1994-03-13" class="form-control" id="dtpFechaNacimiento" placeholder="Ingresa la fecha de nacimiento" name="fechaNacimiento" onblur="casillaFechaNac();">
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
                <input type="text" value="{{$usuario->nombre}}" class="form-control" id="txtNombre" placeholder="Nombre del Cliente" name="nombre" onblur="casillaNombre();">
              </div>
            </div>
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputPassword1">Apellido</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                </div>
                <input type="text" value="{{$usuario->apellido}}" class="form-control" id="txtApellido" placeholder="Apellido" name="apellido" onblur="casillaApellido();">
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
                  <input type="text" value="{{$usuario->documento}}" class="form-control" id="txtDocumento" placeholder="Documento" name="documento" onblur="casillaApellido();">
                </div>                  
            </div>
            <div class="form-group col-12 col-md-6">
              <label for="exampleInputPassword1">Rol</label>
              <div class="input-group">
                <select class="form-control" name="" id="cmbRol">
                  <option value="0" disabled>Selecciona un rol...</option>
                    @foreach ($roles as $rol)
                      @if ($rol->id == $usuario->rol_id)
                        <option selected value="{{$rol->id}}">{{$rol->nombre}}</option>
                      @else
                        <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                      @endif         
                    @endforeach
                </select>
              </div>                  
            </div>
          </div>
          <div class="row">
            
          </div>
        </div>
        <!-- form start -->
        <form role="form" id="formularioNuevoCliente">
          <div class="card-body">                  
          </div><!-- /.card-body -->
          <div id="pnlPieBotones" class="card-footer text-right">
            <a href="{{ruta('listadoEmpleados')}}" class="btn btn-success m-auto col-12 col-md-6 col-xl-3">Volver</a>
            <button type="button" id="btnActualizarEmpleado" class="btn btn-green m-auto col-12 col-md-6 col-xl-3">Actualizar</button>
          </div>
        </form>
      </div><!-- /.card -->
    </div>
  </div>

@else

  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title mb-0">Datos del Empleado</h3>
        </div>
          <!-- form start -->
        <form role="form" id="formularioNuevoCliente">
          <div class="card-body">
            <div class="row">
              <div class="form-group col-12 col-md-6">
                <label for="exampleInputEmail1">Email</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <input type="text" id="uriiAlta" value="{{ruta('AltaEmpleadoAjax')}}" hidden>
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input required type="email" class="form-control" id="txtEmail" placeholder="Ingresa un correo" name="email">
                </div>
              </div>
              <div class="form-group col-12 col-md-6">
                <label for="exampleInputEmail1">Fecha Nacimiento</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="date" class="form-control" id="dtpFechaNacimiento" placeholder="Ingresa la fecha de nacimiento" name="fechaNacimiento">
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
                  <input type="text" class="form-control" id="txtNombre" placeholder="Nombre del Cliente" name="nombre">
                </div>
              </div>
              <div class="form-group col-12 col-md-6">
                <label for="exampleInputPassword1">Apellido</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                  </div>
                  <input type="text" class="form-control" id="txtApellido" placeholder="Apellido" name="apellido">
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
                    <input type="text" class="form-control" id="txtDocumento" placeholder="Documento" name="documento">
                  </div>                  
              </div>
              <div class="form-group col-12 col-md-6">
                <label for="cmbRol">Rol</label>
                <div class="input-group">
                  <select class="form-control" name="rol" id="cmbRol">
                    <option value="0" disabled selected>Selecciona un rol...</option>
                      @foreach ($roles as $rol)
                        <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                      @endforeach
                  </select>
                </div>                  
              </div>
            </div>
          </div>

          <div class="card-footer text-right">
            <button type="button" id="btnAgregarEmpleado" class="btn btn-green m-auto col-12 col-md-6 col-xl-3">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endisset


@endsection





  @section('scripts')
    <script src="{{ asset('js/Usuarios/AltaUsuario.js') }}"></script>     
    @isset($usuario)
      
    @else
      
    @endisset

    <script src="{{ asset('js/UtilScripts/validacionesGenerales.js') }}"></script>

    
  @endsection
