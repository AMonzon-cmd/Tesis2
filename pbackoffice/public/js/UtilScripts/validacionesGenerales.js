  //Minimo 8 con caracter numerico
  function validarPass(pass){
    var caract = new RegExp(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/);
    return caract.test(pass);
  }

  //Debe cumplir con formato de correo
  function validarMail(email){
    var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return caract.test(email);
  }

  //Solo permite escribir letras
  function soloLetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }
 }
 
  //Solo permite escribir numeros
  function soloNumeros(e) {
    tecla = e.keyCode || e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    patron = /\d/;
    te = String.fromCharCode(tecla);
    return patron.test(te); 
  } 
  
  function escribirSoloNumeros(event){
    var tecla = String.fromCharCode(event.which);
    if(isNaN(tecla) && event.which != 8 && event.which != 37 && event.which != 39){
        event.preventDefault();
        return false;
    }
    else{
        return true;
    } 
}

function escribirSoloNumerosConComa(event){
  var tecla = String.fromCharCode(event.which);
  if(isNaN(tecla) && event.which != 8 && event.which != 37 && event.which != 39 && event.which != 44 && event.wicth != 46){
      event.preventDefault();
      return false;
  }
  else{
      return true;
  } 
}

//Valido si tiene numeros o caracteres raros
function textoSoloLetras(texto){
  var caract = new RegExp("^[a-zñ A-ZÑ]+$");
  return caract.test(texto);
} 

function textoSoloNumeros(texto){
  var caract = /^\d*$/;
  return caract.test(texto);
}



//Valido si sos mayor de 18
function mayorDeEdad(fecha){
  var fechaHoy = new Date();
  var fechaPersona = new Date(fecha);
  var diff = new Date(fechaHoy - fechaPersona)/1000/60/60/24;
  if (diff > 6542){
    return true;
  }

  return false
}