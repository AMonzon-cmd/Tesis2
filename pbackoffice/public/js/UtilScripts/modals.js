const modalCorrecto = 1;
const modalInfo = 2;
const modalCuidado = 3;
const modalError = 4;
const modalFallo = 5;
const modalPregunta = 6;

function armarModal(titulo, subtitulo, mensaje, tipoModal){
    $("#titleModalFallo").text(titulo);
    $("#subTitleModalFallo").text(subtitulo);
    $("#messageModalFallo").html(mensaje);
    if(tipoModal = modalFallo){
        armarModalFallo();
    }

}

function armarModalCorrecto(){

}


function armarModalInfo(){

}


function armarModalCuidado(){

}


function armarModalError(){

}


function armarModalFallo(){
    $("#modalFalloValidacion").modal();
}