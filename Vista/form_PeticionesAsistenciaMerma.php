<div id='msmPeticionesMerma' name='msmPeticionesMerma' ></div> 
<center><h3>ASISTENCIAS PARA MERMA</h3>
<br>
<img width="50px" title='Obtner las peticiones merma actuales' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='consultaPeticionesAsistenciaMerma();'>
</center>
<br><br>
<section>
    <table id="tablaPeticionesMerma"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Incidencia</th>
                <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>       
                <th style="text-align: center;background-color: #B0E76E">Plantilla Servicio</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Periodo</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Puesto</th> 
                <th style="text-align: center;background-color: #B0E76E">Linea Negocio</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha De Asistencia</th> 
                <th style="text-align: center;background-color: #B0E76E">Tipo De turno</th> 
                <th style="text-align: center;background-color: #B0E76E">Número Supervisor</th> 
                <th style="text-align: center;background-color: #B0E76E">Nombre Supervisor</th> 
                <th style="text-align: center;background-color: #B0E76E">Comentario</th> 
                <th style="text-align: center;background-color: #B0E76E">Usuario Petición</th> 
                <th style="text-align: center;background-color: #B0E76E">Fecha Petición</th> 
                <th style="text-align: center;background-color: #B0E76E">Aceptar</th> 
                <th style="text-align: center;background-color: #B0E76E">Declinar</th> 
            </tr>
        </thead>
   </table>
</section>

<div class="modal fade" tabindex="-1" role="dialog" name="modalDeclinePeticionMerma" id="modalDeclinePeticionMerma" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="img/alert.png">Ingrese EL Motivo Por EL Que Esta Declinando La Petición</h4>
          </div>
          <div class="modal-body">
            <textarea type="text"  align="center" id="inpMotivoDeclinePeticion" name="inpMotivoDeclinePeticion">></textarea> 
            <input type="hidden" id="EmpEntidadMHIdden" name="EmpEntidadMHIdden">
            <input type="hidden" id="EmpConsecutivoMHIdden" name="EmpConsecutivoMHIdden">
            <input type="hidden" id="EmpCategoriaMHIdden" name="EmpCategoriaMHIdden">
            <input type="hidden" id="idPuntoServicioMHIdden" name="idPuntoServicioMHIdden">
            <input type="hidden" id="idIncidenciaMHIdden" name="idIncidenciaMHIdden">
            <input type="hidden" id="FechaDelRegistroHIdden" name="FechaDelRegistroHIdden">
            <input type="hidden" id="OpcionHIdden" name="OpcionHIdden">
          </div>
          <div class="modal-footer">
            <button id="btnGuardarPeticionDenegada" name="btnGuardarPeticionDenegada" type="button" class="btn btn-primary" style="margin-left: -20%;" >Guardar</button> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 


<script type="text/javascript"> //empieza lo de js

// $(inicioPetAsisMerma());  

// function inicioPetAsisMerma(){
//      consultaPeticionesAsistenciaMerma();
// }

 function consultaPeticionesAsistenciaMerma() { 
    waitingDialog.show();
    var fechaInicioPeriodo = "";
    var fechaTerminoPeriodo = "";
    var caso = "0";
    tablaPeticonesAsisMerma = [];
    $.ajax({
        type: "POST",
        url: "ajax_consultaPeticionesAsistenciaParaMerma.php",
        data: {"fechaInicioPeriodo":fechaInicioPeriodo,"fechaTerminoPeriodo":fechaTerminoPeriodo,"caso":caso},
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaPeticonesAsisMerma.push(record);
                 }
                 loadDataIntableConfirmacionPeticionMer(tablaPeticonesAsisMerma);
                 $("#tablaPeticionesMerma").show();
                 waitingDialog.hide();
             } else {
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

 var tablaConfirmacionPeticionMerma = null;

 function loadDataIntableConfirmacionPeticionMer(data) {
     if (tablaConfirmacionPeticionMerma != null) {
         tablaConfirmacionPeticionMerma.destroy();
     }
     tablaConfirmacionPeticionMerma = $('#tablaPeticionesMerma').DataTable({
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
             "data": "idEmpleado"
         },
         {  
             "data": "NombreEmpleado"
         },
         {  
             "data": "IncidenciaFinal"
         },
         {  
             "data": "PuntoServicio"
         },
         {  
             "data": "idPlantillaServicioM"
         }, 
         {  
             "data": "tipoPeriodo"
         },
         {  
             "data": "TipoPuesto"
         },
         {  
             "data": "LineaNegocio"
         },
         {  
             "data": "FechaDelRegistro"
         },
         {  
             "data": "tipoIncidenciaPeticionM"
         },
         {  
             "data": "idSupervisor"
         },
         {  
             "data": "NombreSupervisor"
         },
         {  
             "data": "Comentario"
         },
         {  
             "data": "UsuarioSolicitud"
         },
         {  
             "data": "FechaPeticion"
         },
         {  
             "data": "Aceptar"
         },
         {  
             "data": "Declinar"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }

 function ConfirmarPeticion(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,supervisorEntidadId,supervisorConsecutivoId,supervisorTipoId,incidenciaId,asistenciaFecha,comentariIncidencia1,tipoPeriodo,puestoCubiertoId,idCliente,valordia,plantilladeservicio1,idlineanegocioPunto,tipoIncidenciaPeticionM,idPlantillaServicio){

    var comentarioExplode =comentariIncidencia1.split("$");
    var largocomentario = comentarioExplode.length;
    var comentariIncidencia ="";
        for(var j=0; j<largocomentario;j++){
            if(j==0){
                comentariIncidencia= comentarioExplode[j];
            }else{
                comentariIncidencia = comentariIncidencia+" "+comentarioExplode[j];             
            }
        }
        var plantilladeservicio = plantilladeservicio1.replace("$"," ");
        alert(plantilladeservicio);

        var opcion = 1;
        if(tipoIncidenciaPeticionM=="Incidencia_Especial"){
            $.ajax ({
                type: "POST",
                url: "ajax_registrarIncidenciaEspecial.php",
                data: {empleadoEntidadId:empleadoEntidadId, empleadoConsecutivoId: empleadoConsecutivoId, empleadoTipoId:empleadoTipoId, empleadoPuntoServicioId: empleadoPuntoServicioId, supervisorEntidadId:supervisorEntidadId, supervisorConsecutivoId: supervisorConsecutivoId, supervisorTipoId, supervisorTipoId, incidenciaId:incidenciaId, asistenciaFecha:asistenciaFecha, comentariIncidencia:comentariIncidencia, tipoPeriodo:tipoPeriodo, incidenciaPuesto:puestoCubiertoId, idCliente:idCliente, selplantillaservicioincidencia:plantilladeservicio,lineanegocioincidenciaespecial:idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
                dataType: "json",
                success: function (response){
                  var mensaje=response.message;

                    if (response.status=="success") {
                        ActualizarEstatusPeticionMerma1(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,incidenciaId,asistenciaFecha,comentariIncidencia,opcion);
                    } else if (response.status=="error")
                    {
                        alert(mensaje);
                    }else if(response.status=="errorCobertura"){
                        var mensaje=response.message;
                        alert(mensaje);
                    }else if(response.status=="error2"){
                        alert(mensaje);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }else{
          $.ajax ({             
          type: "POST",
          url: "ajax_registrarAsistencia.php",
          data: {"empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId": empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId,"empleadoPuntoServicioId": empleadoPuntoServicioId, "supervisorEntidadId":supervisorEntidadId, "supervisorConsecutivoId": supervisorConsecutivoId, "supervisorTipoId":supervisorTipoId, "incidenciaId":incidenciaId, "asistenciaFecha":asistenciaFecha, "comentariIncidencia":comentariIncidencia, "tipoPeriodo":tipoPeriodo, "puestoCubiertoId":puestoCubiertoId, "idCliente":idCliente, "valordia": valordia,"plantilladeservicio":plantilladeservicio,"idlineanegocioPunto":idlineanegocioPunto,"idPlantillaServicio":idPlantillaServicio},
          dataType: "json",
          success: function (response) {
            if (response.status == "error")
            {
              var mensaje=response.message;                    
             alert(mensaje);
            }else if(response.status=="errorRegistro"){                    
              alert (response.message);
            }else if(response.status=="errorCobertura"){
              var mensaje=response.message;
              var puestosCobertura=response.puestosCobertura;                  
              alert(mensaje + " " + "El puesto del empleado no coincide con el puesto solicitado por el cliente, Por favor verifique, Puestos solicitados:"+ puestosCobertura);
            }else
            {
                ActualizarEstatusPeticionMerma1(empleadoEntidadId,empleadoConsecutivoId,empleadoTipoId,empleadoPuntoServicioId,incidenciaId,asistenciaFecha,comentariIncidencia,opcion);
            }
          },
          error: function (response) {                
            valordia=0;
            alert (response.responseText);
          }
        });
        $("#myModalAsistencia").modal("hide");   
        }
        
} 
  function DeclinarPeticion(EmpEntidadM,EmpConsecutivoM,EmpCategoriaM,idPuntoServicioM,idIncidenciaM,FechaDelRegistro,Opcion){ 

    $("#inpMotivoDeclinePeticion").val("");
    $("#EmpEntidadMHIdden").val(EmpEntidadM);
    $("#EmpConsecutivoMHIdden").val(EmpConsecutivoM);
    $("#EmpCategoriaMHIdden").val(EmpCategoriaM);
    $("#idPuntoServicioMHIdden").val(idPuntoServicioM);
    $("#idIncidenciaMHIdden").val(idIncidenciaM);
    $("#FechaDelRegistroHIdden").val(FechaDelRegistro);
    $("#OpcionHIdden").val(Opcion);
    $("#modalDeclinePeticionMerma").modal();
  
}
$("#btnGuardarPeticionDenegada").click(function(){
    var MotivoDeclinePeticion = $("#inpMotivoDeclinePeticion").val();

    if(MotivoDeclinePeticion ==""){
        alert("Ingresa EL Motivo Por EL Cual Se Esta Declinando La Petición Para Continuar");
    }else{
        var EmpEntidadM = $("#EmpEntidadMHIdden").val();
        var EmpConsecutivoM = $("#EmpConsecutivoMHIdden").val();
        var EmpCategoriaM = $("#EmpCategoriaMHIdden").val();
        var idPuntoServicioM = $("#idPuntoServicioMHIdden").val();
        var idIncidenciaM = $("#idIncidenciaMHIdden").val();
        var FechaDelRegistro = $("#FechaDelRegistroHIdden").val();
        var Comentario = MotivoDeclinePeticion;
        var Opcion = $("#OpcionHIdden").val();
        ActualizarEstatusPeticionMerma1(EmpEntidadM,EmpConsecutivoM,EmpCategoriaM,idPuntoServicioM,idIncidenciaM,FechaDelRegistro,Comentario,Opcion)

    }
 });

function ActualizarEstatusPeticionMerma1(EmpEntidadM,EmpConsecutivoM,EmpCategoriaM,idPuntoServicioM,idIncidenciaM,FechaDelRegistro,Comentario,Opcion){

     $.ajax({
        type: "POST",
        url: "ajax_ActualizarEstatusPeticionMerma.php",
        data:{"EmpEntidadM":EmpEntidadM,"EmpConsecutivoM":EmpConsecutivoM,"EmpCategoriaM":EmpCategoriaM,"idPuntoServicioM":idPuntoServicioM,"idIncidenciaM":idIncidenciaM,"FechaDelRegistro":FechaDelRegistro,"Comentario":Comentario,"Opcion":Opcion},
        dataType: "json",
        success: function(response) {
            if(Opcion=="1"){
                var mensajeC = "Asistencia Agregada Correctamente";
            }else{
                $("#modalDeclinePeticionMerma").modal("hide");
                var mensajeC = "Asistencia Declinada Correctamente";
            }
              $('#msmPeticionesMerma').fadeIn('slow');
            alerterror="<div class='alert alert-success' id='msmPeticionesMerma'>"+mensajeC+"<data-dismiss='alert'>";
            $("#msmPeticionesMerma").html(alerterror);
            $('#msmPeticionesMerma').delay(3000).fadeOut('slow');
            consultaPeticionesAsistenciaMerma();

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      }); 

}


 </script>