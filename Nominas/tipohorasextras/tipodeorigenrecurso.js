$(traedatos()); 

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_cattipoOrigenRecurso.php",
            dataType: "json",
            success: function(response) {
                //console.log(response);
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>Id</th><th>Descripción</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > <input  id='inpid" + i + "' type='text' readonly='true' value='" + datos[i].numTipoOrigenRecurso + "'> </td>";
                        // tabla += "<td><input  id='inpmensualuma" + i + "' type='text' readonly='true' value='" + datos[i].idEntidad + "'></td>";
                        tabla += "<td><input class='form-control input-lg' id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].Descripcion + "'></td>";
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
    $("#errorMsg").html("");
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpid" + i).prop('readonly', false);
        $("#inpdescripcion" + i).prop('readonly', false);
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
        }
        if (id == "") {
            $(document).scrollTop(0);
            var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Id: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerror);
            //alert("vacio");
        } else if (descripcion == "") {
            $(document).scrollTop(0);
            var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Descripción: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerror);
        } else {
            $("#errorMsg").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inpid" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdatecattipoOrigenRecurso.php',
                data: {
                    'descripcion': descripcion,
                    'id': id,
                    'accion': 2
                },
                success: function(response) {
                    console.log(response);
                    $(document).scrollTop(0);
                    $("#errorMsg").html("");
                    var Msgerror = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsg").html(Msgerror);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var descripcion = Array();
        var id = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        //alert(c);
        for (var i = 0; i < b - 1; i++) {
            descripcion[i] = $("#inpdescripcion" + i).val();
            id[i] = $("#inpid" + i).val();
            if (id[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Id en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerror);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (descripcion[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Descripción en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerror);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdatecattipoOrigenRecurso.php',
            data: {
                'descripcion': descripcion,
                'id': id,
                'accion': 1
            }, //capturo array     
            success: function(response) {
                //console.log(response);
                $(document).scrollTop(0);
                $("#errorMsg").html("");
                var Msgerror = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerror);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b - 1; i++) {
                    $("#inpdescripcion" + i).prop('readonly', true);
                    $("#inpid" + i).prop('readonly', true);
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
    // var cell2 = row.insertCell(2);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > <input id='inpid" + i + "' type='text'> </td>";
        cell1.innerHTML = "<input class='form-control input-lg' id='inpdescripcion" + i + "' type='text'>";
        //cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}