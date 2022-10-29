$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btnModificarCliente').click(ModificarCliente);

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

function ModificarCliente(){
    var email = $("#txtEmail").val();
    // var fechaNacimiento = $("#dtpFechaNacimiento").val();
    // var nombre = $("#txtNombre").val();
    // var apellido = $("#txtApellido").val();
    var documento = $("#txtDocumento").val();
    var puntaje = $("#txtPuntaje").val();


    if (VerificarDatos(email, documento, puntaje)){
        ejecutarModificacion(email, documento, puntaje);
    }
}

function VerificarDatos(email, documento, puntaje){
    var validacionCorrecta = true
    var htmlError = "<ul>"

    if (!validarMail(email)){
        $("#txtEmail").addClass('is-invalid');
        htmlError += "<li>El email ingresado no es valido.</li>"
        validacionCorrecta = false
    }


    //Valido el documento
    if (isNaN(documento) || documento.length < 6){
        $("#txtDocumento").addClass('is-invalid');
        htmlError += "<li>Ingrese un documento de almenos 6 digitos.</li>";
        validacionCorrecta = false;
    }

    if (isNaN(puntaje) || puntaje < 0){
        $("#txtDocumento").addClass('is-invalid');
        htmlError += "<li>El puntaje no es un valor valido.</li>";
        validacionCorrecta = false;
    }

    if (!validacionCorrecta){
        alertaCajaHTML(tipoAlertaError, 'Datos incorrectos', htmlError);
    }

    return validacionCorrecta;
}

function ejecutarModificacion(email, documento ,puntaje){
    $("#mantaLoading").modal('show');
    var urii = $("#urii").val();
    $.ajax({
        url: urii,
        data:{'id': $("#txtId").val(), 'email': email, 'documento': documento, 'puntos':puntaje},
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