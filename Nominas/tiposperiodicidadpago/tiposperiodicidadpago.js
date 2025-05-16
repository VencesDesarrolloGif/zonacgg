$(traedatos()); 

function traedatos() {
    $.ajax({
        type: "POST",
        url: "ajax_cattipoperiocidadpago.php",
        dataType: "json",
        success: function(response) {
            //console.log(response);
            if (response.status == "success") {
                var mensaje = response.message;
                var datos = response.datos;
                var tabla = "<table id='tabla' class='table table-bordered'><thead><th style='text-align:center'>Id</th><th style='width:61%;text-align:center'>Descripción</th><th style='text-align:center'>Fecha inicio de vigencia</th><th style='text-align:center'>Fecha fin de vigencia</th></thead><tbody>";
                $(document).scrollTop(0);
                $.each(datos, function(i) {
                    tabla += "<tr><td > <input  id='inpid" + i + "' type='text' readonly='true' value='" + datos[i].numTipoPeriocidad + "'> </td>";
                    tabla += "<td><input class='form-control input-lg' id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].Descripcion + "'></td>";
                    tabla += "<td><input type='date' class='form-control input-lg' id='inpfechainiv" + i + "' type='text' readonly='true' value='" + datos[i].fInicioVig + "'></td>";
                    if (datos[i].fFinVig == null) {
                        tabla += "<td><input  class='form-control input-lg' id='inpfechafinv" + i + "' type='text' readonly='true' value='" + "" + "'></td>";
                    } else {
                        tabla += "<td><input type='date' class='form-control input-lg' id='inpfechafinv" + i + "' type='text' readonly='true' value='" + datos[i].fFinVig + "'></td>";
                    }
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
    $("#errorMsg").html("");
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpid" + i).prop('readonly', false);
        $("#inpdescripcion" + i).prop('readonly', false);
        $("#inpfechainiv" + i).prop('readonly', false);
        $("#inpfechafinv" + i).prop('readonly', false);
        $("#inpfechafinv" + i).prop('type', 'date');
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
            var descripcion = $("#inpdescripcion" + i).val();
            var id = $("#inpid" + i).val();
            var fechainicio = $("#inpfechainiv" + i).val();
            var fechafin = $("#inpfechafinv" + i).val();
        }
        if (id == "") {
            $(document).scrollTop(0);
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Id: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
            //alert("vacio");
        } else if (descripcion == "") {
            $(document).scrollTop(0);
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Descripción: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else if (fechainicio == "") {
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Fecha de inicio de vigencia: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else {
            $("#errorMsg").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inpid" + i).prop('readonly', true);
                $("#inpfechainiv" + i).prop('readonly', true);
                $("#inpfechafinv" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdatecattiipoperiocidadpago.php',
                data: {
                    'descripcion': descripcion,
                    'id': id,
                    'fechainicio': fechainicio,
                    'fechafin': fechafin,
                    'accion': 2
                },
                success: function(response) {
                    //console.log(response);
                    $(document).scrollTop(0);
                    $("#errorMsg").html("");
                    var Msgerrorcat = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsg").html(Msgerrorcat);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var descripcion = Array();
        var id = Array();
        var fechainicio = Array();
        var fechafin = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        for (var i = 0; i < b - 1; i++) {
            descripcion[i] = $("#inpdescripcion" + i).val();
            id[i] = $("#inpid" + i).val();
            fechainicio[i] = $("#inpfechainiv" + i).val();
            fechafin[i] = $("#inpfechafinv" + i).val();
            if (id[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Id en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (descripcion[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Descripción en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                return 0;
            }
            if (fechainicio[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Fecha inicio de vigencia en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdatecattiipoperiocidadpago.php',
            data: {
                'descripcion': descripcion,
                'id': id,
                'fechainicio': fechainicio,
                'fechafin': fechafin,
                'accion': 1
            }, //capturo array     
            success: function(response) {
                //console.log(response);
                $(document).scrollTop(0);
                $("#errorMsg").html("");
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b - 1; i++) {
                    $("#inpdescripcion" + i).prop('readonly', true);
                    $("#inpid" + i).prop('readonly', true);
                    $("#inpfechainiv" + i).prop('readonly', true);
                    $("#inpfechafinv" + i).prop('readonly', true);
                    $("#btneditar").prop("disabled", false);
                    $("#btnguardar").prop("disabled", true);
                    $("#btnagregar").prop('disabled', false);
                }
            }
        });
    }
}

function agregarfila() {
    $("#errorMsg").html("");
    $("#btneditar").prop("disabled", true);
    var b = $("#tabla tr").length;
    var table = document.getElementById("tabla");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    // var cell2 = row.insertCell(2);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > <input id='inpid" + i + "' type='text'> </td>";
        cell1.innerHTML = "<input class='form-control input-lg' id='inpdescripcion" + i + "' type='text'>";
        cell2.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechainiv" + i + "' type='text'>";
        cell3.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechafinv" + i + "' type='text'>";
        //cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}