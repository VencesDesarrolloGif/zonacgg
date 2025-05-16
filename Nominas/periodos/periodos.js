$(inicioPeriodoJS());  
function inicioPeriodoJS(){
    llenaselectordescripcionperiodo();
    llenaselectordescripcionnuevo();
}

function llenaselectordescripcionperiodo() {
    $.ajax({
        type: "POST",
        url: "ajax_periodos.php",
        data: {
            "idperiodo": 0
        },
        dataType: "json",
        success: function(response) {
            $("#datos").empty();
            //console.log(response);
            $(document).scrollTop(0);
            datos = response.datos;
            $('#seldescripcionperiodo').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
            $.each(datos, function(i) {
                $('#seldescripcionperiodo').append('<option value="' + response.datos[i].IdPeriodo + '">' + response.datos[i].Descripcion + '</option>');
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function llenaselectordescripcionnuevo() {
    $.ajax({
        type: "POST",
        url: "ajax_llenaselectordescripcionnuevo.php",
        data: {
            "iddescripcion": 0,
        },
        dataType: "json",
        success: function(response) {
            //console.log(response);
            $(document).scrollTop(0);
            datos = response.datos;
            $('#seldescripcionperiodonuevo').empty().append('<option value="-1" selected="selected">- Seleccione -</option>');
            $.each(datos, function(i) {
                $('#seldescripcionperiodonuevo').append('<option value="' + response.datos[i].IdPeriodo + '">' + response.datos[i].Descripcion + '</option>');
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}
$("#seldescripcionperiodonuevo").change(function() {
    $("#errorMsgtblperiodos").html("");
    var posicion = document.getElementById('seldescripcionperiodonuevo').options.selectedIndex;
    if (posicion == 1) {
        $("#descripcion").val('');
        $("#divinpdescripcion").show("fast");
        $("#diaspago").show("fast");
        $("#diaspago").val('');
        $("#inicioderango").val("");
    } else if (posicion == 2) {
        $("#descripcion").val('EXTRAORDINARIO');
        $("#diaspago").hide("fast");
        $("#divinpdescripcion").hide("fast");
        $("#diaspago").val(1);
        $("#inicioderango").val("");
    } else {
        $("#descripcion").val(' ');
        $("#divinpdescripcion").hide("fast");
        $("#diaspago").show("fast");
        $("#diaspago").val('');
        $("#inicioderango").val("");
        //$("#divinpdescripcion").show("fast");
    }
}); //reisar bien para hacer el respectivo update 
$("#seldescripcionperiodo").change(function() {
    $("#errorMsgtblsalarios").empty().removeClass();
    $("#datos").empty();
    var descripcionperiodo = $('#seldescripcionperiodo').val();
    if (descripcionperiodo != 0) {
        $.ajax({
            type: "POST",
            url: "ajax_periodos.php",
            data: {
                "idperiodo": descripcionperiodo,
            },
            dataType: "json",
            success: function(response) {
                //console.log(response);
                $(document).scrollTop(0);
                datos = response.datos;
                $('#selanioperiodo').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                $.each(datos, function(i) {
                    $('#selanioperiodo').append('<option value="' + response.datos[i].IdAnio + '">' + ' días de pago: ' + response.datos[i].DiasPago + ' de: ' + response.datos[i].DescAnio + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    } else {
        $('#selanioperiodo').empty();
        $("#datos").empty();
    }
});
$("#selanioperiodo").change(function() {
    $("#errorMsgtblsalarios").empty().removeClass();
    llenatbl();
});

function llenatbl() {
    $("#datos").empty();
    var anioperiodo = $('#selanioperiodo').val();
    if (anioperiodo != 0) {
        $.ajax({
            type: "POST",
            url: "ajax_muestratablarangoperiodos.php",
            data: {
                "anioperiodo": anioperiodo
            },
            dataType: "json",
            success: function(response) {
                $("#datos").empty();
                // console.log(response);
                $(document).scrollTop(0);
                datos = response.datos;
                $("#idanio").val(response.datos[0].IdAnio);
                $("#idrango").val(response.datos[0].IdRango);
                var tabla = "<table id='tabla' class='table table-bordered'><thead><th>Número</th><th>Fecha inicio</th><th>Fecha fin</th></thead><tbody>";
                $(document).scrollTop(0);
                $.each(datos, function(i) {
                    tabla += "<tr><td > " + (i + 1) + " </td>";
                    if (i == 0) {
                        tabla += "<td>" + response.datos[i].FechaInicioP + "<img src='../../Vista/img/editIcon.png' onclick='myfunction();'>" + "</td>";
                    } else {
                        tabla += "<td>" + response.datos[i].FechaInicioP + "</td>";
                    }
                    tabla += "<td>" + response.datos[i].FechaFinP + "</td></tr>"
                });
                $("#datos").append(tabla);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    } else {
        $("#datos").empty();
    }
}

function myfunction() {
    $("#errorMsgModal").empty().removeClass();
    $('#emp').modal();
}

function nuevoperiodo() {
    $("#muestracamposnuevo").attr('style', 'display:block');
    $("#selectoresrango").attr('style', 'display:none');
    $("#btnnuevo").attr('style', 'display:none');
    llenaselectordescripcionnuevo();
}

function consultarperiodobtn() {
    $("#muestracamposnuevo").attr('style', 'display:none');
    $("#selectoresrango").attr('style', 'display:block');
    $("#btnnuevo").attr('style', 'display:block');
    $("#errorMsgtblperiodos").html("");
    $("#divinpdescripcion").hide("fast");
    $("#datos").empty();
    $('#selanioperiodo').empty();
    $("#inicioderango").val("");
    $("#diaspago").val("");
    $("#descripcion").val("");
    llenaselectordescripcionperiodo();
}

function guardarnuevoperiodo() {
    var inicioderango = $("#inicioderango").val();
    var diaspago = $("#diaspago").val();
    var descripcion = $("#descripcion").val();
    var seldescripcionperiodonu = $("#seldescripcionperiodonuevo").val();
    //validaciones de los inputs
    if (seldescripcionperiodonu === '-1') {
        var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione un periodo: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
    }
    /*else if (seldescripcionperiodonu != '0' && seldescripcionperiodonu != '-2') {
           var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Debe generar un periodo nuevo: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
           $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
       }*/
    else
    if (descripcion == "") {
        $(document).scrollTop(0);
        var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Verifique Descripción: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
        //alert("vacio");
    } else if (inicioderango == "") {
        $(document).scrollTop(0);
        var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Verifique Fecha inicio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
        //alert("vacio");
    } else if (diaspago == "" || !/^([0-9])*$/.test(diaspago)) {
        $(document).scrollTop(0);
        var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Verifique Dias de pago: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
        //alert("vacio");
    } else {
        $("#errorMsgtblperiodos").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "inserttblperiodos.php",
            data: {
                "descripcion": descripcion,
                "inicioderango": inicioderango,
                "diaspago": diaspago,
                "seldescripcionperiodonu": seldescripcionperiodonu,
            },
            dataType: "json",
            success: function(response) {
                //console.log(response);
                $("#inicioderango").val("");
                $("#diaspago").val("");
                $("#seldescripcionperiodonuevo").val("-1");
                $("#descripcion").val(' ');
                $("#divinpdescripcion").hide("fast");
                var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Periodo registrado con éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
}

function editconfirmarperiodo() {
    var editfecha = $("#fechainiciorango").val();
    var diaspagoedit = $("#diaspagoedit").val();
    var idrango = $("#idrango").val();
    var idanio = $("#idanio").val();
    if (editfecha === "") {
        var Msgerrormodal = "<div id='errorMsgModal' class='alert alert-danger'><strong>Verifique Fecha inicio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgModal").html(Msgerrormodal);
    } else if (diaspagoedit === "" || !/^([0-9])*$/.test(diaspagoedit)) {
        var Msgerrormodal = "<div id='errorMsgModal' class='alert alert-danger'><strong>Verifique Dias de pago: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#errorMsgModal").html(Msgerrormodal);
    } else {
        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_updatetblperiodos.php",
            data: {
                "editfecha": editfecha,
                "diaspagoedit": diaspagoedit,
                "idrango": idrango,
                "idanio": idanio,
            },
            dataType: "json",
            success: function(response) {
                //console.log(response);
                $("#fechainiciorango").val("");
                $("#diaspagoedit").val("");
                $('#emp').modal('hide');
                var Msgerrordescripciontblperiodos = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Periodo actualizado con éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblperiodos").html(Msgerrordescripciontblperiodos);
                llenatbl();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
    //validacion de campos del modal
}