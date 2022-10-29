@extends('layouts/layout')

@section('menu-servicios')
    active
@endsection

@section('link-servicios-generar')
    active
@endsection

@section('contenido')  

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de Empleados</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Servicios</a></li>
                <li class="breadcrumb-item active">Alta Servicio</li>
            </ol>
        </div>
    </div>
</div><!-- /.container-fluid -->
</section>


<div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title mb-0">Datos del Servicio</h3>
        </div>
          <!-- form start -->
        <form role="form" id="formularioNuevoCliente">
          <div class="card-body">
            <div class="row">
              <div class="form-group col-12 col-md-6">
                <label for="exampleInputEmail1">Servicio</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input required type="email" class="form-control" id="txtEmail" placeholder="Ingresa un correo" name="email">
                </div>
              </div>
              <div class="form-group col-12 col-md-6">
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
                <label for="cmbSexo">Sexo</label>
                <div class="input-group">
                  <select class="form-control" name="sexo" id="cmbSexo">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                  </select>
                </div>                  
              </div>
            </div>
            <div class="row">
              <div class="form-group col-12 col-md-6">
                <label for="cmbRol">Rol</label>
                <div class="input-group">
                  <select class="form-control" name="rol" id="cmbRol">
                    <option value="0" disabled selected>Selecciona un rol...</option>
                      @foreach ($roles as $rol)
                        <option value="{{$rol->IdRol}}">{{$rol->Rol}}</option>
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

@endsection