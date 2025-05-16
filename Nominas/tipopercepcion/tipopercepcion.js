$(inicioTipoRecepcion());  
function inicioTipoRecepcion(){
    traedatos();
    llenarselectortablas();
}
//se declara un array para saber que concepto pertenece a que tabla para identificarlos
var formula = new Array();
var miArreglo = new Array();

function traedatos() {
    $("#datos").empty();
    $("#btnagregar").prop('disabled', false);
    $("#btnguardar").prop("disabled", true);
    $("#btneditar").prop("disabled", false);
    $.ajax({
        type: "POST",
        url: "ajax_cattipopercepcion.php",
        data: {
            "accion": 2
        },
        dataType: "json",
        success: function(response) {
            console.log(response);
            var mensaje = response.message;
            var datos = response.datos;
            if (response.status == "success") {
                var tabla = "<table id='tabla' class='table table-bordered'><thead><th style='width:6%;text-align:center;'>Id</th><th style='width:61%;text-align:center'>Descripción</th><th style='width:25%;text-align:center'>Concepto sat</th>" + "<th style='text-align:center'>Fecha inicio de vigencia</th><th style='text-align:center'>Fecha fin de vigencia</th>" + "<th style='text-align:center'>Importe Total</th><th style='text-align:center'>Gravado ISR</th>" + "<th style='text-align:center'>Excento ISR</th><th style='text-align:center'>Gravado IMSS</th><th style='text-align:center'>Excento IMSS</th></thead><tbody>";
                $(document).scrollTop(0);
                $.each(datos, function(i) {
                    tabla += "<tr><td> <input  class='form-control input-lg' id='inpid" + i + "' type='text' readonly='true' value='" + datos[i].numTipoPercepcion + "'> </td>";
                    tabla += "<td><input class='form-control input-lg' id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].Descripcion + "'></td>";
                    tabla += "<td><select  class='form-control' id='selconceptosat" + i + "' type='text' disabled='true' ><option value='" + datos[i].IdTipoPercepcionSat + "'>" + datos[i].DescripcionSat + "</option></select></td>";
                    tabla += "<td><input type='date' class='form-control input-lg' id='inpfechainiv" + i + "' type='text' readonly='true' value='" + datos[i].fInicioVig + "'></td>";
                    if (datos[i].fFinVig == null) {
                        tabla += "<td><input  class='form-control input-lg' id='inpfechafinv" + i + "' type='text' readonly='true' value='" + "" + "'></td>";
                    } else {
                        tabla += "<td><input type='date' class='form-control input-lg' id='inpfechafinv" + i + "' type='text' readonly='true' value='" + datos[i].fFinVig + "'></td>";
                    }
                    tabla += "<td><input type='image'  id='inpimportetotal" + i + "' value='" + datos[i].importeTotalTP + "' src='../../Vista/img/editIcon.png' onclick='formulacion(\"" + datos[i].numTipoPercepcion + "\",\"" + datos[i].importeTotalTP + "\" ,\"" + datos[i].importeTotalfrmcadena + "\",\"" + 1 + "\")' title='" + datos[i].importeTotalTP + "'   style='margin-left:36%;cursor:pointer;'></td>";
                    tabla += "<td><input type='image'  id='inpgrabadoisr" + i + "'   value='" + datos[i].grabadoISRTP + "'src='../../Vista/img/editIcon.png' onclick='formulacion(\"" + datos[i].numTipoPercepcion + "\",\"" + datos[i].grabadoISRTP + "\",\"" + datos[i].grabadoISRfrmcadena + "\",\"" + 2 + "\")' title='" + datos[i].grabadoISRTP + "'   style='margin-left:36%;cursor:pointer;'></td>";
                    tabla += "<td><input type='image'  id='inpexcentoisr" + i + "'   value='" + datos[i].excentoISRTP + "' src='../../Vista/img/editIcon.png' onclick='formulacion(\"" + datos[i].numTipoPercepcion + "\",\"" + datos[i].excentoISRTP + "\",\"" + datos[i].excentoIMSSfrmcadena + "\",\"" + 3 + "\")' title='" + datos[i].excentoISRTP + "'   style='margin-left:36%;cursor:pointer;'></td>";
                    tabla += "<td><input type='image'  id='inpgrabadoimss" + i + "'  value='" + datos[i].grabadoIMSSTP + "' src='../../Vista/img/editIcon.png' onclick='formulacion(\"" + datos[i].numTipoPercepcion + "\",\"" + datos[i].grabadoIMSSTP + "\",\"" + datos[i].grabadoIMSSfrmcadena + "\",\"" + 4 + "\")' title='" + datos[i].grabadoIMSSTP + "'   style='margin-left:36%;cursor:pointer;'></td>";
                    tabla += "<td><input type='image'  id='inpexcentoimss" + i + "'  value='" + datos[i].excentoIMSSTP + "' src='../../Vista/img/editIcon.png' onclick='formulacion(\"" + datos[i].numTipoPercepcion + "\",\"" + datos[i].excentoIMSSTP + "\",\"" + datos[i].excentoIMSSfrmcadena + "\",\"" + 5 + "\")' title='" + datos[i].excentoIMSSTP + "'   style='margin-left:36%;cursor:pointer;'></td>";
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
    $("#btnguardar").prop("disabled", false);
    $("#btneditar").prop("disabled", true);
    $("#inpaccion").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpid" + i).prop('readonly', false);
        $("#inpdescripcion" + i).prop('readonly', false);
        $("#inpfechainiv" + i).prop('readonly', false);
        $("#inpfechafinv" + i).prop('readonly', false);
        $("#inpimportetotal" + i).prop('readonly', false);
        $("#inpgrabadoisr" + i).prop('readonly', false);
        $("#inpexcentoisr" + i).prop('readonly', false);
        $("#inpgrabadoimss" + i).prop('readonly', false);
        $("#inpexcentoimss" + i).prop('readonly', false);
        $("#selconceptosat" + i).prop('disabled', false);
        $("#inpfechafinv" + i).prop('type', 'date');
        $("#inpimportetotal" + i).prop('disabled', true);
        $("#inpgrabadoisr" + i).prop('disabled', true);
        $("#inpexcentoisr" + i).prop('disabled', true);
        $("#inpgrabadoimss" + i).prop('disabled', true);
        $("#inpexcentoimss" + i).prop('disabled', true);
    }
    cargaselectorestblpercepcionsat(1);
}

function guardar() {
    $('#errorMsg').removeClass();
    var inpaccion = $("#inpaccion").val();
    var txtareaformula = $("#txtareaformula").val();
    if (inpaccion === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        for (var i = b - 2; i < b - 1; i++) {
            var descripcion = $("#inpdescripcion" + i).val();
            var id = $("#inpid" + i).val();
            var fechainicio = $("#inpfechainiv" + i).val();
            var fechafin = $("#inpfechafinv" + i).val();
            var importetotal = $("#inpimportetotal" + i).val();
            var grabadoisr = $("#inpgrabadoisr" + i).val();
            var excentoisr = $("#inpexcentoisr" + i).val();
            var grabadoimss = $("#inpgrabadoimss" + i).val();
            var excentoimss = $("#inpexcentoimss" + i).val();
            var idconceptosat = $("#selconceptosat" + i).val();
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
        } else if (idconceptosat === "0") {
            $(document).scrollTop(0);
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Concepto Sat: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        } else if (fechainicio == "") {
            var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Fecha de inicio de vigencia: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerrorcat);
        }
        /*else if (txtareaformula == "") {
                   var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Ingrese formula</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#errorMsg").html(Msgerrorcat);
               }*/
        else {
            $("#errorMsg").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inpid" + i).prop('readonly', true);
                $("#inpfechainiv" + i).prop('readonly', true);
                $("#inpfechafinv" + i).prop('readonly', true);
                $("#inpimportetotal" + i).prop('readonly', true);
                $("#inpgrabadoisr" + i).prop('readonly', true);
                $("#inpexcentoisr" + i).prop('readonly', true);
                $("#inpgrabadoimss" + i).prop('readonly', true);
                $("#inpexcentoimss" + i).prop('readonly', true);
                $("#selconceptosat" + i).prop('disabled', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdatecattipopercepcion.php',
                data: {
                    'descripcion': descripcion,
                    'id': id,
                    'idconceptosat': idconceptosat,
                    'fechainicio': fechainicio,
                    'fechafin': fechafin,
                    'formula': '', //formula del modal 
                    'distinctcolumn': 0,
                    'accion': 2
                },
                dataType: "json",
                success: function(response) {
                    //console.log("formula", response);
                    $("#datos").empty();
                    traedatos();
                    $(document).scrollTop(0);
                    $("#errorMsg").html("");
                    var Msgerrorcat = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsg").html(Msgerrorcat);
                    $("#inpaccion").val("Editar");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var descripcion = Array();
        var id = Array();
        var fechainicio = Array();
        var fechafin = Array();
        var importetotal = Array();
        var grabadoisr = Array();
        var excentoisr = Array();
        var grabadoimss = Array();
        var excentoimss = Array();
        var idconceptosat = Array();
        var distinctcolumntbl = 0;
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        for (var i = 0; i < b - 1; i++) {
            descripcion[i] = $("#inpdescripcion" + i).val();
            id[i] = $("#inpid" + i).val();
            fechainicio[i] = $("#inpfechainiv" + i).val();
            fechafin[i] = $("#inpfechafinv" + i).val();
            importetotal[i] = $("#inpimportetotal" + i).val(); //ya no se utiliza
            grabadoisr[i] = $("#inpgrabadoisr" + i).val();
            excentoisr[i] = $("#inp excentoisr" + i).val();
            grabadoimss[i] = $("#inpgrabadoimss" + i).val();
            excentoimss[i] = $("#inpexcentoimss" + i).val();
            idconceptosat[i] = $("#selconceptosat" + i).val();
            console.log(importetotal[i]);
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
            if (idconceptosat[i] === "0") {
                $(document).scrollTop(0);
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-error'><strong>Verifique Concepto Sat en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
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
        console.log(idconceptosat[0]);
        $.ajax({
            type: "POST",
            url: 'insertyupdatecattipopercepcion.php',
            data: {
                'descripcion': descripcion,
                'id': id,
                'idconceptosat': idconceptosat,
                'fechainicio': fechainicio,
                'fechafin': fechafin,
                'formula': txtareaformula, //formula del modal 
                'distinctcolumn': distinctcolumntbl,
                'accion': 1,
            },
            dataType: "json", //capturo array     
            success: function(response) {
                $("#datos").empty();
                traedatos();
                console.log(response);
                $(document).scrollTop(0);
                $("#errorMsg").html("");
                var Msgerrorcat = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerrorcat);
                var b = $("#tabla tr").length;
                var c = $("#tabla tr:last td").length;
                for (var i = 0; i < b; i++) {
                    $("#inpdescripcion" + i).prop('readonly', true);
                    $("#inpid" + i).prop('readonly', true);
                    $("#inpfechainiv" + i).prop('readonly', true);
                    $("#inpfechafinv" + i).prop('readonly', true);
                    $("#inpimportetotal" + i).prop('readonly', true);
                    $("#inpgrabadoisr" + i).prop('readonly', true);
                    $("#inpexcentoisr" + i).prop('readonly', true);
                    $("#inpgrabadoimss" + i).prop('readonly', true);
                    $("#inpexcentoimss" + i).prop('readonly', true);
                    $("#btneditar").prop("disabled", false);
                    $("#btnguardar").prop("disabled", true);
                    $("#btnagregar").prop('disabled', false);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
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
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    var cell8 = row.insertCell(8);
    var cell9 = row.insertCell(9);
    //para el id es (b-1);
    // var cell2 = row.insertCell(2);
    //<button  id='inpimportetota" + i + "'><img id='inpimportetotal" + i + "' src='../../Vista/img/editIcon.png' onclick='formulacion()' title='AGREGAR NUEVA FORMULACION'  style='margin-left:36%;cursor:pointer;'></button>
    //for (var i = 0; i < b; i++) {
    $("#inpimportetotal" + (b - 1)).prop('disabled', true);
    contfila.innerHTML = "<td><input id='inpid" + (b - 1) + "' type='text'> </td>";
    cell1.innerHTML = "<input class='form-control input-lg' id='inpdescripcion" + (b - 1) + "' type='text'>";
    cell2.innerHTML = "<select class='form-control'  id='selconceptosat" + (b - 1) + "' ></select>";
    cell3.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechainiv" + (b - 1) + "' type='text'>";
    cell4.innerHTML = "<input type='date' class='form-control input-lg' id='inpfechafinv" + (b - 1) + "' type='text'>";
    /* cell5.innerHTML = "<input type='image' id='inpimportetotal" + (b - 1) + "' src='../../Vista/img/editIcon.png' onclick='formulacion(" + 0 + "," + 0 + ")' title='AGREGAR NUEVA FORMULACION'  style='margin-left:36%;cursor:pointer;'/> ";
    cell6.innerHTML = "<input class='form-control input-lg' id='inpgrabadoisr" + (b - 1) + "' type='text'>";
    cell7.innerHTML = "<input class='form-control input-lg' id='inpexcentoisr" + (b - 1) + "' type='text'>";
    cell8.innerHTML = "<input class='form-control input-lg' id='inpgrabadoimss" + (b - 1) + "' type='text'>";
    cell9.innerHTML = "<input class='form-control input-lg' id='inpexcentoimss" + (b - 1) + "' type='text'>";*/
    //cell2.innerHTML = "<input id='inpporcentajeimpuesto" + i + "' type='text' >";;
    cargaselectorestblpercepcionsat(0);
    //}
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}

function formulacion(numpercepcion, formulaa, fromulacionconids, discolumntbl) {
    $("#errorMsg").html("");
    // alert(fromulacionconids);
    /*  if (fromulacionconids == 'null') {
          alert("hola soy null");
         
      } */
    if (numpercepcion === 0 && formulaa === 0 || formulaa == 'Agregar formula' || fromulacionconids == 'null') {
        formula = [];
        miArreglo = [];
        $("#txtareaformula").empty().append(" " + miArreglo.join(" "));
        $("#hdnnumtipopercepcion").val(numpercepcion);
        $("#hdndistinctcolumntbl").val(discolumntbl);
        formulaa = fromulacionconids.trim();
        //se declara un array para saber que concepto pertenece a que tabla para identificarlos
        //var formula = new Array();
        //var miArreglo = new Array();
    } else {
        var micadena = fromulacionconids.trim();
        var miArreglo2 = micadena.split(",");
        formula = miArreglo2;
        ///para ingresar como tal la formula al arreglo global (formula)
        var arr = formulaa.trim();
        var miArreglo2 = arr.split(" ");
        miArreglo = miArreglo2;
        $("#hdnnumtipopercepcion").val(numpercepcion);
        $("#txtareaformula").empty().append(" " + miArreglo.join(" "));
        // console.log("formula", miArreglo);
        $("#hdndistinctcolumntbl").val(discolumntbl);
        console.log("formula", formula);
    }
    $("#modalformulacion").modal();
    // $("#formulariopaso").prop("action", "../tipopercepcionformulacion/tipopercepcionformulacion.php?percepcion=" + numpercepcionn).attr("method", "post").submit();
}

function llenarselectortablas() {
    $.ajax({
        type: "POST",
        url: "ajax_consultatablasbdzonagif.php",
        data: {
            "accion": 1,
            "nombretbl": "",
        },
        dataType: "json",
        success: function(response) {
            // console.log(response);
            datos = response.datos;
            //console.log(datos);
            $('#seltablas').append('<option value="0" selected="selected">- Seleccione -</option>');
            a = 1;
            $.each(datos, function(i) {
                $('#seltablas').append('<option value="' + a + '">' + response.datos[i].Tables_in_zonagif + '</option>');
                a++;
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}
$("#seltablas").change(function() {
    $("#selcolumns").empty();
    var tablaseleccionada = $('select[id="seltablas"] option:selected').text();
    if ($("#seltablas").val() != 0) {
        $.ajax({
            type: "POST",
            url: "ajax_consultatablasbdzonagif.php",
            data: {
                "accion": 2,
                "nombretbl": tablaseleccionada,
            },
            dataType: "json",
            success: function(response) {
                // console.log(response);
                datos = response.datos;
                //console.log(datos);
                $('#selcolumns').append('<option value="0" selected="selected">- Seleccione -</option>');
                a = 1;
                $.each(datos, function(i) {
                    $('#selcolumns').append('<option value="' + a + '">' + response.datos[i].Field + '</option>');
                    a++;
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    } else {
        $('#selcolumns').empty();
        $("#btnagregarenmodal").prop("disabled", true);
    }
});
$("#selcolumns").change(function() {
    if ($("#selcolumns").val() != 0) {
        $("#btnagregarenmodal").prop("disabled", false);
    } else {
        $("#btnagregarenmodal").prop("disabled", true);
    }
});

function agregarconcepto(opcion) {
    var idtabla = $('select[id="seltablas"] option:selected').text();
    var columnatabla = $('select[id="selcolumns"] option:selected').text();
    if (opcion == 2 || opcion == 3 || opcion == 4 || opcion == 5 || opcion == 6 || opcion == 7 || opcion == 8) {
        var columnatabla = $('#imgsum' + opcion).attr('value');
        var stringdecadenaparaarray = columnatabla;
        var stringpararraytextarea = columnatabla;
    } else if (opcion == 1) {
        stringdecadenaparaarray = idtabla + "-" + columnatabla;
        stringpararraytextarea = columnatabla;
    }
    $("#txtareaformula").append(" " + columnatabla);
    formula.push(stringdecadenaparaarray);
    miArreglo.push(stringpararraytextarea);
    console.log("formulacompleta", formula); //arreglo que contiene el nombre de la tabla y su atributo
    console.log("miarreglo", miArreglo);
}

function quitarconcepto() {
    //var a = formula.length;
    formula.pop();
    console.log(formula);
    miArreglo.pop();
    console.log(miArreglo);
    $("#txtareaformula").empty().append(" " + miArreglo.join(" ")); //join sirve para eliminar las comas que se generan al llenar el array
}

function guardarformula() {
    console.log("arrayformula en guardarformula", formula);
    var distinctcolumntbl = $("#hdndistinctcolumntbl").val();
    $("#errormsgformulacion").html("");
    var txtareaformulacionconespacio = $("#txtareaformula").val();
    var id = $("#hdnnumtipopercepcion").val();
    txtareaformulacion = txtareaformulacionconespacio.trim();
    var miCadena2 = txtareaformulacion;
    var miArreglo2 = miCadena2.split(" ");
    miArreglo = miArreglo2;
    console.log("formula en guardar", formula); //arreglo que contiene el nombre de la tabla y su atributo
    //console.log("miarreglo", miArreglo);
    console.log("miarreglo en guardar formula", miArreglo);
    if ($("#inpaccion").val() === "Editar") {
        if (txtareaformulacion === "") {
            var msgerrorformulacion = "<div id='errormsgformulacion' class='alert alert-error'><strong> No puedes dejar formulacion vacia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errormsgformulacion").html(msgerrorformulacion);
        } else {
            $.ajax({
                type: "POST",
                url: 'insertyupdatecattipopercepcion.php',
                data: {
                    'descripcion': 0,
                    'id': id, //numero id  de percepcion 
                    'fechainicio': 0,
                    'fechafin': 0,
                    'formula': txtareaformulacion, //formula del modal 
                    'idconceptosat': 0,
                    'accion': 3,
                    'distinctcolumn': distinctcolumntbl,
                    'formulacompleta': formula,
                },
                dataType: "json", //capturo array     
                success: function(response) {
                    //console.log("response", response);
                    $("#modalformulacion").modal('hide');
                    $("#errorMsg").html("");
                    var Msgerrorcat = "<div id='errorMsg' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsg").html(Msgerrorcat);
                    traedatos();
                    /*
                    traedatos();
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
                        $("#inpimportetotal" + i).prop('readonly', true);
                        $("#inpgrabadoisr" + i).prop('readonly', true);
                        $("#inpexcentoisr" + i).prop('readonly', true);
                        $("#inpgrabadoimss" + i).prop('readonly', true);
                        $("#inpexcentoimss" + i).prop('readonly', true);
                        $("#btneditar").prop("disabled", false);
                        $("#btnguardar").prop("disabled", true);
                        $("#btnagregar").prop('disabled', false);
                    }*/
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }
    } else {
        if (txtareaformulacion === "") {
            var msgerrorformulacion = "<div id='errormsgformulacion' class='alert alert-error'><strong> No puedes dejar formulacion vacia</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errormsgformulacion").html(msgerrorformulacion);
        } else {
            var Msgerrorcat = "<strong>Debes presionar el boton Guardar para alamcenar la informacion: </strong>";
            $('#errorMsg').addClass('alert alert-warning').html(Msgerrorcat);
            $("#modalformulacion").modal('hide');
        }
    }
}

function cargaselectorestblpercepcionsat(valor) {
    var b = $("#tabla tr").length;
    $.ajax({
        type: "POST",
        url: 'ajax_cattipopercepcion.php',
        data: {
            'accion': valor,
        },
        dataType: "json", //capturo array     
        success: function(response) {
            // console.log(response);
            var datos = response.datos;
            if (valor == 0) {
                $("#selconceptosat" + (b - 2)).append('<option value="0" selected="selected">- Seleccione -</option>');
                b = (b - 1);
            }
            for (i = 0; i < b; i++) { // Bucle exterior
                for (j = 0; j < datos.length; j++) { // Bucle interior
                    //console.log("datos" + j);
                    $("#selconceptosat" + i).append('<option value="' + response.datos[j].IdTipoPercepcionSat + '">' + response.datos[j].DescripcionSat + '</option>');
                }
            }
        }
    });
}