function ComaPorPunto(id){
    var valor = $("#"+id).val();
    var valor = valor.replace(",",".");
    $("#" + id).val(valor);
}