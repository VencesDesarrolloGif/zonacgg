$(traedatos()); 

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_imss.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><TR><TH rowspan='2' style='text-align:center;'>No</TH><TH rowspan='2' style='text-align:center;'>DESCRIPCIÓN</TH><TH rowspan='2' style='text-align:center;'>TIPO</TH><TH colspan='3' style='text-align:center;'>CUOTAS A CUBRIR</TH><TH rowspan='2' style='text-align:center;'>BASE PARA CÁLCULO </TH><TH rowspan='2' style='text-align:center;'>MARCO NORMATIVIDAD</TH></TR><TR><TH>PATRÓN</TH> <TH>OBRERO</TH><TH>TOTAL</TH></TR></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td><input id='inpdescripcion" + i + "' type='text' readonly='true' value='" + datos[i].descripcion + "'></td>";
                        tabla += "<td><input id='inptipo" + i + "' type='text' readonly='true' value='" + datos[i].Tipo + "'></td>";
                        tabla += "<td ><input  id='inppatron" + i + "' type='text' readonly='true' value='" + datos[i].Patron + "'></td>";
                        tabla += "<td><input  id='inpobrero" + i + "' type='text' readonly='true' value='" + datos[i].Obrero + "'></td>";
                        tabla += "<td><input  id='inptotal" + i + "' type='text' readonly='true' value='" + datos[i].Total + "'></td>";
                        tabla += "<td><input  id='inpbasecalculo" + i + "' type='text' readonly='true' value='" + datos[i].BaseCalculo + "'></td>";
                        tabla += "<td><input id='inpmarconormativididad" + i + "' type='text' readonly='true' value='" + datos[i].MarcoNormat + "' ></td></tr>"
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
        $("#inpdescripcion" + i).prop('readonly', false);
        $("#inptipo" + i).prop('readonly', false);
        $("#inppatron" + i).prop('readonly', false);
        $("#inpobrero" + i).prop('readonly', false);
        $("#inptotal" + i).prop('readonly', false);
        $("#inpbasecalculo" + i).prop('readonly', false);
        $("#inpmarconormativididad" + i).prop('readonly', false);
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
            var descripcion = $("#inpdescripcion" + (i - 1)).val();
            var tipo = $("#inptipo" + (i - 1)).val();
            var patron = $("#inppatron" + (i - 1)).val();
            var obrero = $("#inpobrero" + (i - 1)).val();
            var total = $("#inptotal" + (i - 1)).val();
            var basecalculo = $("#inpbasecalculo" + (i - 1)).val();
            var marconormativididad = $("#inpmarconormativididad" + (i - 1)).val();
        }
        if (descripcion == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DESCRIPCIÓN: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (tipo == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique TIPO: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (patron == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PATRÓN: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (obrero == "") {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique OBRERO: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (total == "") {
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique TOTAL: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (basecalculo == "") {
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique BASE PARA CÁLCULO: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (marconormativididad == "") {
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique MARCO NORMATIVIDAD: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else {
            alert(b);
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = 0; i <= b; i++) {
                $("#inpdescripcion" + i).prop('readonly', true);
                $("#inptipo" + i).prop('readonly', true);
                $("#inppatron" + i).prop('readonly', true);
                $("#inpobrero" + i).prop('readonly', true);
                $("#inptotal" + i).prop('readonly', true);
                $("#inpbasecalculo" + i).prop('readonly', true);
                $("#inpmarconormativididad" + i).prop('readonly', true);
            }
            /* for (var i = 0; i < b - 1; i++) {
                     $("#inpdescripcion" + i).prop('readonly', true);
                     $("#inptipo" + i).prop('readonly', true);
                     $("#inppatron" + i).prop('readonly', true);
                     $("#inpobrero" + i).prop('readonly', true);
                     $("#inptotal" + i).prop('readonly', true);
                     $("#inpbasecalculo" + i).prop('readonly', true);
                     $("#inpmarconormativididad" + i).prop('readonly', true);
                     $("#btneditar").prop("disabled", false);
                     $("#btnguardar").prop("disabled", true);
                     $("#btnagregar").prop('disabled', false);
                 }*/
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblimss.php',
                data: {
                    'descripcion': descripcion,
                    'tipo': tipo,
                    'patron': patron,
                    'obrero': obrero,
                    'total': total,
                    'basecalculo': basecalculo,
                    'marconormativididad': marconormativididad,
                    'accion': 2
                },
                success: function(response) {
                    //console.log(response);
                    $(document).scrollTop(0);
                    $("#errorMsgtblsalarios").html("");
                    var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Guardado:</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                }
            });
        }
    } else if (inpaccion === "Editar") {
        var descripcion = Array();
        var tipo = Array();
        var patron = Array();
        var obrero = Array();
        var total = Array();
        var basecalculo = Array();
        var marconormativididad = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        //console.log(tipo);
        for (var i = 0; i < b - 2; i++) {
            descripcion[i] = $("#inpdescripcion" + i).val();
            tipo[i] = $("#inptipo" + i).val();
            patron[i] = $("#inppatron" + i).val();
            obrero[i] = $("#inpobrero" + i).val();
            total[i] = $("#inptotal" + i).val();
            basecalculo[i] = $("#inpbasecalculo" + i).val();
            marconormativididad[i] = $("#inpmarconormativididad" + i).val();
            // alert(descripcion);
            if (descripcion[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Debe introducir DESCRIPCION en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (tipo[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique TIPO en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (patron[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PATRÓN en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (obrero[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique OBRERO en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (total[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique TOTAL en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (basecalculo[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique BASE PARA CÁLCULO en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (marconormativididad[i] == "") {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique MARCO NORMATIVIDAD en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblimss.php',
            data: {
                'descripcion': descripcion,
                'tipo': tipo,
                'patron': patron,
                'obrero': obrero,
                'total': total,
                'basecalculo': basecalculo,
                'marconormativididad': marconormativididad,
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
                    $("#inpdescripcion" + i).prop('readonly', true);
                    $("#inptipo" + i).prop('readonly', true);
                    $("#inppatron" + i).prop('readonly', true);
                    $("#inpobrero" + i).prop('readonly', true);
                    $("#inptotal" + i).prop('readonly', true);
                    $("#inpbasecalculo" + i).prop('readonly', true);
                    $("#inpmarconormativididad" + i).prop('readonly', true);
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
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i) + " </td>";
        cell1.innerHTML = "<input id='inpdescripcion" + (i - 1) + "' type='text'>";
        cell2.innerHTML = "<input id='inptipo" + (i - 1) + "' type='text' >";
        cell3.innerHTML = "<input id='inppatron" + (i - 1) + "' type='text' >";
        cell4.innerHTML = "<input id='inpobrero" + (i - 1) + "' type='text' >";
        cell5.innerHTML = "<input id='inptotal" + (i - 1) + "' type='text' >";
        cell6.innerHTML = "<input id='inpbasecalculo" + (i - 1) + "' type='text' >";
        cell7.innerHTML = "<input id='inpmarconormativididad" + (i - 1) + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}