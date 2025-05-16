$(traedatosdiasferiados());  

function traedatosdiasferiados() {
 $("#errorMsg").html("");
 $("#btneditar").prop("disabled", false);
 $("#btnguardar").prop("disabled", true);
 $("#btnagregar").prop('disabled', false);
 
 $.ajax({
  type: "POST",
  url: "ajax_ConsultaDiasFeriados.php",
  dataType: "json",
  success: function(response) {
   if (response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#datos").empty();
       var tabla  = "<table id='tabla' class='table table-bordered'><thead> <th>No</th> <th>Fecha Del Dia Feriado</th> <th>Motivo Del Dia Feriado</th> <th>Eliminar</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
       tabla += "<tr><td > " + (i + 1) + " </td>";                        
       tabla += "<td><input id='inpfechadia" + i + "' type='date' readonly='true' value='" + datos[i].fechaDiaFestivo + "'><input id='inpfechaDiaFAnterior" + i + "' type='hidden'  value='" + datos[i].fechaDiaFestivo + "'></td>";
       tabla += "<td><input id='inpMotivo" + i + "' type='text' readonly='true' value='" + datos[i].motivoDiaFestivo + "'><input id='inpmotivoDiaFAnterior" + i + "' type='hidden'  value='" + datos[i].motivoDiaFestivo + "'></td>";
       tabla += "<td><img style='width: 20%' title='Eliminar' src='../img/eliminar.png' class='cursorImg' id='btneliminar' onclick='Eliminarbtn("+ i +")'></td>";
       
       });                
       $("#datos").append(tabla);
       $("#ModalP").modal("hide");
                    $("#procesando").hide();
    }else{
           var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}

function Eliminarbtn(i){
    var fecha     = $("#inpfechaDiaFAnterior" + i).val();
    var movimiento= $("#inpmotivoDiaFAnterior" + i).val();
    $("#ModalP").modal("show"); 
    $("#procesando").show(); 
    $.ajax({
         type: "POST",
         url: 'ajax_EliminarDiaFeriado.php',
         data: {
             'fecha': fecha,
             'movimiento': movimiento
         },
         success: function(response) { 

             $("#msgAccionDF").html("");
                $("#procesando").hide();
                $("#ModalP").modal("hide");
                $("#msgAccionDF").fadeIn();
                traedatosdiasferiados();
                var mensajeElim = "Se Eliminó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgAccionDF").html(alertMsg1); 
                $("#msgAccionDF").delay('4000').fadeOut('slow');         
        }
     });
}
            
function editar() {
    $("#errorMsg").html("");
    $("#inpaccion").val("Editar");
    var b = $("#tabla tr").length;
    var c = $("#tabla tr:last td").length;
    for (var i = 0; i < b - 1; i++) {
        $("#inpfechadia" + i).prop('readonly', false);
        $("#inpMotivo" + i).prop('readonly', false);
        $("#btnguardar").prop("disabled", false);
        $("#btneditar").prop("disabled", true);
        $("#btnagregar").prop('disabled', true);
    }
}

function guardar111() {
    $("#msgAccionDF").html("");
    var inpaccion = $("#inpaccion").val();
    if (inpaccion === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for (var i = b - 2; i < b - 1; i++) {
            var fechaDiaF = $("#inpfechadia" + i).val();
            var motivoDiaF= $("#inpMotivo" + i).val();
        }
        if (fechaDiaF == "") {
            $(document).scrollTop(0);
            $("#ModalP").modal("hide"); 
            $("#procesando").hide();
            var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Ingrese la fecha del dia Feriado: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerror);

        } else if (motivoDiaF == "") {
            $(document).scrollTop(0);
            $("#ModalP").modal("hide"); 
            $("#procesando").hide();
            var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Ingrese el motivo del día feriado: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#errorMsg").html(Msgerror);

        } else {
            $("#errorMsg").html("");
            $("#btneditar").prop("disabled", false);
            $("#btnagregar").prop('disabled', false);
            $("#btnguardar").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpfechadia" + i).prop('readonly', true);
                $("#inpMotivo" + i).prop('readonly', true);
            }
             $("#ModalP").modal("show"); 
             $("#procesando").show();
             $.ajax({
                type: "POST",
                url: 'ajax_InsertUpdateDiasFestivos.php',
                data: {
                    'fechaDiaF': fechaDiaF,
                    'motivoDiaF': motivoDiaF,
                    'accion': 2
                },
                success: function() {
                $("#msgAccionDF").html("");
                $("#procesando").hide();
                $("#ModalP").modal("hide");
                $("#msgAccionDF").fadeIn();
                traedatosdiasferiados();
                var mensajeAgregar = "Se Agregó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgAccionDF").html(alertMsg1); 
                $("#msgAccionDF").delay('4000').fadeOut('slow');    
                 
               }
            });
        }

    } else if (inpaccion === "Editar") {
        var fechaDiaF         = Array();
        var motivoDiaF        = Array();
        var fechaDiaFAnterior = Array();
        var motivoDiaFAnterior= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var fd    = $("#inpfechadia" + i).val();
           var fda   = $("#inpfechaDiaFAnterior" + i).val();
           var Mot   = $("#inpMotivo" + i).val();
           var MotAnt= $("#inpmotivoDiaFAnterior" + i).val();

            if(fd != fda || Mot != MotAnt){
                fechaDiaF[i]         = $("#inpfechadia" + i).val();
                motivoDiaF[i]        = $("#inpMotivo" + i).val();
                fechaDiaFAnterior[i] = $("#inpfechaDiaFAnterior" + i).val();
                motivoDiaFAnterior[i]= $("#inpmotivoDiaFAnterior" + i).val();
             }

            if (fechaDiaF[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Ingrese la Fecha la fila :" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerror);
                return 0;
            }

            if (motivoDiaF[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>Ingrese el motivo del dia feriado en la fila:" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#errorMsg").html(Msgerror);
                return 0;
            }
        }
    $("#ModalP").modal("show"); 
    $("#procesando").show();
            $.ajax({
            type: "POST",
            url: 'ajax_InsertUpdateDiasFestivos.php',
            data: {
                'fechaDiaF': fechaDiaF,
                'motivoDiaF': motivoDiaF,
                'fechaDiaFAnterior': fechaDiaFAnterior,
                'motivoDiaFAnterior': motivoDiaFAnterior,
                'accion': 1
            },     
            success: function() {
                $("#msgAccionDF").html("");
                $("#procesando").hide();
                $("#ModalP").modal("hide");
                $("#msgAccionDF").fadeIn();
                traedatosdiasferiados();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msgAccionDF").html(alertMsg1); 
                $("#msgAccionDF").delay('4000').fadeOut('slow');  
                    
            }
        });
    }
}

function agregarfila() {
    $("#errorMsg").html("");
    $("#btneditar").prop("disabled", true);
    var b       = $("#tabla tr").length;
    var table   = document.getElementById("tabla");
    var row     = table.insertRow(b);
    var contfila= row.insertCell(0);
    var cell1   = row.insertCell(1);
    var cell2   = row.insertCell(2);

    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpfechadia" + i + "' type='date'>";
        cell2.innerHTML = "<input id='inpMotivo" + i + "' type='text' >";;
    }
    $("#btnagregar").prop('disabled', true);
    $("#inpaccion").val("Agregar");
    $("#btnguardar").prop('disabled', false);
}