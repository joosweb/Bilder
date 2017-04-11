$.calculaDigitoVerificador = function(rut) {
    // type check
    if (!rut || !rut.length || typeof rut !== 'string') {
        return -1;
    }
    // serie numerica
    var secuencia = [2, 3, 4, 5, 6, 7, 2, 3];
    var sum = 0;
    //
    for (var i = rut.length - 1; i >= 0; i--) {
        var d = rut.charAt(i)
        sum += new Number(d) * secuencia[rut.length - (i + 1)];
    };
    // sum mod 11
    var rest = 11 - (sum % 11);
    // si es 11, retorna 0, sino si es 10 retorna K,
    // en caso contrario retorna el numero
    return rest === 11 ? 0 : rest === 10 ? "K" : rest;
};

function formato_rut(rut) {
    var sRut1 = rut;
    sRut1 = sRut1.replace('-', ''); // se elimina el guion
    sRut1 = sRut1.replace('.', ''); // se elimina el primer punto
    sRut1 = sRut1.replace('.', ''); // se elimina el segundo punto
    sRut1 = sRut1.replace(/k$/, "K");
    document.getElementById("rut").value = sRut1;
    //contador de para saber cuando insertar el . o la -
    var nPos = 0;
    //Guarda el rut invertido con los puntos y el gui&oacute;n agregado
    var sInvertido = "";
    //Guarda el resultado final del rut como debe ser
    var sRut = "";
    for (var i = sRut1.length - 1; i >= 0; i--) {
        sInvertido += sRut1.charAt(i);
        if (i == sRut1.length - 1) sInvertido += "-";
        else if (nPos == 3) {
            sInvertido += ".";
            nPos = 0;
        }
        nPos++;
    }
    for (var j = sInvertido.length - 1; j >= 0; j--) {
        if (sInvertido.charAt(sInvertido.length - 1) != ".") sRut += sInvertido.charAt(j);
        else if (j != sInvertido.length - 1) sRut += sInvertido.charAt(j);
    }
    //Pasamos al campo el valor formateado
    return sRut;
}
$(document).ready(function() {
    $("#rut").change(function() {
        var RUN = $('#rut').val();
        $.getJSON('includes/getData.php?run=' + RUN, function(data) {
            if (data.rut) {
                var digitoVerificador = jQuery.calculaDigitoVerificador(data.rut);
                var RutCompleto = data.rut + digitoVerificador;
                $('#nombres').val(data.nombres);
                $('#apellidos').val(data.apellidos);
                $('#rut').val(formato_rut(RutCompleto));
                $(".form-rut").removeClass("has-danger");
                $(".form-rut").addClass("has-success");
            }
        });
    });
});