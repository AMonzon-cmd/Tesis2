function FormatoMilesSinComas(value){
    return value.replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}


function FormatoMilesConComas(value){
    value = value.toString();
    if (value.indexOf(".") == -1){
        value = value + ".00";
    }
    return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}


function FormatoMilesToString(value){
    var re = ExRegularBorrar(",");
    return value.replace(re, "");
}

//Le pasamos el texto que queremos que se borre como exprecion regular
//Luego al utilizar replace ponemos esta exprecion regular generada y borrara todas las repeticiones
function ExRegularBorrar(texto){
    return new RegExp(escapeRegExp(texto),'g');
}

//Para lo de arriba, genera el formato de exprecion regular
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); 
  }