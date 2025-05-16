$(traedatos()); 

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_subsidioAnual.php",
            dataType: "json",
            success: function(response) {
                //console.log(response);
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Para ingresos de</th><th>Hasta ingresos de</th><th>Cantidad de subsidio para el empleo anual</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td ><input id='inpparaingresos" + i + "' type='text' readonly='true' value='" + datos[i].ParaIngAn + "'></td>";
                        tabla += "<td><input id='inphastaingresos" + i + "' type='text' readonly='true' value='" + datos[i].HasIngAn + "'></td>";
                        tabla += "<td><input  id='inpcantidadsubsidios" + i + "' type='text' readonly='true' value='" + datos[i].cantSubsidioAnual + "'></td>";
                    });
                    $("#datos").append(tabla);
                } else {
                    var mensaje = response.message;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

function editar() {
    $("#errorMsgtblsalarios").html("");
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpparaingresos" + i).prop('readonly', false);
        $("#inphastaingresos" + i).prop('readonly', false);
        $("#inpcantidadsubsidios" + i).prop('readonly', false);
        //$("#inpsobreexcedente" + i).prop('readonly', false);
        $("#btnguardar").prop("disabled", false);
        $("#btneditar").prop("disabled", true);
    }
}

function guardar() {
    var inpaccion = $("#inpaccion").val();
    if (inpaccion === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        for (var i = b - 2; i < b - 1; i++) {
            var paraingresos = $("#inpparaingresos" + i).val();
            var hastaingresos = $("#inphastaingresos" + i).val();
            var cantidadsubsidios = $("#inpcantidadsubsidios" + i).val();
            //var sobreexcedente = $("#inpsobreexcedente" + i).val();
        }
        if (paraingresos == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(paraingresos)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique para ingresos de: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (hastaingresos == "" || !/^([0-9]+\.?[0-9]{0,5})*$/.test(hastaingresos)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique hasta ingresos de: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (cantidadsubsidios == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(cantidadsubsidios)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique cantidad de subsidio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        }
        /*else if (sobreexcedente == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(sobreexcedente)) {
                   $(document).scrollTop(0);
                   var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique % sobre excedente de limite inferior: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
               } */
        else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpparaingresos" + i).prop('readonly', true);
                $("#inphastaingresos" + i).prop('readonly', true);
                $("#inpcantidadsubsidios" + i).prop('readonly', true);
                // $("#inpsobreexcedente" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblsubsidioAnual.php',
                data: {
                    'paraingresos': paraingresos,
                    'hastaingresos': hastaingresos,
                    'cantidadsubsidios': cantidadsubsidios,
                    'accion': 2
                },
                success: function(response) {
                    $(document).scrollTop(0);
                    $("#errorMsgtblsalarios").html("");
                    var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var paraingresos = Array();
        var hastaingresos = Array();
        var cantidadsubsidios = Array();
        //var sobreexcedente = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            paraingresos[i] = $("#inpparaingresos" + i).val();
            hastaingresos[i] = $("#inphastaingresos" + i).val();
            cantidadsubsidios[i] = $("#inpcantidadsubsidios" + i).val();
            //sobreexcedente[i] = $("#inpsobreexcedente" + i).val();
            if (paraingresos[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(paraingresos[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique para ingresos de: en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (hastaingresos[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(hastaingresos[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique hasta ingresos de: en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (cantidadsubsidios[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(cantidadsubsidios[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique cantidad de subsidio: en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            /*  if (sobreexcedente[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(sobreexcedente[i])) {
                  $(document).scrollTop(0);
                  var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique % sobre excedente de limite inferior en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                  return 0;
              }*/
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblsubsidioAnual.php',
            data: {
                'paraingresos': paraingresos,
                'hastaingresos': hastaingresos,
                'cantidadsubsidios': cantidadsubsidios,
                //'sobreexcedente': sobreexcedente,
                'accion': 1
            }, //capturo array     
            success: function(response) {
                console.log(response);
                $(document).scrollTop(0);
                $("#errorMsgtblsalarios").html("");
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b - 1; i++) {
                    $("#inpparaingresos" + i).prop('readonly', true);
                    $("#inphastaingresos" + i).prop('readonly', true);
                    $("#inpcantidadsubsidios" + i).prop('readonly', true);
                    //$("#inpsobreexcedente" + i).prop('readonly', true);
                    $("#btneditar").prop("disabled", false);
                    $("#btnguardar").prop("disabled", true);
                    $("#btnagregar").prop('disabled', false);
                }
            }
        });
    }
}

function agregarfila() {
    $("#errorMsgtblsalarios").html("");
    $("#btneditar").prop("disabled", true);
    var b = $("#tabla tr").length;
    var table = document.getElementById("tabla");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpparaingresos" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inphastaingresos" + i + "' type='text' >";
        cell3.innerHTML = "<input id='inpcantidadsubsidios" + i + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}