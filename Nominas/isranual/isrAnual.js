$(traedatos()); 

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_isrAnual.php",
            dataType: "json",
            success: function(response) {
                //console.log(response);
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Limite inferiror</th><th>Limite superior</th><th>Cuota fija</th><th>% Sobre excedente de limite inferior</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td ><input id='inplimiteinferior" + i + "' type='text' readonly='true' value='" + datos[i].limiteInferiorAnual + "'></td>";
                        tabla += "<td><input id='inplimitesuperior" + i + "' type='text' readonly='true' value='" + datos[i].limiteSuperiorAnual + "'></td>";
                        tabla += "<td><input  id='inpcuotafija" + i + "' type='text' readonly='true' value='" + datos[i].cuotaFijaAnual + "'></td>";
                        tabla += "<td><input id='inpsobreexcedente" + i + "' type='text' readonly='true' value='" + datos[i].sobreExcedenteLimInferiorAnual + "' ></td></tr>"
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
        $("#inplimiteinferior" + i).prop('readonly', false);
        $("#inplimitesuperior" + i).prop('readonly', false);
        $("#inpcuotafija" + i).prop('readonly', false);
        $("#inpsobreexcedente" + i).prop('readonly', false);
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
            var limiteinferior = $("#inplimiteinferior" + i).val();
            var limitesuperior = $("#inplimitesuperior" + i).val();
            var cuotafija = $("#inpcuotafija" + i).val();
            var sobreexcedente = $("#inpsobreexcedente" + i).val();
        }
        if (limiteinferior == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(limiteinferior)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique limite inferior: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (limitesuperior == "" || !/^([0-9]+\.?[0-9]{0,5})*$/.test(limitesuperior)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Verifique limite superior: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (cuotafija == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(cuotafija)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique cuota fija: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (sobreexcedente == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(sobreexcedente)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique % sobre excedente de limite inferior: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inplimiteinferior" + i).prop('readonly', true);
                $("#inplimitesuperior" + i).prop('readonly', true);
                $("#inpcuotafija" + i).prop('readonly', true);
                $("#inpsobreexcedente" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblisrAnual.php',
                data: {
                    'limiteinferior': limiteinferior,
                    'limitesuperior': limitesuperior,
                    'cuotafija': cuotafija,
                    'sobreexcedente': sobreexcedente,
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
        var limiteinferior = Array();
        var limitesuperior = Array();
        var cuotafija = Array();
        var sobreexcedente = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            limiteinferior[i] = $("#inplimiteinferior" + i).val();
            limitesuperior[i] = $("#inplimitesuperior" + i).val();
            cuotafija[i] = $("#inpcuotafija" + i).val();
            sobreexcedente[i] = $("#inpsobreexcedente" + i).val();
            if (limiteinferior[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(limiteinferior[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique limite inferior en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (limitesuperior[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(limitesuperior[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique limite superior en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (cuotafija[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(cuotafija[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique cuota fija en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (sobreexcedente[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(sobreexcedente[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique % sobre excedente de limite inferior en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblisrAnual.php',
            data: {
                'limiteinferior': limiteinferior,
                'limitesuperior': limitesuperior,
                'cuotafija': cuotafija,
                'sobreexcedente': sobreexcedente,
                'accion': 1
            }, //capturo array     
            success: function(response) {
                $(document).scrollTop(0);
                $("#errorMsgtblsalarios").html("");
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b - 1; i++) {
                    $("#inplimiteinferior" + i).prop('readonly', true);
                    $("#inplimitesuperior" + i).prop('readonly', true);
                    $("#inpcuotafija" + i).prop('readonly', true);
                    $("#inpsobreexcedente" + i).prop('readonly', true);
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
    var cell4 = row.insertCell(4);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inplimiteinferior" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inplimitesuperior" + i + "' type='text' >";
        cell3.innerHTML = "<input id='inpcuotafija" + i + "' type='text' >";
        cell4.innerHTML = "<input id='inpsobreexcedente" + i + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}