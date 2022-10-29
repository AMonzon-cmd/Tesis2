//TIPOS DE ALERTA
const tipoAlertaOK = 'success';
const tipoAlertaError = 'error';
const tipoAlertaExclamacion = 'warning';
const tipoAlertaInformacion = 'info';
const tipoAlertaPregunta = 'question';

//POSICION
const arriba = 'top';
const arribaDerecha = 'top-end';
const abajoDerecha = 'bottom-end';
const arribaIzquierda = 'top-start';
const abajoIzquierda = 'bottom-start';
const centrado = 'center';


//MENSAJES DEFAULT
const servicioOFF = 'No se puede comunicar con los servidores de Remextiven. Verifique su conexión.'
const servicioError = 'Hubo un problema al procesar la informacion. Comuníquese con soporte'


//ANIMACIONES DE ENTRADA/////////////////////
const animacionEntradaAgitar = 'animated wobble';
const animacionEntradaAgitarRapida = animacionEntradaAgitar + ' faster';

const animacionEntradaEstirar = 'animated rubberBand';
const animacionEntradaEstirarRapida = 'animated rubberBand faster';

const animacionEntradaFadeIn = 'animated fadeIn';
const animacionEntradaFadeInRapida = animacionEntradaFadeIn + ' faster';

const animacionEntradaGirar = 'animated flipInX';
const animacionEntradaGirarRapido =  animacionEntradaGirar + ' faster';

const animacionEntradaCarrera = 'animated lightSpeedIn';
const animacionEntradaCarreraRapida = animacionEntradaCarrera + ' faster';

const animacionEntradaRotar = 'animated fadeInDown';
const animacionEntradaRotarRapida = animacionEntradaRotar + ' faster';


//ANIMACIONES DE SALIDA////////////////////////
const animacionSalidaFadeOut = 'animated fadeOut';
const animacionSalidaFadeOutRapida = animacionSalidaFadeOut + ' faster';

const animacionSalidaLatido = 'animated bounceOut';
const animacionSalidaLatidoRapida = animacionSalidaLatido + ' faster';

const animacionSalidaGirar = 'animated flipOutX';
const animacionSalidaRapida = animacionSalidaGirar + ' faster';

const animacionSalidaCarrera = 'animated lightSpeedOut';
const animacionSalidaCarreraRapida = animacionSalidaCarrera + ' faster';

const animacionSalidaRotar = 'animated rotateOut';
const animacionSalidaRotarRapida = animacionSalidaRotar + ' faster';

const animacionSalidaDescolgar = 'animated hinge';
const animacionSalidaDescolgarRapida = animacionSalidaDescolgar + ' faster';




//ALERTA TOAST
function alertaToast(tipoAlerta, mensaje, tiempo = 1800, posicion = 'top-end', barraTiempo = true){
    Swal.fire({
        icon: tipoAlerta,
        title: mensaje,
        toast: true,
        position: posicion,
        showConfirmButton: false,
        timer: tiempo,
        timerProgressBar: barraTiempo,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
}

//ALERTA TOAST GRANDE
function alertaToastGrande(tipoAlerta, mensaje, posicion, animacionEntrada = animacionEntradaFadeIn, animacionSalida = animacionSalidaFadeOut,  tiempo = 1800, barraTiempo = true){
    Swal.fire({
        icon: tipoAlerta,
        title: mensaje,
        position: posicion,
        showConfirmButton: false,
        timer: tiempo,
        timerProgressBar: barraTiempo,

        showClass: {
            popup: animacionEntrada
          },
          hideClass: {
            popup: animacionSalida
          }
      })
}

function alertaCaja(tipoAlerta, titulo, mensaje, posicion = 'center', animacionEntrada = animacionEntradaFadeIn, animacionSalida = animacionSalidaFadeOut){
    Swal.fire({
        icon: tipoAlerta,
        title: titulo,
        position: posicion,
        text: mensaje,

        showClass: {
            popup: animacionEntrada
          },
          hideClass: {
            popup: animacionSalida
          }
      })
}

function alertaCajaHTML(tipoAlerta, titulo, mensaje, posicion = 'center', animacionEntrada = animacionEntradaFadeIn, animacionSalida = animacionSalidaFadeOut){
  Swal.fire({
      icon: tipoAlerta,
      title: titulo,
      position: posicion,
      html: mensaje,
      confirmButtonText: "Aceptar",

      showClass: {
          popup: animacionEntrada
        },
      hideClass: {
          popup: animacionSalida
        }
    })
}