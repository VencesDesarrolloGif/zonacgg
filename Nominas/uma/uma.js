$(traedatos()); 
    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_uma.php",
            dataType: "json",
            success: function(response) {
                //console.log(response);
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Año</th><th>Diario</th><th>Mensual</th><th>Anual</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td><input id='inpaniouma" + i + "' type='text' readonly='true' value='" + datos[i].anioUma + "'></td>";
                        tabla += "<td ><input  id='inpdiariouma" + i + "' type='text' readonly='true' value='" + datos[i].diarioUma + "'></td>";
                        tabla += "<td><input  id='inpmensualuma" + i + "' type='text' readonly='true' value='" + datos[i].mensualUma + "'></td>";
                        tabla += "<td><input id='inpanualuma" + i + "' type='text' readonly='true' value='" + datos[i].anualUma + "' ></td></tr>"
                    });
                    // tabla += "<td><input id='inpdiariouma" + i + "' type='text' readonly='true' value='" + datos[i].diarioUma + "'></td>";
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
        $("#inpaniouma" + i).prop('readonly', false);
        $("#inpdiariouma" + i).prop('readonly', false);
        $("#inpmensualuma" + i).prop('readonly', false);
        $("#inpanualuma" + i).prop('readonly', false);
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
            var aniouma = $("#inpaniouma" + i).val();
            var diariouma = $("#inpdiariouma" + i).val();
            var mensualuma = $("#inpmensualuma" + i).val();
            var anualuma = $("#inpanualuma" + i).val();
        }
        if (aniouma == "" || !/^(([0-9]{4}))*$/.test(aniouma)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Año: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (diariouma == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(diariouma)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique diario: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (mensualuma == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(mensualuma)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Mensual: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (anualuma == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(anualuma)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Anual: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpaniouma" + i).prop('readonly', true);
                $("#inpdiariouma" + i).prop('readonly', true);
                $("#inpmensualuma" + i).prop('readonly', true);
                $("#inpanualuma" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatbluma.php',
                data: {
                    'aniouma': aniouma,
                    'diariouma': diariouma,
                    'mensualuma': mensualuma,
                    'anualuma': anualuma,
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
        var aniouma = Array();
        var diariouma = Array();
        var mensualuma = Array();
        var anualuma = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            aniouma[i] = $("#inpaniouma" + i).val();
            diariouma[i] = $("#inpdiariouma" + i).val();
            mensualuma[i] = $("#inpmensualuma" + i).val();
            anualuma[i] = $("#inpanualuma" + i).val();
            if (aniouma[i] == "" || !/^(([0-9]{4}))*$/.test(aniouma[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Año en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (diariouma[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(diariouma[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Diario en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (mensualuma[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(mensualuma[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Mensual en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (anualuma[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(anualuma[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Anual en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatbluma.php',
            data: {
                'aniouma': aniouma,
                'diariouma': diariouma,
                'mensualuma': mensualuma,
                'anualuma': anualuma,
                'accion': 1
            }, //capturo array     
            success: function(response) {
                //console.log(response);
                $(document).scrollTop(0);
                $("#errorMsgtblsalarios").html("");
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b - 1; i++) {
                    $("#inpaniouma" + i).prop('readonly', true);
                    $("#inpdiariouma" + i).prop('readonly', true);
                    $("#inpmensualuma" + i).prop('readonly', true);
                    $("#inpanualuma" + i).prop('readonly', true);
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
        cell1.innerHTML = "<input id='inpaniouma" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inpdiariouma" + i + "' type='text' >";
        cell3.innerHTML = "<input id='inpmensualuma" + i + "' type='text' >";
        cell4.innerHTML = "<input id='inpanualuma" + i + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}