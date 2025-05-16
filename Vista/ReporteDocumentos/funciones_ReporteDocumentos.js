$("#selectBusqueda").change(function(){
 var tipoBusqueda= $("#selectBusqueda").val();

    if(tipoBusqueda=='0'){
       $('#notaDoc').hide();
       $('#tablaSemaforo').hide();
       $("#tablaDocumentosTotalesEmpleados").hide();
       $("#descargarTablaReporteDoc").hide();
       $('#descargarTablaReporteDocEmpleados').hide();
       $("#tablaConteoTotalXEntidad").hide();
       $("#tablaSeleccionarEntidades").hide();
    }else if (tipoBusqueda=='1'){
        $("#tablaSeleccionarEntidades").hide();
        $('#tablaDocumentosTotalesEmpleados').hide();
        $("#descargarTablaReporteDoc").hide();
        $('#descargarTablaReporteDocEmpleados').hide();
        $('#tablaConteoTotalXEntidad').hide();
        $('#notaDoc').hide();
        $('#tablaSemaforo').hide();
    }else if (tipoBusqueda=='2'){
        ConsultarEntidadesXUsuario();
    }
});

function ConsultarEntidadesXUsuario(){

    $('#notaDoc').hide();
    $('#tablaSemaforo').hide();
    $("#tablaDocumentosTotalesEmpleados").hide();
    $("#descargarTablaReporteDoc").hide();
    $('#descargarTablaReporteDocEmpleados').hide();
    $("#tablaConteoTotalXEntidad").hide();    
    
    $.ajax({
        type: "POST",
        url: "ReporteDocumentos/ajax_consultaEntidadesXUser.php",
        dataType: "json",
        success: function(response){
            $("#tablaSeleccionarEntidades").show();
            $('#tablaSeleccionarEntidades').html("");
            $('#tablaDocumentosTotalesEmpleados').html("");
            var tablaEntidades= "<table id='tablaEntidadesAsignadas' class='table table-bordered' style='background-color:#BDEFF5'><thead><th>ENTIDAD</th><th>NOMBRE</th><th>SELECCIONAR</th></thead>";

            var totalEntidades=response.entidades.length;

            $("#totalEntidadesHidden").val(totalEntidades);

            for(var t = 0; t < totalEntidades; t++){
                var entidadesAsignadas = response.entidades;
                var idEntidad = entidadesAsignadas[t]["idEntidadFederativa"];
                var nombreEntidad = entidadesAsignadas[t]["nombreEntidadFederativa"];

                tablaEntidades+="<tr><td>"+idEntidad+"</td><td>"+nombreEntidad+"</td><td><input type='checkbox' style='width: 25px; height: 25px' id=checkEntidad"+t+"  name=checkEntidad"+t+" value='"+idEntidad+"'></td></tr>";
            }//for t
                tablaEntidades+="</table>";

            $("#tablaSeleccionarEntidades").append(tablaEntidades);
        },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
    });

}

$("#btnConsultarDocumentosEmpleados").click(function(){

    waitingDialog.show();
    var tipoDeBusqueda = $("#selectBusqueda").val();

    if(tipoDeBusqueda==2){
      var largoEntidades = $("#totalEntidadesHidden").val();
      var entidadesSeleccionadas = [];

      for(var w = 0; w < largoEntidades; w++){
        if($('#checkEntidad'+w+'').is(":checked")){
            var entidadesSel= $('#checkEntidad'+w+'').val();
             entidadesSeleccionadas.push(entidadesSel);
        }
      }
    if(entidadesSeleccionadas.length=='' || entidadesSeleccionadas.length=='0' || entidadesSeleccionadas.length==null || entidadesSeleccionadas.length=="NULL" || entidadesSeleccionadas.length=='null'){
       waitingDialog.hide();
       alert("Seleccione entidades a consultar");
       return;
      }
    }else{
        var entidadesSeleccionadas = 1;//esto solo es para igualar los campos que se mandan al ajax
    }

    $('#notaDoc').hide();
    $('#tablaSemaforo').hide();
    var FechaInicioConsultaDoc = $("#FechaInicioConsultaDoc").val();
    var FechaFinConsultaDoc    = $("#FechaFinConsultaDoc").val();

    if(FechaInicioConsultaDoc==""){
        waitingDialog.hide();
        mensajeerrorDocumentosEmpleados("ingrese Una Fecha De Inicio");
    }else if(FechaFinConsultaDoc==""){
        waitingDialog.hide();
        mensajeerrorDocumentosEmpleados("ingrese Una Fecha De Termino");
    }else if(FechaInicioConsultaDoc>FechaFinConsultaDoc){
        waitingDialog.hide();
        mensajeerrorDocumentosEmpleados("La Fecha De Inicio NO Puede Ser Mayor A La Fecha De Termino");
    }else if(tipoDeBusqueda=='0'){
        waitingDialog.hide();
        mensajeerrorDocumentosEmpleados("Seleccione un tipo de busqueda");
    }else{
        
        $.ajax({
            type: "POST",
            url: "ReporteDocumentos/ajax_ReporteDocumentacionXEmp.php",
            data:{"FechaInicioConsultaDoc":FechaInicioConsultaDoc,"FechaFinConsultaDoc":FechaFinConsultaDoc,"tipoDeBusqueda":tipoDeBusqueda,"entidadesSeleccionadas":entidadesSeleccionadas},
            dataType: "json",
            success: function(response) {
                if(response.status == "success"){
                  waitingDialog.hide();
                  $('#tablaSemaforo').show();
                  $('#notaDoc').show();
                  $('#tablaDocumentosTotalesEmpleados').show();
                  $('#tablaConteoTotalXEntidad').show();
                  $('#tablaDocumentosTotalesEmpleados').html("");
                  $('#tablaConteoTotalXEntidad').html("");
                  var documentosTotalesEmpleados = response.nombreDocumentos;
                  var tablaContDoc= "<table id='tablaConteoDoc' class='table table-bordered' style='background-color:#BDEFF5'><thead><th>ENTIDAD</th><th>EMPLEADOS</th>";
                  var tablaDocEmp = "<table id='tablaDocEmp' class='table table-bordered' style='background-color:#D2B4DE'><thead><th>NO. EMPLEADO</th><th>NOMBRE</th><th>ESTATUS</th>";
                  
                  for(var i = 0; i < documentosTotalesEmpleados.length; i++){
                      tablaContDoc+= "<th>" + documentosTotalesEmpleados[i].nombreDocumento + "</th>"; //roles de sus respectivas tablas
                      tablaDocEmp += "<th>" + documentosTotalesEmpleados[i].nombreDocumento + "</th>"; //roles de sus respectivas tablas
                  }

                  tablaContDoc += "</thead>";// termina titulo
                  tablaDocEmp  += "<th>NO. ADMINISTRATIVO</th><th>NOMBRE ADMINISTRATIVO</th></thead>";// termina titulo

                  for(var l = 0; l < response.entidades.length; l++){

                      var nombreEF = response.entidades[l]["nombreEntidadFederativa"];
                      var totalEmp = response.entidades[l]["empleadosCount"];
                      tablaContDoc+="<tr><td>"+nombreEF+"</td><td>"+totalEmp+"</td>";
                   
                      for(var m = 0; m < documentosTotalesEmpleados.length; m++){
                          var idDocumento = response.nombreDocumentos[m].idDocumento;
                          var conteoDocumento = response.entidades[l][idDocumento];
                          tablaContDoc += "<td>"+conteoDocumento+"</td>";
                      }//for m 
                      tablaContDoc += "</tr>";
                  }//for l
                      tablaContDoc += "</table>";

                  for(var j = 0; j < response.datosEmpleado.length; j++){
                      var noEmp = response.datosEmpleado[j]["noemp"];
                      var nombreEmp = response.datosEmpleado[j]["NombreEmpleado"];
                      var estatusEmp = response.datosEmpleado[j]["EstatusEmpleado"];
                      var noContratante = response.datosEmpleado[j]["noContratante"];
                      var nombreContratante = response.datosEmpleado[j]["nombreContratante"];
                      tablaDocEmp+="<tr><td>"+noEmp+"</td><td>"+nombreEmp+"</td><td>"+estatusEmp+"</td>";
                   
                      for(var k = 0; k < documentosTotalesEmpleados.length; k++){

                        var documento      = documentosTotalesEmpleados[k]["nombreDocumento"];
                        var tipoDocumento  = response.datosEmpleado[j][documento];
                        var statusDocumento= response.datosEmpleado[j]["status"+documento+""];

                        if(statusDocumento==0) {
                            tablaDocEmp += "<td style='background-color:#8CF895'>"+tipoDocumento+"</td>";//empresa verde
                        }else if(statusDocumento=='1') {
                            tablaDocEmp += "<td style='background-color:#F5F88C'>"+tipoDocumento+"</td>";//prestado amarillo
                        }else if(statusDocumento=='2') {
                            tablaDocEmp += "<td style='background-color:#F88C8C'>"+tipoDocumento+"</td>";//entregado rojo
                        }else{
                              tablaDocEmp += "<td style='background-color:#8CEDF8'>"+tipoDocumento+"</td>";
                        }
                      }//for k 
                      tablaDocEmp += "<td>"+noContratante+"</td><td>"+nombreContratante+"</td></tr>";
                  }//for j

                  tablaDocEmp += "</table>";

                  $("#tablaDocumentosTotalesEmpleados").append(tablaDocEmp);
                  $("#tablaConteoTotalXEntidad").append(tablaContDoc);
                  $("#descargarTablaReporteDoc").show();
                  $("#descargarTablaReporteDocEmpleados").show();

                }else{
                    waitingDialog.hide();
                    $('#tablaSemaforo').hide();
                    $('#notaDoc').hide();
                    var mensaje = "ERROR AL CARGAR LA TABLA";
                    mensajeerrorDocumentosEmpleados(mensaje);
                    $("#tablaDocumentosTotalesEmpleados").hide();
                    $("#descargarTablaReporteDoc").hide();
                    $('#descargarTablaReporteDocEmpleados').hide();
                    $("#tablaConteoTotalXEntidad").hide();
                 }
                 waitingDialog.hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
                waitingDialog.hide();
            }
        });
    }
 });
 
function mensajeerrorDocumentosEmpleados(mensaje){
    $("#mensajeerrorDocumentosEmpleados").fadeIn();
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#mensajeerrorDocumentosEmpleados").html(alertMsg1); 
    $("#mensajeerrorDocumentosEmpleados").delay('3000').fadeOut('slow');
    $("#tablaDocumentosTotalesEmpleados").hide();
    $("#tablaDocumentosTotalesEmpleados").html("");
    $("#tablaConteoTotalXEntidad").hide();
    $("#tablaConteoTotalXEntidad").html("");
    $("#descargarTablaReporteDoc").hide();
    $('#descargarTablaReporteDocEmpleados').hide();
}

function btnAbrirDocEmpaaaaa(ruta){

    $.ajax({
        url:'uploads/documentosdigitalizados/'+ruta+'',
        type:'HEAD',
        error: function()
        {
          swal("ERROR", "NO SE ENCUENTRA DISPONIBLE EL DOCUMENTO SELECCIONADO", "error");
        },
        success: function()
        {
            window.open("uploads/documentosdigitalizados/"+ruta+"");
        }
    });
}

$("#descargarTablaReporteDoc").click(function(event) {
  $("#datosConteoTotal").val( $("<div>").append( $("#tablaConteoDoc").eq(0).clone()).html());
  $("#form_TablaConteoXEntidad").submit();
});

$("#descargarTablaReporteDocEmpleados").click(function(event){
  $("#datosDocEmp").val( $("<div>").append( $("#tablaDocEmp").eq(0).clone()).html());
  $("#form_TablaDocumentosEmp").submit();
});