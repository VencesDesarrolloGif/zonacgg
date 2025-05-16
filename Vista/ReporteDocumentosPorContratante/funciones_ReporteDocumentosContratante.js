$("#btnConsultarDocumentosEmpleadosCont").click(function(){
    waitingDialog.show();
    var FechaInicioConsultaDocCont = $("#FechaInicioConsultaDocCont").val();
    var FechaFinConsultaDocCont    = $("#FechaFinConsultaDocCont").val();

    if(FechaInicioConsultaDocCont==""){
        waitingDialog.hide();
        mensajeerrorDocumentosXAdministrativo("ingrese Una Fecha De Inicio");
    }else if(FechaFinConsultaDocCont==""){
        waitingDialog.hide();
        mensajeerrorDocumentosXAdministrativo("ingrese Una Fecha De Termino");
    }else if(FechaInicioConsultaDocCont>FechaFinConsultaDocCont){
        waitingDialog.hide();
        mensajeerrorDocumentosXAdministrativo("La Fecha De Inicio NO Puede Ser Mayor A La Fecha De Termino");
    }else{
        $.ajax({
            type: "POST",
            url: "ReporteDocumentosPorContratante/ajax_ReporteDocumentacionXContratante.php",
            data:{"FechaInicioConsultaDocCont":FechaInicioConsultaDocCont,"FechaFinConsultaDocCont":FechaFinConsultaDocCont},
            dataType: "json",
            async:false, 
            success: function(response) {
                if(response.status == "success"){
                  waitingDialog.hide();
                  $('#tablaContratantesDoc').html("");
                  $("#descargaTablaDetalleDePendientesAdminitrativos").hide();
                  // console.log(response);

                  var documento  = response.catalogoDoc;
                  var contratanteAltas= response.contratantesAltas;
                  var contratanteBajas= response.contratantesBajas;

                  //creacion encabezados de las tablas
                  var tablaContratantes="<table id='tablaConteoContratantes' class='table table-bordered'><thead style='background-color:#BDEFF5'><th>No. Empleado</th><th>Nombre</th><th>Estatus Administrativo</th><th>Entidad de Trabajo</th><th>Estatus Elementos</th><th>Elementos Contratados</th>";

                  for(var i = 0; i < documento.length; i++){
                      tablaContratantes+= "<th>" + documento[i].nombreDocumento + "</th>"; //roles de sus respectivas tablas
                  }

                  tablaContratantes += "</thead>";// termina titulo

                  for(var j = 0; j < contratanteAltas.length; j++){

                      var numeroC    = contratanteAltas[j]["NumEmpleadoFirmaAltaEMp"];
                      var nombreC    = contratanteAltas[j]["nombreContratante"];
                      var statusAdmin= contratanteAltas[j]["descripcionEstatusEmpleado"];
                      var entidadC   = contratanteAltas[j]["nombreEntidadFederativa"];
                      var statusEmp  = "ACTIVOS";
                      var empContratados= contratanteAltas[j]["contratados"];

                      tablaContratantes+="<tr style='background-color:#AFFCA8'><td>"+numeroC+"</td><td>"+nombreC+"</td><td>"+statusAdmin+"</td><td>"+entidadC+"</td><td>"+statusEmp+"</td><td>"+empContratados+"</td>";
                   
                      for(var k = 0; k < documento.length; k++){
                          var nombreDocumentoAlta = documento[k].nombreDocumento;
                          var conteoDocumento = contratanteAltas[j][nombreDocumentoAlta];
                          tablaContratantes  += "<td>"+conteoDocumento+"</td>";
                      }//for k 

                      tablaContratantes += "</tr>";

                      var numeroCBaja    = contratanteBajas[j]["NumEmpleadoFirmaAltaEMp"];
                      var nombreCBaja    = contratanteBajas[j]["nombreContratante"];
                      var statusAdminBaja= contratanteBajas[j]["descripcionEstatusEmpleado"];
                      var entidadCBaja   = contratanteBajas[j]["nombreEntidadFederativa"];
                      var statusEmpBaja  = "BAJA";
                      var empContratadosBaja= contratanteBajas[j]["contratados"];

                      tablaContratantes+="<tr style='background-color:#FCA8A8'><td>"+numeroCBaja+"</td><td>"+nombreCBaja+"</td><td>"+statusAdminBaja+"</td><td>"+entidadCBaja+"</td><td>"+statusEmpBaja+"</td><td>"+empContratadosBaja+"</td>";

                      for(var l = 0; l < documento.length; l++){
                          var nombreDocumentoBaja    = documento[l].nombreDocumento;
                          var conteoDocumentoBaja= contratanteBajas[j][nombreDocumentoBaja];
                          tablaContratantes += "<td>"+conteoDocumentoBaja+"</td>";
                      }//for l 

                      tablaContratantes += "</tr>";
                  }//for j
                      tablaContratantes += "</table>";

                  $("#tablaContratantesDoc").append(tablaContratantes);
                  $("#descargaTablaDetalleDePendientesAdminitrativos").show();
                }else{
                    $("#tablaContratantesDoc").hide();
                    $("#descargaTablaDetalleDePendientesAdminitrativos").hide();
                    waitingDialog.hide();
                    var mensaje = "ERROR AL CARGAR LA TABLA";
                    mensajeerrorDocumentosXAdministrativo(mensaje);
                 }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
                waitingDialog.hide();
            }
        });
    }
 });
 
function mensajeerrorDocumentosXAdministrativo(mensaje){
    $("#mensajeerrorDocumentosXAdministrativos").fadeIn();
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#mensajeerrorDocumentosXAdministrativos").html(alertMsg1); 
    $("#mensajeerrorDocumentosXAdministrativos").delay('3000').fadeOut('slow');
    $("#tablaContratantesDoc").hide();
    $("#tablaContratantesDoc").html("");
    $("#descargaTablaDetalleDePendientesAdminitrativos").hide();
}

$("#descargaTablaDetalleDePendientesAdminitrativos").click(function(event) {
  $("#datos_TablaDetalleDePendientesAdminitrativoshidden").val( $("<div>").append( $("#tablaContratantesDoc").eq(0).clone()).html());
  $("#form_tablasDinamicaDetallePendienteAdmin").submit();
});
