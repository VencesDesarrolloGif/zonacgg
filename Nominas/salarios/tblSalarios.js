$(traedatos()); 
    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_tblSalarios.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Fecha</th><th>&AacutereaA</th><th>&AacutereaB</th><th>&AacutereaC</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td ><input id='fecha" + i + "' type='date' required='required' min='1920-01-01' max='2999-12-31'  readonly='true' value='" + datos[i].fechaInicio + "'></td>";
                        tabla += "<td><input id='datoa" + i + "' type='text' readonly='true' value='" + datos[i].sAreaA + "'></td>";
                        tabla += "<td><input  id='datob" + i + "' type='text' readonly='true' value='" + datos[i].sAreaB + "'></td>";
                        tabla += "<td><input id='datoc" + i + "' type='text' readonly='true' value='" + datos[i].sAreaC + "' ></td></tr>"
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
        $("#fecha" + i).prop('readonly', false);
        $("#datoa" + i).prop('readonly', false);
        $("#datob" + i).prop('readonly', false);
        $("#datoc" + i).prop('readonly', false);
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
            var fechaagregada = $("#fecha" + i).val();
            var datoaagregado = $("#datoa" + i).val();
            var datobagregado = $("#datob" + i).val();
            var datocagregado = $("#datoc" + i).val();
        }
        if (fechaagregada == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Debe introducir fecha: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (datoaagregado == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datoaagregado)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaA: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (datobagregado == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datobagregado)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaB: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (datocagregado == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datocagregado)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaC: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        }
         else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#fecha" + i).prop('readonly', true);
                $("#datoa" + i).prop('readonly', true);
                $("#datob" + i).prop('readonly', true);
                $("#datoc" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblsalarios.php',
                data: {
                    'fecha': fechaagregada,
                    'datoa': datoaagregado,
                    'datob': datobagregado,
                    'datoc': datocagregado,
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
        var fecha = Array();
        var datoa = Array();
        var datob = Array();
        var datoc = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            fecha[i] = $("#fecha" + i).val();
            datoa[i] = $("#datoa" + i).val();
            datob[i] = $("#datob" + i).val();
            datoc[i] = $("#datoc" + i).val();
            if (fecha[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Debe introducir fecha en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (datoa[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datoa[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaA en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (datob[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datob[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaB en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (datoc[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(datoc[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique &AacutereaC en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblsalarios.php',
            data: {
                'fecha': fecha,
                'datoa': datoa,
                'datob': datob,
                'datoc': datoc,
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
                    $("#fecha" + i).prop('readonly', true);
                    $("#datoa" + i).prop('readonly', true);
                    $("#datob" + i).prop('readonly', true);
                    $("#datoc" + i).prop('readonly', true);
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
        cell1.innerHTML = "<input id='fecha" + i + "' type='date' required='required' min='1920-01-01' max='2999-12-31' >";
        cell2.innerHTML = "<input id='datoa" + i + "' type='text' >";
        cell3.innerHTML = "<input id='datob" + i + "' type='text' >";
        cell4.innerHTML = "<input id='datoc" + i + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}