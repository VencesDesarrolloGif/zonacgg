$(traedatos()); 

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_porcentajeimpuestos.php",
            dataType: "json",
            success: function(response) {
                //console.log(response);
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Entidad federativa</th><th>Porcentaje del impuesto</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        // tabla += "<td><input  id='inpmensualuma" + i + "' type='text' readonly='true' value='" + datos[i].idEntidad + "'></td>";
                        tabla += "<td><input id='inpdescripcionentidad" + i + "' type='text' readonly='true' value='" + datos[i].descripcionEntidad + "'></td>";
                        tabla += "<td ><input  id='inpporcentajeimpuesto" + i + "' type='text' readonly='true' value='" + datos[i].porcentajeImpuesto + "'></td>";
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
        $("#inpdescripcionentidad" + i).prop('readonly', false);
        $("#inpporcentajeimpuesto" + i).prop('readonly', false);
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
            var descripcionentidad = $("#inpdescripcionentidad" + i).val();
            var porcentajeimpuesto = $("#inpporcentajeimpuesto" + i).val();
        }
        if (descripcionentidad == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Entidad federativa: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (porcentajeimpuesto == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(porcentajeimpuesto)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Porcentaje del impuesto (Solo permitidos números): </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpdescripcionentidad" + i).prop('readonly', true);
                $("#inpporcentajeimpuesto" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblporcentajeimpuestos.php',
                data: {
                    'descripcionentidad': descripcionentidad,
                    'porcentajeimpuesto': porcentajeimpuesto,
                    'accion': 2
                },
                success: function(response) {
                    console.log(response);
                    $(document).scrollTop(0);
                    $("#errorMsgtblsalarios").html("");
                    var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var descripcionentidad = Array();
        var porcentajeimpuesto = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        //alert(c);
        for (var i = 0; i < b - 1; i++) {
            descripcionentidad[i] = $("#inpdescripcionentidad" + i).val();
            porcentajeimpuesto[i] = $("#inpporcentajeimpuesto" + i).val();
            if (descripcionentidad[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Entidad federativa en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (porcentajeimpuesto[i] == "" || !/^([0-9]+\.?[0-9]{0,2})*$/.test(porcentajeimpuesto[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Porcentaje del impuesto (Solo permitidos números) en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblporcentajeimpuestos.php',
            data: {
                'descripcionentidad': descripcionentidad,
                'porcentajeimpuesto': porcentajeimpuesto,
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
                    $("#inpdescripcionentidad" + i).prop('readonly', true);
                    $("#inpporcentajeimpuesto" + i).prop('readonly', true);
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
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpdescripcionentidad" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}