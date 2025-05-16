 function ConsultaHistoricoPeticionesCapacitacion(){  
    waitingDialog.show();
    historicotablaPeticiones = [];
    $.ajax({
        type: "POST",
        url: "HistoricopeticionesTurnoCapacitacion/ajax_ConsultaHistoricoTurnosCapacitacion.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    historicotablaPeticiones.push(record);
                }
                loadDataIntableHistoricoPeticionesTurnos(historicotablaPeticiones);
                $("#tablaPeticionesTurnosCapacitacionHis").show();
                waitingDialog.hide();
            }else{
                var mensaje = response.message;
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
     });
 }
 var tablaDePeticionesCapacitacionHistorico = null;

 function loadDataIntableHistoricoPeticionesTurnos(data) {
    if(tablaDePeticionesCapacitacionHistorico != null) {
        tablaDePeticionesCapacitacionHistorico.destroy();
    }
    tablaDePeticionesCapacitacionHistorico = $('#tablaPeticionesTurnosCapacitacionHis').DataTable({
     "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true,
         "columns": [
         {  
             "data": "numeroEmpleado"
         }, 
         {   
             "data": "nombreEmpleado"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         }, 
         {   
             "data": "puntoServicio"
         }, 
         {   "className": "dt-body-right",
             "data": "descripcionPuesto"
         },
         {   
             "data": "numeroSupervisor"
         },  
         {   "className": "dt-body-center",
             "data": "nombresupervisor"
         },
         {   "className": "dt-body-center",
             "data": "fechaTurnoCap"
         },
         {   "className": "dt-body-center",
             "data": "comentarioAccion"
         },
         {   "className": "dt-body-center",
             "data": "fechaAccion"
         },
         {   "className": "dt-body-center",
             "data": "usuarioCapturaPeticion"
         },
         {   "className": "dt-body-center",
             "data": "accion"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 

 function rechazarPeticion(idPeticionTurno,accion){
    $("#ComentarioRechazoPet").val("");
    $("#BanderaIdPeticion").val(idPeticionTurno);
    $("#BanderaAccion").val(accion);
    $("#modalRechazarPeticionTurno").modal();
 }

function Registrarsistencia(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,supervisorEntidadId,supervisorConsecutivoId,supervisorTipoId,
    incidenciaId,asistenciaFecha,comentariIncidencia1,tipoPeriodo,puestoCubiertoId,idCliente,valordia,plantilladeservicio1,idlineanegocioPunto,idpeticion,accion){
    var comentariIncidencia = comentariIncidencia1.replace("$"," ");
    var plantilladeservicio = plantilladeservicio1.replace("$"," ");
    waitingDialog.show();
    $.ajax ({            
        type: "POST",
        url: "ajax_registrarAsistencia.php",
        data: {"empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId": empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId, "empleadoPuntoServicioId": empleadoPuntoServicioId, "supervisorEntidadId":supervisorEntidadId, "supervisorConsecutivoId": supervisorConsecutivoId, "supervisorTipoId":supervisorTipoId, "incidenciaId":incidenciaId, "asistenciaFecha":asistenciaFecha, "comentariIncidencia":comentariIncidencia, "tipoPeriodo":tipoPeriodo, "puestoCubiertoId":puestoCubiertoId, "idCliente":idCliente, "valordia": valordia,"plantilladeservicio":plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto},
        dataType: "json",
        success: function (response){
            if (response.status == "error"){                        
                var mensaje=response.message;                                
                CargarMensajePeticionCapa(mensaje,"error");
                waitingDialog.hide();
            }else if(response.status=="errorRegistro"){                                
                CargarMensajePeticionCapa(response.message,"error");
                waitingDialog.hide();
            }else if(response.status=="errorCobertura"){
                var mensaje=response.message;
                CargarMensajePeticionCapa(mensaje,"error");
                waitingDialog.hide();
            }else
            {
                var comentariogrl = "Peticion De Capacitacion Aceptada";
                ActualizarPeticionAceptada(idpeticion,accion,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,incidenciaId,asistenciaFecha,comentariogrl);                            
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
    });
    
    
 }

 function ActualizarPeticionAceptada(idpeticion,accion,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,incidenciaId,asistenciaFecha,comentariogrl){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "PeticionesTurnoCapacitacion/ajax_ActualizarPeticion.php",
        data:{"idpeticion":idpeticion,"accion":accion,"empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId": empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId,"incidenciaId":incidenciaId, "asistenciaFecha":asistenciaFecha,"comentariogrl":comentariogrl},
        dataType: "json",
        success: function(response) {
            if(response.status == "success"){
                ConsultaPeticionesCapacitacion();
               var mensaje = response.message;
               CargarMensajePeticionCapa(mensaje,response.status);
                waitingDialog.hide();
             }
        },
        error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
    });

 }

 function CargarMensajePeticionCapa(mensaje,Tipo){
  $('#MensajePeticionCapacitacion1').fadeIn();
  msjerrorbaja="<div id='MensajePeticionCapacitacion1' class='alert alert-"+Tipo+"'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#MensajePeticionCapacitacion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#MensajePeticionCapacitacion1').delay(4000).fadeOut('slow'); 
}  

 function CargarErrorModalRechazo(mensaje){
  $('#errorModalRechazarPeticion1').fadeIn();
  msjerrorbaja="<div id='errorModalRechazarPeticion1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalRechazarPeticion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalRechazarPeticion1').delay(4000).fadeOut('slow'); 
}  

 function ProcesarRechazoDePeticionCap(mensaje){
    var comentariogrl =$("#ComentarioRechazoPet").val();
    var idpeticion    = $("#BanderaIdPeticion").val();
    var accion        = $("#BanderaAccion").val();
    var empleadoEntidadId = "";
    var empleadoConsecutivoId = "";
    var empleadoTipoId = "";
    var incidenciaId = "";
    var asistenciaFecha = "";

    if(comentariogrl == ""){
        CargarErrorModalRechazo("Indique el motivo por el cual se esta rechazando la petición de capacitación");
    }else{
        ActualizarPeticionAceptada(idpeticion,accion,empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,incidenciaId,asistenciaFecha,comentariogrl);
        $("#modalRechazarPeticionTurno").modal('hide');
    }

  
}  