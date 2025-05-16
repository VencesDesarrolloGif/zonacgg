$(getListaHorariosAdmin());  

function getListaHorariosAdmin(){
 $("#divErrorHorariosAdmin").html("");
 $("#btnguardarHorariosAdmin").prop("disabled", true);
 $("#btnagregarHorariosAdmin").prop('disabled', false);
 $.ajax({
  type: "POST",
  url: "HorariosAdmin/ajax_ConsultarCatalogoHorarios.php",
  dataType: "json",
  success: function(response) {
   if(response.status == "success") {
       var mensaje= response.message;
       var datos  = response.datos;
       $("#divListaHorarios").empty();
       var tabla  = "<table id='tablaHorarios' class='table table-bordered'><thead> <th>No</th><th>Jornada</th><th>Hora Entrada</th><th>Hora Salida</th></thead><tbody>";
       $(document).scrollTop(0);
       $.each(datos, function(i) {
        tabla += "<tr><td><input class='form-control' id='inpidHorario" + i + "' type='text' readonly='true' value='" + datos[i].idHorarios + "'>    <input id='inpidHorarioHidden" + i + "' type='hidden' value='" + datos[i].idHorarios + "'></td>";                        
        tabla += "<td><input class='form-control' id='inpJornadaHorario" + i + "' type='text' readonly='true' value='" + datos[i].DescripcionJornada + "'>   <input id='inpJornadaHorarioHidden"   + i + "' type='hidden'  value='" + datos[i].DescripcionJornada + "'>    </td>";
        tabla += "<td><input class='form-control' id='inpEntradaHorario" + i + "' type='text' readonly='true' value='" + datos[i].HoraEntrada + "'>   <input id='inpEntradaHorarioHidden"   + i + "' type='hidden'  value='" + datos[i].HoraEntrada + "'>    </td>";
        tabla += "<td><input class='form-control' id='inpSalidaHorario" + i + "' type='text' readonly='true' value='" + datos[i].Horasalida + "'>   <input id='inpSalidaHorarioHidden"   + i + "' type='hidden'  value='" + datos[i].Horasalida + "'>    </td>";
       });                
       $("#divListaHorarios").append(tabla);
       $("#procesandoHorariosAdmin").hide();
    }else{
          var mensaje = response.message;
         }
 },
 error: function(jqXHR, textStatus, errorThrown) {
     alert(jqXHR.responseText);
      }
 });
}
function agregarHorario() {

    $.ajax({
        type: "POST",
        url: "HorariosAdmin/ajax_ConsultarCatalogojornadas.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
                var datos  = response.datos;
                $("#divErrorHorariosAdmin").html("");
                var b       = $("#tablaHorarios tr").length;
                var table   = document.getElementById("tablaHorarios");
                var row     = table.insertRow(b);
                var contfila= row.insertCell(0);
                var cell1   = row.insertCell(1);
                var cell2   = row.insertCell(2);
                var cell3   = row.insertCell(3);
                for (var i = 0; i < b; i++) {
                    contfila.innerHTML = " <td > " + (i + 1) + " </td>";


                    cell1.innerHTML = "<select id='inpJornadaHorario" + i + "' class='input-medium'></select>";
                    listaJornada = "<option value='0' selected='selected'>JORNADA</option>";
                    $.each(datos, function(i) {
                        listaJornada += "<option value='" + datos[i].idJornada + "'>" + datos[i].DescripcionJornada + "</option>"; 
                    });
                    $("#inpJornadaHorario" + i).html (listaJornada);
                    cell2.innerHTML = "<input id='inpEntradaHorario" + i + "' type='time' value='00:00:00'>";
                    cell3.innerHTML = "<input id='inpSalidaHorario" + i + "' type='time' value='00:00:00'>";                   
                }
                $("#btnagregarHorariosAdmin").prop('disabled', true);
                $("#btnguardarHorariosAdmin").prop('disabled', false);  
            }else{
                var mensaje = response.message;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}
            
function guardarHorario() {
    var b = $("#tablaHorarios tr").length;
    var c = $("#tablaHorarios tr:last td").length;
   
    for(var i = 0; i < b-1 ; i++) {
        var entradaHorario = $("#inpEntradaHorario" + i).val();
        var salidaHorario = $("#inpSalidaHorario" + i).val();
        var JornadaHorario = $("#inpJornadaHorario" + i).val();
    } 
    if(entradaHorario.length == "5"){
       entradaHorario = entradaHorario+":00"; 
    } 
    if(salidaHorario.length == "5"){
       salidaHorario = salidaHorario+":00"; 
    }
    if (JornadaHorario == "" || JornadaHorario == "0" || JornadaHorario == 0 || JornadaHorario == "JORNADA") {
        mensajeHorariosAdmin("error","Seleccione la jornada de este horario para continuar");
    }else if (entradaHorario == "") {
        mensajeHorariosAdmin("error","Ingresa la hora de entrada para continuar");
    }else if (salidaHorario == ""){
        mensajeHorariosAdmin("error","Ingresa la hora de salida para continuar");
    }else {
        $.ajax({
            type: "POST",
            url: "HorariosAdmin/ajax_InsertNuevoHorario.php",
            data: {entradaHorario,salidaHorario,JornadaHorario},
            dataType: "json",
            async: false,
            success: function(response) {
                var mensaje = response.message;
                if(response.status == "success") {
                    mensajeHorariosAdmin("success",mensaje);
                    getListaHorariosAdmin();
                }else{  
                    mensajeHorariosAdmin("error",mensaje);
                }
            },error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
}

function mensajeHorariosAdmin(tipo,mensaje){
    $('#divErrorHorariosAdmin').fadeIn();
    $(document).scrollTop(0);
    var Msgerror = "<div id='divErrorHorariosAdmin1' class='alert alert-"+tipo+"'><strong>"+mensaje+"</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#divErrorHorariosAdmin").html(Msgerror);
    $('#divErrorHorariosAdmin').delay(4000).fadeOut('slow'); 

}

    /*
    $("#divMSGTipoContrato").html("");
    var inpaccionTipoContrato = $("#inpaccionTipoContrato").val();
    var idContrato= '0';
    if (inpaccionTipoContrato === "Agregar") {
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
        
        for(var i = b - 2; i < b - 1; i++) {
            var descContrato = $("#inpDescContrato" + i).val();
           }
        if (descContrato == "") {
            $(document).scrollTop(0);
            $("#ModalTipoContrato").modal("hide"); 
            $("#procesandoHorariosAdmin").hide();
            var Msgerror = "<div id='divErrorHorariosAdmin' class='alert alert-error'><strong>Ingrese la Descripcion del contrato</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#divErrorHorariosAdmin").html(Msgerror);

        } else {
            $("#divErrorHorariosAdmin").html("");
            $("#btnagregarHorariosAdmin").prop('disabled', false);
            $("#btnguardarHorariosAdmin").prop("disabled", true);
            
            for (var i = b - 2; i < b - 1; i++) {
                $("#inpDescContrato" + i).prop('readonly', true);
            }
             $("#ModalTipoContrato").modal("show"); 
             $("#procesandoHorariosAdmin").show();
             $.ajax({
                type: "POST",
                url: 'ajax_insertUpdateTipoContratosCliente.php',
                data: {descContrato,idContrato,'accion': 2},
                success: function() {
                $("#divMSGTipoContrato").html("");
                $("#procesandoHorariosAdmin").hide();
                $("#ModalTipoContrato").modal("hide");
                $("#divMSGTipoContrato").fadeIn();
                traerCatalogoContratos();
                var mensajeAgregar = "Se Agregó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeAgregar+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGTipoContrato").html(alertMsg1); 
                $("#divMSGTipoContrato").delay('4000').fadeOut('slow');    
                 
               }
            });
        }

    } else if (inpaccionTipoContrato === "Editar") {
        var descContrato      = Array();
        var descContratohidden= Array();
        var idContrato= Array();
        var b = $("#tabla tr").length;
        var c = $("#tabla tr:last td").length;
       
        for (var i = 0; i < b - 1; i++) {
           var descContratoinp  = $("#inpDescContrato" + i).val();
           var descContratohidden = $("#inpDescContratoHidden" + i).val();

            if(descContratoinp != descContratohidden){
               descContrato[i]      = $("#inpDescContrato" + i).val();
               descContratohidden[i]= $("#inpDescContratoHidden" + i).val();
               idContrato[i]        = $("#inpidTipoC" + i).val();
               //console.log(descContrato);
             }

            if (descContrato[i] == "") {
                $(document).scrollTop(0);
                var Msgerror = "<div id='divErrorHorariosAdmin' class='alert alert-error'><strong>Ingrese la descripción del contrato en la fila :" + (i + 1) + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divErrorHorariosAdmin").html(Msgerror);
                return 0;
            }
        }
    $("#ModalTipoContrato").modal("show"); 
    $("#procesandoHorariosAdmin").show();
            $.ajax({
            type: "POST",
            url: 'ajax_insertUpdateTipoContratosCliente.php',
            data: {descContrato,idContrato,'accion': 1},     
            success: function() {
                $("#divMSGTipoContrato").html("");
                $("#procesandoHorariosAdmin").hide();
                $("#ModalTipoContrato").modal("hide");
                $("#divMSGTipoContrato").fadeIn();
                traerCatalogoContratos();
                var mensajeEdit = "Se Editó Correctamente"
                alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeEdit+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#divMSGTipoContrato").html(alertMsg1); 
                $("#divMSGTipoContrato").delay('4000').fadeOut('slow');  
            }
        });
    }
    */


