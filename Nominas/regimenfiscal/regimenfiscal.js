$(traedatos());

function traedatos() {
    $.ajax({
        type: "POST",
        url: "ajax_cattiporegimenf.php",
        dataType: "json",
        success: function(response) {
            //console.log(response);
            if (response.status == "success") {
                var mensaje = response.message;
                var datos = response.datos;
                var tabla = "<table id='tabla' class='table table-bordered'><thead><TR><TH rowspan='2' style='text-align:center;width:18%'>Id</TH><TH rowspan='2' style='text-align:center;width:180%;'>Descripción</TH><TH colspan='2' style='text-align:center;'>Aplica para tipo persona</TH><TH rowspan='2' style='text-align:center;'>Fecha de inicio de vigencia</TH><TH rowspan='2' style='text-align:center;'>Fecha fin de vigencia</TH></TR><TR><TH>Física</TH> <TH>Moral</TH></TR></thead><tbody>";
                $(document).scrollTop(0);
                $.each(datos, function(i) {
                    tabla += "<tr><td > <input style='width:60%'  id='inpid" + i + "' type='text' readonly='true' value='" + datos[i].numTipoRegimenF + "'> </td>";
                    tabla += "<td ><input style='width:100%' title='" + datos[i].Descripcion + "'  id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].Descripcion + "'></td>";
                    tabla += "<td><input  id='selpersonaf" + i + "' type='text' readonly='true' value='" + datos[i].PersonaF + "'></td>";
                    tabla += "<td><input  id='selpersonam" + i + "' type='text' readonly='true' value='" + datos[i].PersonaM + "'></td>";
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
    for (var i = 0; i < b; i++) {
        $("#inpid" + i).prop('readonly', false);
        $("#inpdescripcion" + i).prop('readonly', false);
        $("#inpfechainiv" + i).prop('readonly', false);
        $("#inpfechafinv" + i).prop('readonly', false);
        $("#selpersonaf" + i).prop('readonly', false);
        $("#selpersonam" + i).prop('readonly', false);
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
        for (var i = b - 3; i < b - 2; i++) {
            var personaf = $("#selpersonaf" + i).val();
            var personam = $("#selpersonam" + i).val();
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
        } else if (personaf === "0") {
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Aplica para tipo persona física: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else if (personam === "0") {
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Aplica para tipo persona moral: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else if (fechainicio == "") {
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Fecha de inicio de vigencia: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else {
            $("#errorMsg").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 3; i < b - 2; i++) {
                $("#selpersonaf" + i).attr('disabled', true);
                $("#selpersonam" + i).attr('disabled', true);
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inpid" + i).prop('readonly', true);
                $("#inpfechainiv" + i).prop('readonly', true);
                $("#inpfechafinv" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdatecatregimenfiscal.php',
                data: {
                    'descripcion': descripcion,
                    'id': id,
                    'personaf': personaf,
                    'personam': personam,
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
        var personaf = Array();
        var personam = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        for (var i = 0; i < b - 2; i++) {
            personaf[i] = $("#selpersonaf" + i).val();
            personam[i] = $("#selpersonam" + i).val();
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
            if (personaf[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Aplica para tipo persona física en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                return 0;
            }
            if (personam[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Aplica para tipo persona moral en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
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
            url: 'insertyupdatecatregimenfiscal.php',
            data: {
                'descripcion': descripcion,
                'id': id,
                'personaf': personaf,
                'personam': personam,
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
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    // var cell2 = row.insertCell(2);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td> <input id='inpid" + (i - 1) + "' type='text' style='width:60%' > </td>";
        cell1.innerHTML = "<input style='width:100%'   id='inpdescripcion" + (i - 1) + "' type='text'>";
        cell2.innerHTML = "<select  id='selpersonaf" + (i - 1) + "' type='text'><option value='0'>--Seleccione una opción--</option><option value='SI'>SI</option><option value='No'>No</option></select>";
        cell3.innerHTML = "<select  id='selpersonam" + (i - 1) + "' type='text'><option value='0'>--Seleccione una opción--</option><option value='SI'>SI</option><option value='No'>No</option></select>";
        cell4.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechainiv" + (i - 1) + "' type='text'>";
        cell5.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechafinv" + (i - 1) + "' type='text'>";
        //cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}