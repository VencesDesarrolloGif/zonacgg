 $(document).ready(function() {
 ConsultaHistoricotablaRevisarReporteIncidenciasCentroDeControl();
 });

 function ConsultaHistoricotablaRevisarReporteIncidenciasCentroDeControl(){ 
    tablaRevisarReporteIncidenciasCentroDeControl1 = [];
    $.ajax({
        type: "POST",
        url: "RevisionReporteIncidenciaCentroControl/ajax_ConsultaReporteIncidenciasCentroDeControlParaRevisar.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaRevisarReporteIncidenciasCentroDeControl1.push(record);
                }
                loadDataIntableRevisionReporteIncidenciaCentroControl(tablaRevisarReporteIncidenciasCentroDeControl1);
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaDetablaRevisarReporteIncidenciasCentroDeControl = null;

 function loadDataIntableRevisionReporteIncidenciaCentroControl(data) {
    if(tablaDetablaRevisarReporteIncidenciasCentroDeControl != null) {
        tablaDetablaRevisarReporteIncidenciasCentroDeControl.destroy();
    }
    tablaDetablaRevisarReporteIncidenciasCentroDeControl = $('#tablaRevisarReporteIncidenciasCentroDeControl').DataTable({
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
             "data": "idIncidencia"
         },
         {  
             "data": "DescripcionTipoIncidencia"
         }, 
         {   
             "data": "NumeroSupervisor"
         }, 
         {   
             "data": "NombreSupervisor"
         }, 
         {   
             "data": "NumeroEmpleado"
         },
         {   
             "data": "NombreEmpelado"
         },  
         {   
             "data": "EntidadFederativa"
         },
         {   
             "data": "Punto"
         },
         {   
             "data": "FechaIncidenciaCC"
         },
         {   
             "data": "Estatus"
         },
         {   
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
function abrirPdfReporteIncidenciaCC(idIncidencia,IdTablaSupervisor)
{  
    $("#modalFirmaRevisionReporteCC").modal();
    $("#constraseniaFirmaRevisionReporteCCHidden").val(idIncidencia);
    $("#NumEmpModalFirmaRevisionReporteCChidden").val(IdTablaSupervisor);
}

function RevisarFirmaInternaParaReingresoEmpleado(){
    var NumEmpModalBaja = $("#NumEmpModalFirmaRevisionReporteCC").val();
    var constraseniaFirma = $("#constraseniaFirmaRevisionReporteCC").val();
    var idIncidencia = $("#constraseniaFirmaRevisionReporteCCHidden").val();
    var IdTablaSupervisor = $("#NumEmpModalFirmaRevisionReporteCChidden").val();
    var bandera = "0";
   if(NumEmpModalBaja==""){
      cargaerroresFirmaRevisionReporteCC("El numero de empleado no puede estar vacio");
   }else if(constraseniaFirma==""){
      cargaerroresFirmaRevisionReporteCC("Escriba la contraseña para continuar");
   }else{
      $.ajax({
         type: "POST",
         url: "ConsultaEmpleado/ajax_getFirmaSolicitada.php",
         data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
         dataType: "json",
         success: function(response) {
            if (response.status == "success")
            {
               var RespuestaLargo = response["datos"].length;
               if(RespuestaLargo == "0"){
                  cargaerroresFirmaRevisionReporteCC("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
               }else{
                    var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
                    
                    $("#modalFirmaRevisionReporteCC").modal("hide");
                    $("#NumEmpModalFirmaRevisionReporteCC").val("");
                    $("#constraseniaFirmaRevisionReporteCC").val("");
                    window.open("RevisionReporteIncidenciaCentroControl/generadorpdfRevisionReporteIncidenciasCentroDeContol.php?idIncidencia="+idIncidencia+"&contraseniaInsertadaCifrada=" + contraseniaInsertadaCifrada+"&NumEmpModalBaja=" + NumEmpModalBaja+"&IdTablaSupervisor=" + IdTablaSupervisor,'_blank','fullscreen=no');
                    bandera = "1";
                }
                if(bandera=="1"){
                  ConsultaHistoricotablaRevisarReporteIncidenciasCentroDeControl(); 
                }
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
         }
      });

   }
}
function cargaerroresFirmaRevisionReporteCC(mensaje){
  $('#errormodalFirmaRevisionReporteCC').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaRevisionReporteCC1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaRevisionReporteCC").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaRevisionReporteCC').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaReingresoEmpleado(){

  $("#modalFirmaRevisionReporteCC").modal("hide");
  $("#NumEmpModalFirmaRevisionReporteCC").val("");
  $("#constraseniaFirmaRevisionReporteCC").val("");
}