$(traedatos());  

function traedatos() {
    $.ajax({
        type: "POST",
        url: "ajax_catalogoBancos.php",
        dataType: "json",
        success: function(response) {
            //console.log(response);
            if (response.status == "success") {
                var mensaje = response.message;
                var datos = response.datos;
                var tabla = "<table id='tabla' class='table table-bordered'><thead><th>Id</th><th>Descripción</th><th>Nombre o razón social</th><th>Fecha inicio de vigencia</th><th>Fecha fin de vigencia</th><th>Acción</th></thead><tbody>";
                $(document).scrollTop(0);
                $.each(datos, function(i) {
                    tabla += "<tr><td > <input  id='inpid" + i + "' type='text' readonly='true' value='" + datos[i].idCuentaBanco + "'> </td>";
                    tabla += "<td><input class='form-control input-lg' id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].nombreBanco + "'></td>";
                    tabla += "<td><input class='form-control input-lg' id='inpnombrerazonsocial" + i + "' type='text' readonly='true' value='" + datos[i].razonSocialBanco + "'></td>";
                    tabla += "<td><input class='form-control input-lg' id='inpfechainiciov" + i + "' type='text' readonly='true' value='" + datos[i].fechaInicio + "'></td>";
                    if (datos[i].fechaFin == null) {
                        tabla += "<td><input type='text' class='form-control input-lg' id='inpfechafinv" + i + "'  readonly='true' value='" + "" + "'></td>";
                    } else {
                        tabla += "<td><input type='date' class='form-control input-lg' id='inpfechafinv" + i + "'  readonly='true' value='" + datos[i].fechaFin + "'></td>";
                    }
                    tabla += "<td><img style='width: 50%' title='Editar' src='../../Vista/img/edit.png' class='cursorImg' id='btneditar' onclick='editar(" + i + ")'><img style='width: 50%' title='Guardar' src='../../Vista/img/save.png' class='cursorImg' id='btnguardar' onclick='guardar(" + i + "," + 1 + ")'></td>";
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

function editar(i) {
    $("#errorMsg").html("");
    $("#inpdescripcion" + i).prop('readonly', false);
    $("#inpnombrerazonsocial" + i).prop('readonly', false);
    $("#inpfechainiciov" + i).prop('readonly', false);
    $("#inpfechafinv" + i).prop('readonly', false);
    $("#inpfechainiciov" + i).prop('type', 'date');
    $("#inpfechafinv" + i).prop('type', 'date');
}

function guardar(i, accion) {
    var accion = accion;
    var id = $("#inpid" + i).val();
    var descripcion = $("#inpdescripcion" + i).val();
    var razonsocial = $("#inpnombrerazonsocial" + i).val();
    var fechainicio = $("#inpfechainiciov" + i).val();
    var fechafin = $("#inpfechafinv" + i).val();
    if (id == "") {
        var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Id: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsg").html(Msgerror);
        $(document).scrollTop(0);
    } else if (descripcion == "") {
        var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Descripción: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsg").html(Msgerror);
        $(document).scrollTop(0);
    } else if (razonsocial == "") {
        var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Nombre o razón social: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsg").html(Msgerror);
        $(document).scrollTop(0);
    } else if (fechainicio == "") {
        var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Fecha inicio de vigencia: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsg").html(Msgerror);
        $(document).scrollTop(0);
    } else {
        $.ajax({
            type: "POST",
            url: 'insertyupdatecatbancos.php',
            data: {
                'descripcion': descripcion,
                'razonsocial': razonsocial,
                'fechainicio': fechainicio,
                'fechafin': fechafin,
                'id': id,
                'accion': accion
            },
            success: function(response) {
                console.log(response);
                $(document).scrollTop(0);
                $("#errorMsg").html("");
                var Msgerrorfechatblsalarios = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorfechatblsalarios);
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inpnombrerazonsocial" + i).prop('readonly', true);
                $("#inpfechainiciov" + i).prop('readonly', true);
                $("#inpfechafinv" + i).prop('readonly', true);
                $("#btnagregar").prop('disabled', false);
            }
        });
    }
}

function agregarfila() {
    $('html,body').animate({
        scrollTop: $("#abajo").offset().top
    }, 900);
    $("#errorMsg").html("");
    $("#btneditar").prop("disabled", true);
    var b = $("#tabla tr").length;
    var table = document.getElementById("tabla");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    // var cell2 = row.insertCell(2);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = "<td > <input id='inpid" + i + "' type='text'> </td>";
        cell1.innerHTML = "<input class='form-control input-lg' id='inpdescripcion" + i + "' type='text'>";
        cell2.innerHTML = "<input class='form-control input-lg' id='inpnombrerazonsocial" + i + "' type='text'>";
        cell3.innerHTML = "<input class='form-control input-lg' id='inpfechainiciov" + i + "' type='date'>";
        cell4.innerHTML = "<input class='form-control input-lg' id='inpfechafinv" + i + "' type='date'>";
        cell5.innerHTML = "<img style='width: 50%' title='Guardar' src='../../Vista/img/save.png' class='cursorImg' id='btnguardar' onclick='guardar(" + i + "," + 2 + ")'>";
        //cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
}