@extends('layouts/layout')

@section('menu-catalogo')
    active
@endsection

@section('link-catalogo-generar')
    active
@endsection

@section('contenido')  

 <!-- CUERPO DE LA PAGINA-->

@isset($producto)
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Producto</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Productos Catalogo</a></li>
            <li class="breadcrumb-item"><a href="">Listado Productos</a></li>
            <li class="breadcrumb-item active">Editar Producto</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title mb-0">Datos del Producto</h3>
        </div>
          <!-- form start -->
          @if(!empty($errors) && $errors->first() != null)
          <div class="col-12 text-center">
            <div class="alert alert-danger col-12 mt-2"><h5>{{$errors->first()}}<h5></div>
          </div>
          @endif

          @if(!empty($mensaje))
          <div class="col-12 text-center">
            <div class="alert alert-success col-12 mt-2"><h5>{{$mensaje}}<h5></div>
          </div>
          @endif
        <form role="form" action="{{ruta('producto', $producto->id)}}" onsubmit="return parametrosCorrectos()" method="POST">
          @csrf
          @method('PUT')
          <div class="card-body">
            <div class="row">
              <div class="form-group col-12 col-md-4">
                <label for="exampleInputEmail1">Nombre</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                  </div>
                  <input type="text" class="form-control" id="txtNombreProducto" value="{{$producto->nombre}}" placeholder="Ingresa un nombre" name="nombre">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-10">
                <label for="exampleInputPassword1">Descripcion</label>
                <div class="input-group">
                  <textarea class="form-control" name="descripcion" id="txtDescripcionProducto" cols="30" rows="2">{{$producto->descripcion}}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-6 col-md-3">
                <label for="exampleInputPassword1">Costo (en puntos)</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="txtCosto" placeholder="" name="costo" value="{{$producto->costo}}">
                  </div>                  
              </div>
              <div class="form-group col-6 col-md-3">
                <label for="cmbRol">Stock</label>
                <div class="input-group">
                  <input class="form-control" type="number" name="stock" id="txtStock" min="1" step="1" value="{{$producto->stock}}">
                </div>                  
              </div>

              <div class="form-group col-12 col-md-6">
                <label for="exampleInputPassword1">Imagen</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fileImg" placeholder="" name="img" value="{{$producto->img}}">
                  </div>                  
              </div>
            </div>

            <div class="row">
                
              </div>
          </div>

          <div class="card-footer text-right">
            <button type="submit" id="btnAgregarProducto" class="btn btn-green m-auto col-12 col-md-6 col-xl-3">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@else

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Alta Producto Catalogo</h1>
        </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Alta Producto</li>
        </ol>
      </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title mb-0">Datos del Producto</h3>
        </div>
          <!-- form start -->
          @if(!empty($errors) && $errors->first() != null)
          <div class="col-12 text-center">
            <div class="alert alert-danger col-12 mt-2"><h5>{{$errors->first()}}<h5></div>
          </div>
          @endif

          @if(!empty($mensaje))
          <div class="col-12 text-center">
            <div class="alert alert-success col-12 mt-2"><h5>{{$mensaje}}<h5></div>
          </div>
          @endif
        <form role="form" action="{{ruta('producto')}}" onsubmit="return parametrosCorrectos()" method="POST">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="form-group col-12 col-md-4">
                <label for="exampleInputEmail1">Nombre</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                  </div>
                  <input type="text" class="form-control" id="txtNombreProducto" value="{{old('nombre')}}" placeholder="Ingresa un nombre" name="nombre">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-10">
                <label for="exampleInputPassword1">Descripcion</label>
                <div class="input-group">
                  <textarea class="form-control" name="descripcion" id="txtDescripcionProducto" cols="30" rows="2">{{old('descripcion')}}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-6 col-md-3">
                <label for="exampleInputPassword1">Costo (en puntos)</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="txtCosto" placeholder="" name="costo" value="{{old('costo')}}">
                  </div>                  
              </div>
              <div class="form-group col-6 col-md-3">
                <label for="cmbRol">Stock</label>
                <div class="input-group">
                  <input class="form-control" type="number" name="stock" id="txtStock" min="1" step="1" value="{{old('stock')}}">
                </div>                  
              </div>

              <div class="form-group col-12 col-md-6">
                <label for="exampleInputPassword1">Imagen</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text d-none d-sm-block"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fileImg" placeholder="" name="img" value="{{old('img')}}">
                  </div>                  
              </div>
            </div>

            <div class="row">
                
              </div>
          </div>

          <div class="card-footer text-right">
            <button type="submit" id="btnAgregarProducto" class="btn btn-green m-auto col-12 col-md-6 col-xl-3">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endisset

@endsection


@section('scripts')
  <script>

    function parametrosCorrectos(){
      let nombre = $("#txtNombreProducto").val();
      let descripcion = $("#txtDescripcionProducto").val();
      let costo = $("#txtCosto").val();
      let stock = $("#txtStock").val();
      let sinImagen = $("#fileImg").val() === "";
      let errores = "";
      formValido = true;

      if(nombre.trim().length == 0){
        Swal.fire(
                    'Error',
                    'El nombre es demasiado corto',
                    'error'
                  );
        formValido = false;
        return formValido
      }

      if(descripcion.trim().length < 10){
        Swal.fire(
                    'Error',
                    'La descripcoin debe tener minimo 10 caracteres',
                    'error'
                  );
        formValido = false;
        return formValido
      }

      if(isNaN(costo) || costo <= 0){
        Swal.fire(
                    'Error',
                    'El valor del costo no es valido',
                    'error'
                  );
        formValido = false;
        return formValido
      }

      if(isNaN(stock) || stock < 0){
        Swal.fire(
                    'Error',
                    'El stock no posee un valor valido',
                    'error'
                  );
        formValido = false;
        return formValido
      }
    }
  </script>

@endsection