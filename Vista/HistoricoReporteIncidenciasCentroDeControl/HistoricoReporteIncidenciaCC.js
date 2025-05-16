 $(document).ready(function() {
 ConsultaHistoricotablaReporteIncidenciasCentroDeControl();
 });

function ConsultaHistoricotablaReporteIncidenciasCentroDeControl(){ 
    historicotablaReporteIncidenciasCentroDeControl = [];
    $.ajax({
        type: "POST",
        url: "HistoricoReporteIncidenciasCentroDeControl/ajax_ConsultaReporteIncidenciasCentroDeControl.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    historicotablaReporteIncidenciasCentroDeControl.push(record);
                }
                loadDataIntableHistoricoPeticionesTurnos(historicotablaReporteIncidenciasCentroDeControl);
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaDetablaReporteIncidenciasCentroDeControl = null;

 function loadDataIntableHistoricoPeticionesTurnos(data) {
    if(tablaDetablaReporteIncidenciasCentroDeControl != null) {
        tablaDetablaReporteIncidenciasCentroDeControl.destroy();
    }
    tablaDetablaReporteIncidenciasCentroDeControl = $('#tablaReporteIncidenciasCentroDeControl').DataTable({
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
             "data": "descripcionEsp"
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
             "data": "FechaOriginal"
         },
         {   
             "data": "NumAdiminFirma"
         },
         {   
             "data": "FechaEdicion"
         },
         {   
             "data": "Estatus"
         },
         {   
             "data": "accion"
         },
         {   
             "data": "Edit"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
            buttons: ['excel',{orientation:'landscape',extend:'pdf',pageSize:'LEGAL',title: 'HISTORICO REPORTE DE INCIDENCIAS'}]

        });
 } 
function abrirPdfReporteIncidenciaCC11(idIncidencia)
{  
    window.open("HistoricoReporteIncidenciasCentroDeControl/generadorpdfReporteIncidenciasCentroDeContol.php?idIncidencia="+idIncidencia+"",'_blank','fullscreen=yes');
}

function MostrarEstatusSupervisoresParaCC(idIncidencia)
{  
    tablaEstatusSupervisorCC1 = [];
    $.ajax({
        type: "POST",
        url: "HistoricoReporteIncidenciasCentroDeControl/ajax_ConsultaEstatusSupervisoresCentroDeControl.php",
        data:{"idIncidencia":idIncidencia},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaEstatusSupervisorCC1.push(record);
                }
                loadDataIntablaEstatusSupervisorCC(tablaEstatusSupervisorCC1);
                $("#modalestatusdocumentosupervisor").modal();
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
}
var tablaDetablatablaEstatusSupervisorCC = null;

 function loadDataIntablaEstatusSupervisorCC(data) {
    if(tablaDetablatablaEstatusSupervisorCC != null) {
        tablaDetablatablaEstatusSupervisorCC.destroy();
    }
    tablaDetablatablaEstatusSupervisorCC = $('#tablaEstatusSupervisorCC').DataTable({
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
             "data": "NumeroSupervisor"
         },
         {  
             "data": "NombreSupervisor"
         }, 
         {   
             "data": "FechaRevision"
         }, 
         {   
             "data": "Estatus"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 }
function ResetearInformacionInicial(idIncidencia){
    $("#IdIncidenciaEdit").val(idIncidencia);
    $("#agregarTestigoEdit").show();
    $("#eliminarTestigoEdit").hide();
    $("#caracteresTEdit2").hide();
    $("#txtAreaTestigosEdit2").hide();
    $("#txtAreaTestigosEdit2").val("");
    $("#caracteresTEdit3").hide();
    $("#txtAreaTestigosEdit3").hide();
    $("#txtAreaTestigosEdit3").val("");
    $("#caracteresTEdit4").hide();
    $("#txtAreaTestigosEdit4").hide();
    $("#txtAreaTestigosEdit4").val("");
    $("#caracteresTEdit5").hide();
    $("#txtAreaTestigosEdit5").hide();
    $("#txtAreaTestigosEdit5").val("");
    $("#caracteresTEdit6").hide();
    $("#txtAreaTestigosEdit6").hide();
    $("#txtAreaTestigosEdit6").val("");
    $("#caracteresTEdit7").hide();
    $("#txtAreaTestigosEdit7").hide();
    $("#txtAreaTestigosEdit7").val("");
    $("#agregarRecopilacionEdit").show();
    $("#eliminarRecopilacionEdit").hide();
    $("#caracteresREdit2").hide();
    $("#txtAreaRecopilacionEdit2").hide();
    $("#txtAreaRecopilacionEdit2").val("");
    $("#caracteresREdit3").hide();
    $("#txtAreaRecopilacionEdit3").hide();
    $("#txtAreaRecopilacionEdit3").val("");
    $("#caracteresREdit4").hide();
    $("#txtAreaRecopilacionEdit4").hide();
    $("#txtAreaRecopilacionEdit4").val("");
    $("#caracteresREdit5").hide();
    $("#txtAreaRecopilacionEdit5").hide();
    $("#txtAreaRecopilacionEdit5").val("");
    $("#caracteresREdit6").hide();
    $("#txtAreaRecopilacionEdit6").hide();
    $("#txtAreaRecopilacionEdit6").val("");
    $("#caracteresREdit7").hide();
    $("#txtAreaRecopilacionEdit7").hide();
    $("#txtAreaRecopilacionEdit7").val("");
    $("#caracteresREdit8").hide();
    $("#txtAreaRecopilacionEdit8").hide();
    $("#txtAreaRecopilacionEdit8").val("");
    $("#caracteresREdit9").hide();
    $("#txtAreaRecopilacionEdit9").hide();
    $("#txtAreaRecopilacionEdit9").val("");
    $("#caracteresREdit10").hide();
    $("#txtAreaRecopilacionEdit10").hide();
    $("#txtAreaRecopilacionEdit10").val("");
    $("#AgregarTextoResponsabilidadEdit").show();
    $("#eliminarTextoResponsabilidadEdit").hide();
    $("#caracteresRPEdit2").hide();
    $("#txtResponsabilidadEdit2").hide();
    $("#txtResponsabilidadEdit2").val("");
    $("#AgregarTextoOrdenesEdit").show();
    $("#eliminarTextoOrdenesEdit").hide();
    $("#caracteresEditO2").hide();
    $("#txtAreaOrdenesEdit2").hide();
    $("#txtAreaOrdenesEdit2").val("");
    $("#AgregarTextoEvidenciaEdit").show();
    $("#eliminarTextoEvidenciaEdit").hide();
    $("#caracteresEditE2").hide();
    $("#txtAreaEvidenciaEdit2").hide();
    $("#txtAreaEvidenciaEdit2").val("");
    $("#AgregarTextoSupervisionEdit").show();
    $("#eliminarTextoSupervisionEdit").hide();
    $("#caracteresSPEdit2").hide();
    $("#txtAreaSupervisionEdit2").hide();
    $("#txtAreaSupervisionEdit2").val("");
    editarReporteIncidenciaCentroDeControl(idIncidencia);
}


 function editarReporteIncidenciaCentroDeControl(idIncidencia)
{      
    $.ajax({
        type: "POST",
        url: "HistoricoReporteIncidenciasCentroDeControl/ajax_ConsultaDatosDeCentroDeControl.php",
        data:{"idIncidencia":idIncidencia},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
                var DescripcionTipoIncidencia = response.datos[0]["DescripcionTipoIncidencia"];
                var PuntoServicioActual = response.datos[0]["PuntoServicioActual"];
                var NumeroEmpleado = response.datos[0]["NumeroEmpleado"];
                var NombreEmpelado = response.datos[0]["NombreEmpelado"];
                var NumeroAdmin = response.datos[0]["NumeroAdmin"];
                var NombreAdmin = response.datos[0]["NombreAdmin"];
                var Percataron = response.datos[0]["Percataron"];
                var Tarea = response.datos[0]["Tarea"];
           
                var LargoTestigos = response.datos[0]["LargoTestigos"];
                var LargoRecopilacion = response.datos[0]["LargoRecopilacion"];
                var LargoResponsabilidad = response.datos[0]["LargoResponsabilidad"];
                var LargoOrdenes = response.datos[0]["LargoOrdenes"];
                var LargoEvidencia = response.datos[0]["LargoEvidencia"];
                var LargoSupervisiones = response.datos[0]["LargoSupervisiones"];

                $("#inpTipoincidenciaEdit").val(DescripcionTipoIncidencia);
                $("#inpdivPuntoServicioEscritoCCEdit").val(PuntoServicioActual);
                $("#inpNumeroGuardiaIncidenciaEdit").val(NumeroEmpleado);
                $("#inpNombreGuardiaIncidenciaEdit").val(NombreEmpelado);
                $("#inpNumeroAdministrativoIncidenciaEdit").val(NumeroAdmin);
                $("#inpNombreAdministrativoIncidenciaEdit").val(NombreAdmin);
                $("#conteoTestigosEdit").val(LargoTestigos);
                for (var i = 0; i < LargoTestigos; i++) {
                    var a = i+1;
                    $("#caracteresTEdit"+a).show();
                    $("#txtAreaTestigosEdit"+a).show();
                    var aa = response.datos[0]["Testigo"+a];
                    $("#txtAreaTestigosEdit"+a).val(aa);
                }
                $("#txtAreaPercataronEdit").val(Percataron);
                $("#conteoRecopilacionEdit").val(LargoRecopilacion);
                for (var j = 0; j < LargoRecopilacion; j++) {
                    var b = j+1;
                    $("#caracteresREdit"+b).show();
                    $("#txtAreaRecopilacionEdit"+b).show();
                    var bb = response.datos[0]["Recopilacion"+b];
                    $("#txtAreaRecopilacionEdit"+b).val(bb);
                }
                $("#txtAreaTareaEdit").val(Tarea);
                $("#conteoTxtResponsabilidadEdit").val(LargoResponsabilidad);
                $("#txtResponsabilidadEdit1").val(response.datos[0]["Responsabilidad1"]);
                if(LargoResponsabilidad=="2" || LargoResponsabilidad==2){
                    $("#caracteresRPEdit2").show();
                    $("#txtResponsabilidadEdit2").show();
                    $("#txtResponsabilidadEdit2").val(response.datos[0]["Responsabilidad2"]);
                }
                $("#conteoTxtOrdenesEdit").val(LargoOrdenes);
                $("#txtAreaOrdenesEdit1").val(response.datos[0]["Ordenes1"]);
                if(LargoOrdenes=="2" || LargoOrdenes==2){
                    $("#caracteresEditO2").show();
                    $("#txtAreaOrdenesEdit2").show();
                    $("#txtAreaOrdenesEdit2").val(response.datos[0]["Ordenes2"]);
                }
                $("#conteoTxtEvidenciaEdit").val(LargoEvidencia);
                $("#txtAreaEvidenciaEdit1").val(response.datos[0]["Evidencia1"]);
                if(LargoEvidencia=="2" || LargoEvidencia==2){
                    $("#caracteresRPEdit2").show();
                    $("#txtAreaEvidenciaEdit2").show();
                    $("#txtAreaEvidenciaEdit2").val(response.datos[0]["Evidencia2"]);
                }
                $("#conteoTxtSupervisionEdit").val(LargoSupervisiones);
                $("#txtAreaSupervisionEdit1").val(response.datos[0]["Supervisiones1"]);
                if(LargoSupervisiones=="2" || LargoSupervisiones==2){
                    $("#caracteresSPEdit2").show();
                    $("#txtAreaSupervisionEdit2").show();
                    $("#txtAreaSupervisionEdit2").val(response.datos[0]["Supervisiones2"]);
                }
                if(LargoTestigos==7){
                    $("#agregarTestigoEdit").hide();
                    $("#eliminarTestigoEdit").show();
                }else{
                    if(LargoTestigos!=1){
                        $("#eliminarTestigoEdit").show();
                    }

                }
                if(LargoRecopilacion==10){
                    $("#agregarRecopilacionEdit").hide();
                    $("#eliminarRecopilacionEdit").show();
                }else{
                    if(LargoRecopilacion!=1){
                        $("#eliminarRecopilacionEdit").show();
                    }

                }
                if(LargoResponsabilidad==2){
                    $("#AgregarTextoResponsabilidadEdit").hide();
                    $("#eliminarTextoResponsabilidadEdit").show();
                }
                if(LargoOrdenes==2){
                    $("#AgregarTextoOrdenesEdit").hide();
                    $("#eliminarTextoOrdenesEdit").show();
                }
                if(LargoEvidencia==2){
                    $("#AgregarTextoEvidenciaEdit").hide();
                    $("#eliminarTextoEvidenciaEdit").show();
                }
                if(LargoSupervisiones==2){
                    $("#AgregarTextoSupervisionEdit").hide();
                    $("#eliminarTextoSupervisionEdit").show();
                }
               $("#modalEdicionReporteCC").modal();
            }else{
                var mensaje = response.message;
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
} 


$('#agregarTestigoEdit').click(function() {
    var noTestigos = $("#conteoTestigosEdit").val();

    if(noTestigos=="1"){
       $("#txtAreaTestigosEdit2").show();
       $("#conteoTestigosEdit").val(2);
       $("#eliminarTestigoEdit").show();
       $("#caracteresTEdit2").show();
    }if(noTestigos=="2"){
       $("#txtAreaTestigosEdit3").show();
       $("#conteoTestigosEdit").val(3);
       $("#caracteresTEdit3").show();
    }if(noTestigos=="3"){
       $("#txtAreaTestigosEdit4").show();
       $("#conteoTestigosEdit").val(4);
       $("#caracteresTEdit4").show();
    }if(noTestigos=="4"){
       $("#txtAreaTestigosEdit5").show();
       $("#conteoTestigosEdit").val(5);
       $("#caracteresTEdit5").show();
    }if(noTestigos=="5"){
       $("#txtAreaTestigosEdit6").show();
       $("#conteoTestigosEdit").val(6);
       $("#caracteresTEdit6").show();
    }if(noTestigos=="6"){
       $("#txtAreaTestigosEdit7").show();
       $("#conteoTestigosEdit").val(7);
       $("#agregarTestigoEdit").hide();
       $("#caracteresTEdit7").show();
    }
});

$('#eliminarTestigoEdit').click(function() {
    var noTestigos = $("#conteoTestigosEdit").val();

    if(noTestigos=="7"){
       $("#txtAreaTestigosEdit7").hide();
       $("#txtAreaTestigosEdit7").val("");
       $("#conteoTestigosEdit").val(6);
       $("#agregarTestigoEdit").show();
       $("#caracteresTEdit7").hide();
    }if(noTestigos=="6"){
       $("#txtAreaTestigosEdit6").hide();
       $("#txtAreaTestigosEdit6").val("");
       $("#conteoTestigosEdit").val(5);
       $("#caracteresTEdit6").hide();
    }if(noTestigos=="5"){
       $("#txtAreaTestigosEdit5").hide();
       $("#txtAreaTestigosEdit5").val("");
       $("#conteoTestigosEdit").val(4);
       $("#caracteresTEdit5").hide();
    }if(noTestigos=="4"){
       $("#txtAreaTestigosEdit4").hide();
       $("#txtAreaTestigosEdit4").val("");
       $("#conteoTestigosEdit").val(3);
       $("#caracteresTEdit4").hide();
    }if(noTestigos=="3"){
       $("#txtAreaTestigosEdit3").hide();
       $("#txtAreaTestigosEdit3").val("");
       $("#conteoTestigosEdit").val(2);
       $("#caracteresTEdit3").hide();
    }if(noTestigos=="2"){
       $("#txtAreaTestigosEdit2").hide();
       $("#txtAreaTestigosEdit2").val("");
       $("#conteoTestigosEdit").val(1);
       $("#eliminarTestigoEdit").hide();
       $("#caracteresTEdit2").hide();
    }
});

$('#agregarRecopilacionEdit').click(function() {
    var parrafo = $("#conteoRecopilacionEdit").val();

    if(parrafo=="1"){
       $("#txtAreaRecopilacionEdit2").show();
       $("#conteoRecopilacionEdit").val(2);
       $("#eliminarRecopilacionEdit").show();
       $("#caracteresREdit2").show();
    }if(parrafo=="2"){
       $("#txtAreaRecopilacionEdit3").show();
       $("#conteoRecopilacionEdit").val(3);
       $("#caracteresREdit3").show();
    }if(parrafo=="3"){
       $("#txtAreaRecopilacionEdit4").show();
       $("#conteoRecopilacionEdit").val(4);
       $("#caracteresREdit4").show();
    }if(parrafo=="4"){
       $("#txtAreaRecopilacionEdit5").show();
       $("#conteoRecopilacionEdit").val(5);
       $("#caracteresREdit5").show();
    }if(parrafo=="5"){
       $("#txtAreaRecopilacionEdit6").show();
       $("#conteoRecopilacionEdit").val(6);
       $("#caracteresREdit6").show();
    }if(parrafo=="6"){
       $("#txtAreaRecopilacionEdit7").show();
       $("#conteoRecopilacionEdit").val(7);
       $("#caracteresREdit7").show();
    }if(parrafo=="7"){
       $("#txtAreaRecopilacionEdit8").show();
       $("#conteoRecopilacionEdit").val(8);
       $("#caracteresREdit8").show();
    }if(parrafo=="8"){
       $("#txtAreaRecopilacionEdit9").show();
       $("#conteoRecopilacionEdit").val(9);
       $("#caracteresREdit9").show();
    }if(parrafo=="9"){
       $("#txtAreaRecopilacionEdit10").show();
       $("#conteoRecopilacionEdit").val(10);
       $("#agregarRecopilacionEdit").hide();
       $("#caracteresREdit10").show();
    }
});

$('#eliminarRecopilacionEdit').click(function() {
    var parrafo = $("#conteoRecopilacionEdit").val();

    if(parrafo=="10"){
       $("#txtAreaRecopilacionEdit10").hide();
       $("#txtAreaRecopilacionEdit10").val("");
       $("#conteoRecopilacionEdit").val(9);
       $("#agregarRecopilacionEdit").show();
       $("#caracteresREdit10").hide();
    }if(parrafo=="9"){
       $("#txtAreaRecopilacionEdit9").hide();
       $("#txtAreaRecopilacionEdit9").val("");
       $("#conteoRecopilacionEdit").val(8);
       $("#caracteresREdit9").hide();
    }if(parrafo=="8"){
       $("#txtAreaRecopilacionEdit8").hide();
       $("#txtAreaRecopilacionEdit8").val("");
       $("#conteoRecopilacionEdit").val(7);
       $("#caracteresREdit8").hide();
    }if(parrafo=="7"){
       $("#txtAreaRecopilacionEdit7").hide();
       $("#txtAreaRecopilacionEdit7").val("");
       $("#conteoRecopilacionEdit").val(6);
       $("#caracteresREdit7").hide();
    }if(parrafo=="6"){
       $("#txtAreaRecopilacionEdit6").hide();
       $("#txtAreaRecopilacionEdit6").val("");
       $("#conteoRecopilacionEdit").val(5);
       $("#caracteresREdit6").hide();
    }if(parrafo=="5"){
       $("#txtAreaRecopilacionEdit5").hide();
       $("#txtAreaRecopilacionEdit5").val("");
       $("#conteoRecopilacionEdit").val(4);
       $("#caracteresREdit5").hide();
    }if(parrafo=="4"){
       $("#txtAreaRecopilacionEdit4").hide();
       $("#txtAreaRecopilacionEdit4").val("");
       $("#conteoRecopilacionEdit").val(3);
       $("#caracteresREdit4").hide();
    }if(parrafo=="3"){
       $("#txtAreaRecopilacionEdit3").hide();
       $("#txtAreaRecopilacionEdit3").val("");
       $("#conteoRecopilacionEdit").val(2);
       $("#caracteresREdit3").hide();
    }if(parrafo=="2"){
       $("#txtAreaRecopilacionEdit2").hide();
       $("#txtAreaRecopilacionEdit2").val("");
       $("#conteoRecopilacionEdit").val(1);
       $("#eliminarRecopilacionEdit").hide();
       $("#caracteresREdit2").hide();
    }
});






$('#AgregarTextoSupervisionEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtSupervisionEdit").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaSupervisionEdit2").show();
       $("#conteoTxtSupervisionEdit").val(2);
       $("#eliminarTextoSupervisionEdit").show();
       $("#AgregarTextoSupervisionEdit").hide();
       $("#caracteresSPEdit2").show();
    }
});

$('#eliminarTextoSupervisionEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtSupervisionEdit").val();
    if(txtResponsabilidad=="2"){
       $("#txtAreaSupervisionEdit2").hide();
       $("#txtAreaSupervisionEdit2").val("");
       $("#conteoTxtSupervisionEdit").val(1);
       $("#eliminarTextoSupervisionEdit").hide();
       $("#AgregarTextoSupervisionEdit").show();
       $("#caracteresSPEdit2").hide();
    }
});

$('#AgregarTextoEvidenciaEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtEvidenciaEdit").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaEvidenciaEdit2").show();
       $("#conteoTxtEvidenciaEdit").val(2);
       $("#eliminarTextoEvidenciaEdit").show();
       $("#AgregarTextoEvidenciaEdit").hide();
       $("#caracteresEditE2").show();
    }
});

$('#eliminarTextoEvidenciaEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtEvidenciaEdit").val();

    if(txtResponsabilidad=="2"){
       $("#txtAreaEvidenciaEdit2").hide();
       $("#txtAreaEvidenciaEdit2").val("");
       $("#conteoTxtEvidenciaEdit").val(1);
       $("#eliminarTextoEvidenciaEdit").hide();
       $("#AgregarTextoEvidenciaEdit").show();
       $("#caracteresEditE2").hide();
    }
});

$('#AgregarTextoOrdenesEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtOrdenesEdit").val();

    if(txtResponsabilidad=="1"){
       $("#txtAreaOrdenesEdit2").show();
       $("#conteoTxtOrdenesEdit").val(2);
       $("#eliminarTextoOrdenesEdit").show();
       $("#AgregarTextoOrdenesEdit").hide();
       $("#caracteresEditO2").show();
    }
});

$('#eliminarTextoOrdenesEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtOrdenesEdit").val();

    if(txtResponsabilidad=="2"){
       $("#txtAreaOrdenesEdit2").hide();
       $("#txtAreaOrdenesEdit2").val("");
       $("#conteoTxtOrdenesEdit").val(1);
       $("#eliminarTextoOrdenesEdit").hide();
       $("#AgregarTextoOrdenesEdit").show();
       $("#caracteresEditO2").hide();
    }
});

$('#AgregarTextoResponsabilidadEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtResponsabilidadEdit").val();

    if(txtResponsabilidad=="1"){
       $("#txtResponsabilidadEdit2").show();
       $("#conteoTxtResponsabilidadEdit").val(2);
       $("#eliminarTextoResponsabilidadEdit").show();
       $("#AgregarTextoResponsabilidadEdit").hide();
       $("#caracteresRPEdit2").show();
    }
});

$('#eliminarTextoResponsabilidadEdit').click(function() {
    var txtResponsabilidad = $("#conteoTxtResponsabilidadEdit").val();

    if(txtResponsabilidad=="2"){
       $("#txtResponsabilidadEdit2").hide();
       $("#txtResponsabilidadEdit2").val("");
       $("#conteoTxtResponsabilidadEdit").val(1);
       $("#eliminarTextoResponsabilidadEdit").hide();
       $("#AgregarTextoResponsabilidadEdit").show();
       $("#caracteresRPEdit2").hide();
    }
});

$('#guardarIncidenciaCCEdit').click(function() {
    $("#modalEdicionReporteCC").modal('hide');
    $("#modalFirmaReporteincidenciaCCEdit").modal();
});


function RevisarFirmaInternaParaReingresoEmpleadoEdit(){
   var NumEmpModalBaja = $("#NumEmpModalFirmaReporteincidenciaEmpleadoEdit").val();
   var constraseniaFirma = $("#constraseniaFirmaParaReporteincidenciaEmpleadoEdit").val();
   if(NumEmpModalBaja==""){
      cargaerroresFirmaInternaReporteIncidenciaCCEdit("El numero de empleado no puede estar vacio");
   }else if(constraseniaFirma==""){
      cargaerroresFirmaInternaReporteIncidenciaCCEdit("Escriba la contraseña para continuar");
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
                  cargaerroresFirmaInternaReporteIncidenciaCCEdit("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
               }else{
                  var contraseniaInsertadaCifrada = response.datos["0"].ContraseniaFirma;
                  $("#constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit").val(contraseniaInsertadaCifrada);
                  $("#NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit").val(NumEmpModalBaja);
                  $("#modalFirmaReporteincidenciaCCEdit").modal("hide");
                  $("#NumEmpModalFirmaReporteincidenciaEmpleadoEdit").val("");
                  $("#constraseniaFirmaParaReporteincidenciaEmpleadoEdit").val("");
                  guardarDatosEditadosDeCentroDeControl();
               }
           }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
         }
      });
   }
}

function cargaerroresFirmaInternaReporteIncidenciaCCEdit(mensaje){
  $('#errormodalFirmaReporteincidenciaCCEdit').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaReporteincidenciaCCEdit1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaReporteincidenciaCCEdit").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaReporteincidenciaCCEdit').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaParaReingresoEmpleadoEdit(){
    $("#modalEdicionReporteCC").modal();
    $("#modalFirmaReporteincidenciaCCEdit").modal('hide');
    $("#NumEmpModalFirmaReporteincidenciaEmpleadoEdit").val("");
    $("#constraseniaFirmaParaReporteincidenciaEmpleadoEdit").val("");
}

function guardarDatosEditadosDeCentroDeControl(){
    var formData = new FormData($("#formEdicionreporteICC")[0]);
    var aaa = $("#inpTipoincidenciaEdit").val();
    formData.append('IdIncidenciaEdit', $("#IdIncidenciaEdit").val());
    formData.append('txtAreaTestigosEdit1', $("#txtAreaTestigosEdit1").val());
    formData.append('txtAreaTestigosEdit2', $("#txtAreaTestigosEdit2").val());
    formData.append('txtAreaTestigosEdit3', $("#txtAreaTestigosEdit3").val());
    formData.append('txtAreaTestigosEdit4', $("#txtAreaTestigosEdit4").val());
    formData.append('txtAreaTestigosEdit5', $("#txtAreaTestigosEdit5").val());
    formData.append('txtAreaTestigosEdit6', $("#txtAreaTestigosEdit6").val());
    formData.append('txtAreaTestigosEdit7', $("#txtAreaTestigosEdit7").val());
    formData.append('txtAreaPercataronEdit', $("#txtAreaPercataronEdit").val());
    formData.append('txtAreaRecopilacionEdit1', $("#txtAreaRecopilacionEdit1").val());
    formData.append('txtAreaRecopilacionEdit2', $("#txtAreaRecopilacionEdit2").val());
    formData.append('txtAreaRecopilacionEdit3', $("#txtAreaRecopilacionEdit3").val());
    formData.append('txtAreaRecopilacionEdit4', $("#txtAreaRecopilacionEdit4").val());
    formData.append('txtAreaRecopilacionEdit5', $("#txtAreaRecopilacionEdit5").val());
    formData.append('txtAreaRecopilacionEdit6', $("#txtAreaRecopilacionEdit6").val());
    formData.append('txtAreaRecopilacionEdit7', $("#txtAreaRecopilacionEdit7").val());
    formData.append('txtAreaRecopilacionEdit8', $("#txtAreaRecopilacionEdit8").val());
    formData.append('txtAreaRecopilacionEdit9', $("#txtAreaRecopilacionEdit9").val());
    formData.append('txtAreaRecopilacionEdit10', $("#txtAreaRecopilacionEdit10").val());
    formData.append('txtAreaTareaEdit', $("#txtAreaTareaEdit").val());
    formData.append('txtResponsabilidadEdit1', $("#txtResponsabilidadEdit1").val());
    formData.append('txtResponsabilidadEdit2', $("#txtResponsabilidadEdit2").val());
    formData.append('txtAreaOrdenesEdit1', $("#txtAreaOrdenesEdit1").val());
    formData.append('txtAreaOrdenesEdit2', $("#txtAreaOrdenesEdit2").val());
    formData.append('txtAreaEvidenciaEdit1', $("#txtAreaEvidenciaEdit1").val());
    formData.append('txtAreaEvidenciaEdit2', $("#txtAreaEvidenciaEdit2").val());
    formData.append('txtAreaSupervisionEdit1', $("#txtAreaSupervisionEdit1").val());
    formData.append('txtAreaSupervisionEdit2', $("#txtAreaSupervisionEdit2").val());
    formData.append('constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit', $("#constraseniaFirmaParaReporteincidenciaEmpleadoHiddenEdit").val());
    formData.append('NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit', $("#NumEmpModalFirmaReporteincidenciaEmpleadohiddenEdit").val());
    
    $.ajax({
        type: "POST",
        url: "HistoricoReporteIncidenciasCentroDeControl/ajax_GuardarDatosEditedReporteIncidenciaCC.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false, 
        async:false, 
        success: function(response) {
            if (response.status == "success")
            {
                swal("GRACIAS","Se ha editado con exito el reporte de incidencia", "success"); 
                $("#formEdicionreporteICC")[0].reset(); 
                $("#modalEdicionReporteCC").modal('hide');
                ConsultaHistoricotablaReporteIncidenciasCentroDeControl(); 
            }else if (response.status == "error"){
                var mensaje = response.message;
                swal("Alto",mensaje, "error");   
            }
        },error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
        }
    }); 
}


