$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btnAgregarEmpleado').click(CrearEmpleado);
    $("#btnActualizarEmpleado").click(ActualizarEmpleado);

    $("#txtEmail").focus(limpiarError);
    $("#dtpFechaNacimiento").focus(limpiarError);
    $("#txtNombre").focus(limpiarError);
    $("#txtApellido").focus(limpiarError);
    $("#txtDocumento").focus(limpiarError);
    $("#cmbRol").focus(limpiarError);
});



function limpiarError(){
    $(this).removeClass('is-invalid');
}

function CrearEmpleado(){
    var email = $("#txtEmail").val();
    var fechaNacimiento = $("#dtpFechaNacimiento").val();
    var nombre = $("#txtNombre").val();
    var apellido = $("#txtApellido").val();
    var documento = $("#txtDocumento").val();
    var rol = $("#cmbRol").val();


    if (VerificarDatos(email, fechaNacimiento, nombre, apellido, documento, rol)){
        GenerarEmpleado(email, nombre, apellido, documento, fechaNacimiento, rol);
    }
}

function ActualizarEmpleado(){
    var email = $("#txtEmail").val();
    var fechaNacimiento = $("#dtpFechaNacimiento").val();
    var nombre = $("#txtNombre").val();
    var apellido = $("#txtApellido").val();
    var documento = $("#txtDocumento").val();
    var rol = $("#cmbRol").val();
    var id = $("#txtId").val();

    if (VerificarDatos(email, fechaNacimiento, nombre, apellido, documento, rol)){
        ModificarEmpleado(id, email, nombre, apellido, documento, fechaNacimiento, rol);
    }
}

function VerificarDatos(email, fechaNacimiento, nombre, apellido, documento, rol){
    var validacionCorrecta = true
    var htmlError = "<ul>"

    if (!validarMail(email)){
        $("#txtEmail").addClass('is-invalid');
        htmlError += "<li>El email ingresado no es valido.</li>"
        validacionCorrecta = false
    }

    //Valido que sea mayor
    if (!mayorDeEdad(fechaNacimiento)){
        $("#dtpFechaNacimiento").addClass('is-invalid');
        htmlError += "<li>El usuario debe ser mayor de edad.</li>"
        validacionCorrecta = false
    }

    //Valido el nombre
    if (nombre == '' || nombre == ' ' || nombre.length < 3){
        $("#txtNombre").addClass('is-invalid');
        htmlError += "<li>Ingrese un nombre de almenos 2 caracteres.</li>";
        validacionCorrecta = false;
    }

    //Valido el apellido
    if (apellido == '' || apellido == ' ' || apellido.length < 3){
        $("#txtPrimerApellido").addClass('is-invalid');
        htmlError += "<li>Ingrese un apellido de almenos 2 caracteres.</li>";
        validacionCorrecta = false;
    }

    //Valido el documento
    if (isNaN(documento) || documento.length < 6){
        $("#txtDocumento").addClass('is-invalid');
        htmlError += "<li>Ingrese un documento de almenos 6 digitos.</li>";
        validacionCorrecta = false;
    }

    if (rol <= 0){
        $("#txtDocumento").addClass('is-invalid');
        htmlError += "<li>Seleccione un rol valido.</li>";
        validacionCorrecta = false;
    }

    if (!validacionCorrecta){
        alertaCajaHTML(tipoAlertaError, 'Datos incorrectos', htmlError);
    }

    return validacionCorrecta;
}

function GenerarEmpleado(email, nombre, apellido, documento, fechaNacimiento, rol){
    $("#mantaLoading").modal('show');
    var urii = $("#uriiAlta").val();
    $.ajax({
        url: urii,
        data:{'email': email, 'nombre': nombre, 'apellido': apellido, 'documento': documento, 'fechaNacimiento': fechaNacimiento, 'rol':rol},
        type:'post',
        dataType: "json",
        success: function (response) {
            $("#formularioNuevoCliente")[0].reset();
            $("#mantaLoading").modal('hide');
            alertaToast(tipoAlertaOK, response.respuesta, 3500);
    },
    statusCode: {              
        404: function() {
            $("#mantaLoading").modal('hide');
            alertaToast(tipoAlertaError, 'El servicio payday no se encuentra disponible', 3500);
        },
        422: function(response){
            $("#mantaLoading").modal('hide');
            var errores = response.responseJSON.errors;
            if(errores.hasOwnProperty('email')){
                alertaToast(tipoAlertaError, 'El email ya esta siendo utilizado o no posee un formato valido', 4000);
            }
            else{
                if(errores.hasOwnProperty('documento')){
                    alertaToast(tipoAlertaError, 'El documento ya esta siendo utilizado', 4000);
                }
            }
            
        }
    },
    error:function(x,xs,xt){
        $("#mantaLoading").modal('hide');
        var errores = x.response;
        $.each( errores, function( key, value ) {
            alertaToast(tipoAlertaError, value[0],3500);
        });
        }
    });
}

function ModificarEmpleado(id, email, nombre, apellido, documento, fechaNacimiento, rol){
    $("#mantaLoading").modal('show');
    $.ajax({
        url: $("#urii").val(),
        data:{'id' : id, 'email': email, 'nombre': nombre, 'apellido': apellido, 'documento': documento, 'fechaNacimiento': fechaNacimiento, 'rol':rol},
        type:'post',
        dataType: "json",
        success: function (response) {
            $("#formularioNuevoCliente")[0].reset();
            $("#mantaLoading").modal('hide');
            alertaToast(tipoAlertaOK, response.respuesta, 3500);
    },
    statusCode: {              
        404: function() {
            $("#mantaLoading").modal('hide');
            alertaToast(tipoAlertaError, 'El servicio payday no se encuentra disponible', 3500);
        },
        422: function(response){
            $("#mantaLoading").modal('hide');
            var errores = response.responseJSON.errors;
            if(errores.hasOwnProperty('email')){
                alertaToast(tipoAlertaError, 'El email ya esta siendo utilizado o no posee un formato valido', 4000);
            }
            else{
                if(errores.hasOwnProperty('documento')){
                    alertaToast(tipoAlertaError, 'El documento ya esta siendo utilizado', 4000);
                }
            }
        },
        500: function(response){
            $("#mantaLoading").modal('hide');
            alertaToast(tipoAlertaError, response.responseJSON.respuesta, 4000);
        }
    },
    error:function(x,xs,xt){
        $("#mantaLoading").modal('hide');
        var errores = x.response;
        $.each( errores, function( key, value ) {
            alertaToast(tipoAlertaError, value[0],3500);
        });
        }
    });
}