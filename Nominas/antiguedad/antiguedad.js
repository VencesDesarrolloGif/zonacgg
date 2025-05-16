$(traedatos());  

    function traedatos() {
        $.ajax({
            type: "POST",
            url: "ajax_tblantiguedad.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success") {
                    var mensaje = response.message;
                    var datos = response.datos;
                    var tabla = "<table id='tabla' class='table table-bordered'><thead><th>No</th><th>Antigüedad</th><th>DiasVacConf</th><th>DiasVacSind</th><th>PorcPrimaConf</th><th>PorcPrimaSind</th><th>DiasAntigConf</th><th>DiasAntigSind</th><th>DiasAguinaldoConf</th><th>DiasAguinaldoSind</th></thead><tbody>";
                    $(document).scrollTop(0);
                    $.each(datos, function(i) {
                        tabla += "<tr><td > " + (i + 1) + " </td>";
                        tabla += "<td ><input id='inpantiguedad" + i + "' type='text' required='required' readonly='true' value='" + datos[i].Antiguedad + "'></td>";
                        tabla += "<td><input  id='inpdiasvacconf" + i + "' type='text' readonly='true' value='" + datos[i].DiasVacConf + "'></td>";
                        tabla += "<td><input  id='inpdiasvacsind" + i + "' type='text' readonly='true' value='" + datos[i].DiasVacSind + "'></td>";
                        tabla += "<td><input  id='inpporcprimaconf" + i + "' type='text' readonly='true' value='" + datos[i].PorcPrimaConf + "'></td>";
                        tabla += "<td><input  id='inpporcprimasind" + i + "' type='text' readonly='true' value='" + datos[i].PorcPrimaSind + "'></td>";
                        tabla += "<td><input  id='inpdiasantigconf" + i + "' type='text' readonly='true' value='" + datos[i].DiasAntigConf + "'></td>";
                        tabla += "<td><input  id='inpdiasantigsind" + i + "' type='text' readonly='true' value='" + datos[i].DiasAntigSind + "'></td>";
                        tabla += "<td><input  id='inpdiasaguinaldoconf" + i + "' type='text' readonly='true' value='" + datos[i].DiasAguinaldoConf + "'></td>";
                        tabla += "<td><input  id='inpdiasaguinaldosind" + i + "' type='text' readonly='true' value='" + datos[i].DiasAguinaldoSind + "' ></td></tr>"
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
        $("#inpantiguedad" + i).prop('readonly', false);
        $("#inpdiasvacconf" + i).prop('readonly', false);
        $("#inpdiasvacsind" + i).prop('readonly', false);
        $("#inpporcprimaconf" + i).prop('readonly', false);
        $("#inpporcprimasind" + i).prop('readonly', false);
        $("#inpdiasantigconf" + i).prop('readonly', false);
        $("#inpdiasantigsind" + i).prop('readonly', false);
        $("#inpdiasaguinaldoconf" + i).prop('readonly', false);
        $("#inpdiasaguinaldosind" + i).prop('readonly', false);
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
            var antiguedad = $("#inpantiguedad" + i).val();
            var diasvacconf = $("#inpdiasvacconf" + i).val();
            var diasvacsind = $("#inpdiasvacsind" + i).val();
            var porcprimaconf = $("#inpporcprimaconf" + i).val();
            var porcprimasind = $("#inpporcprimasind" + i).val();
            var diasantigconf = $("#inpdiasantigconf" + i).val();
            var diasantigsind = $("#inpdiasantigsind" + i).val();
            var diasaguinaldoconf = $("#inpdiasaguinaldoconf" + i).val();
            var diasaguinaldosind = $("#inpdiasaguinaldosind" + i).val();
        }
        if (antiguedad == "" || !/^([0-9])*$/.test(antiguedad)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Antigüedad: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
            //alert("vacio");
        } else if (diasvacconf == "" || !/^([0-9])*$/.test(diasvacconf)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasVacConf: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (diasvacsind == "" || !/^([0-9])*$/.test(diasvacsind)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasVacSind: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (porcprimaconf == "" || !/^([0-9])*$/.test(porcprimaconf)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PorcPrimaConf: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (porcprimasind == "" || !/^([0-9])*$/.test(porcprimasind)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PorcPrimaSind: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (diasantigconf == "" || !/^([0-9])*$/.test(diasantigconf)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAntigConf: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (diasantigsind == "" || !/^([0-9])*$/.test(diasantigsind)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAntigSind: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (diasaguinaldoconf == "" || !/^([0-9])*$/.test(diasaguinaldoconf)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAguinaldoConf: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else if (diasaguinaldosind == "" || !/^([0-9])*$/.test(diasaguinaldosind)) {
            $(document).scrollTop(0);
            var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAguinaldoSind: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
        } else {
            $("#errorMsgtblsalarios").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpantiguedad" + i).prop('readonly', true);
                $("#inpdiasvacconf" + i).prop('readonly', true);
                $("#inpdiasvacsind" + i).prop('readonly', true);
                $("#inpporcprimaconf" + i).prop('readonly', true);
                $("#inpporcprimasind" + i).prop('readonly', true);
                $("#inpdiasantigconf" + i).prop('readonly', true);
                $("#inpdiasantigsind" + i).prop('readonly', true);
                $("#inpdiasaguinaldoconf" + i).prop('readonly', true);
                $("#inpdiasaguinaldosind" + i).prop('readonly', true);
            }
            $.ajax({
                type: "POST",
                url: 'insertyupdateatblantiguedad.php',
                data: {
                    'antiguedad': antiguedad,
                    'diasvacconf': diasvacconf,
                    'diasvacsind': diasvacsind,
                    'porcprimaconf': porcprimaconf,
                    'porcprimasind': porcprimasind,
                    'diasantigconf': diasantigconf,
                    'diasantigsind': diasantigsind,
                    'diasaguinaldoconf': diasaguinaldoconf,
                    'diasaguinaldosind': diasaguinaldosind,
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
        var antiguedad = Array();
        var diasvacconf = Array();
        var diasvacsind = Array();
        var porcprimaconf = Array();
        var porcprimasind = Array();
        var diasantigconf = Array();
        var diasantigsind = Array();
        var diasaguinaldoconf = Array();
        var diasaguinaldosind = Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            antiguedad[i] = $("#inpantiguedad" + i).val();
            diasvacconf[i] = $("#inpdiasvacconf" + i).val();
            diasvacsind[i] = $("#inpdiasvacsind" + i).val();
            porcprimaconf[i] = $("#inpporcprimaconf" + i).val();
            porcprimasind[i] = $("#inpporcprimasind" + i).val();
            diasantigconf[i] = $("#inpdiasantigconf" + i).val();
            diasantigsind[i] = $("#inpdiasantigsind" + i).val();
            diasaguinaldoconf[i] = $("#inpdiasaguinaldoconf" + i).val();
            diasaguinaldosind[i] = $("#inpdiasaguinaldosind" + i).val();
            if (antiguedad[i] == "" || !/^([0-9])*$/.test(antiguedad[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique Antigüedad en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                //alert("fecha invalida en la posicion:" + (i + 1));
                return 0;
            }
            if (diasvacconf[i] == "" || !/^([0-9])*$/.test(diasvacconf[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasVacConf en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (diasvacsind[i] == "" || !/^([0-9])*$/.test(diasvacsind[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasVacSind en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (porcprimaconf[i] == "" || !/^([0-9])*$/.test(porcprimaconf[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PorcPrimaConf en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (porcprimasind[i] == "" || !/^([0-9])*$/.test(porcprimasind[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique PorcPrimaSind en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (diasantigconf[i] == "" || !/^([0-9])*$/.test(diasantigconf[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAntigConf en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (diasantigsind[i] == "" || !/^([0-9])*$/.test(diasantigsind[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAntigSind en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (diasaguinaldoconf[i] == "" || !/^([0-9])*$/.test(diasaguinaldoconf[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAguinaldoConf en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
            if (diasaguinaldosind[i] == "" || !/^([0-9])*$/.test(diasaguinaldosind[i])) {
                $(document).scrollTop(0);
                var Msgerrorfechatblsalarios = "<div id='errorMsgtblsalarios' class='alert alert-error'><strong>Verifique DiasAguinaldoSind en la fila : " + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsgtblsalarios").html(Msgerrorfechatblsalarios);
                return 0;
            }
        }
        $.ajax({
            type: "POST",
            url: 'insertyupdateatblantiguedad.php',
            data: {
                'antiguedad': antiguedad,
                'diasvacconf': diasvacconf,
                'diasvacsind': diasvacsind,
                'porcprimaconf': porcprimaconf,
                'porcprimasind': porcprimasind,
                'diasantigconf': diasantigconf,
                'diasantigsind': diasantigsind,
                'diasaguinaldoconf': diasaguinaldoconf,
                'diasaguinaldosind': diasaguinaldosind,
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
                    $("#inpantiguedad" + i).prop('readonly', true);
                    $("#inpdiasvacconf" + i).prop('readonly', true);
                    $("#inpdiasvacsind" + i).prop('readonly', true);
                    $("#inpporcprimaconf" + i).prop('readonly', true);
                    $("#inpporcprimasind" + i).prop('readonly', true);
                    $("#inpdiasantigconf" + i).prop('readonly', true);
                    $("#inpdiasantigsind" + i).prop('readonly', true);
                    $("#inpdiasaguinaldoconf" + i).prop('readonly', true);
                    $("#inpdiasaguinaldosind" + i).prop('readonly', true);
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
    var cell8 = row.insertCell(8);
    var cell9 = row.insertCell(9);
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpantiguedad" + i + "' type='text'>";
        cell2.innerHTML = "<input id='inpdiasvacconf" + i + "' type='text' >";
        cell3.innerHTML = "<input id='inpdiasvacsind" + i + "' type='text' >";
        cell4.innerHTML = "<input id='inpporcprimaconf" + i + "' type='text' >";
        cell5.innerHTML = "<input id='inpporcprimasind" + i + "' type='text' >";
        cell6.innerHTML = "<input id='inpdiasantigconf" + i + "' type='text' >";
        cell7.innerHTML = "<input id='inpdiasantigsind" + i + "' type='text' >";
        cell8.innerHTML = "<input id='inpdiasaguinaldoconf" + i + "' type='text' >";
        cell9.innerHTML = "<input id='inpdiasaguinaldosind" + i + "' type='text' >";
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}