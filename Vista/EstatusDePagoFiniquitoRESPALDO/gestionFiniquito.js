  function ConsultaFiniquitosEnGestion(){ 
    waitingDialog.show();
    firmaFiniquito = [];
    $.ajax({
        type: "POST",
        url: "EstatusDePagoFiniquito/ajax_ConsultaFiniquitosEnGestion.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    firmaFiniquito.push(record);
                }
                loadDataIntableFirmaFiniquitos(firmaFiniquito);
                $("#tablaGetionFiniquitos").show();
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
 var tablaDeGestiosFiniquito = null;

 function loadDataIntableFirmaFiniquitos(data) {
    if(tablaDeGestiosFiniquito != null) {
        tablaDeGestiosFiniquito.destroy();
    }
    tablaDeGestiosFiniquito = $('#tablaGetionFiniquitos').DataTable({
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
             "data": "NumeroEmpleado"
         }, 
         {   
             "data": "NombreEmpleado"
         },
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "FechaBaja"
         },
         {   
             "data": "NumerodminBaja"
         },
         {   
             "data": "NombreAdminBaja"
         },
         {   
             "data": "abrirPdf"
         },
         {   
             "data": "checkvarios"
         },
         {   
             "data": "cargarArchivo"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 
function abrirPdfFiniquitoLider(numempleado, fechabaja, fechaalta) {
    window.open("../Nominas/finiquitos/generadordocfiniquito.php?numempleado=" + numempleado + "&" + "fechabaja=" + fechabaja + "&" + "fechaalta=" + fechaalta);
 }

 function abrirModalCargarArchivoGestionFiniquito(numempleado, idFiniquito,fechaBaja, fechaAlta,estatusActual) {
    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(numempleado); 
    $("#idFiniHidden").val(idFiniquito); 
    $("#fechaAltahidden").val(fechaAlta); 
    $("#fechaBajaHidden").val(fechaBaja); 
    $("#estatusActual").val(estatusActual); 
    $("#archivoGestionFini").val("");
    $("#ModalCargarArchivoGestionFini").modal(); 

 }

 $("#btnDescargaMultipleFiniquitosEnGestion").click(function(){
    var finiquitosSeleccionados = $( "input[type=checkbox]:checked");
    var LargofiniquitosSeleccionados = finiquitosSeleccionados.length; 
    if(LargofiniquitosSeleccionados < 2 ){
        swal("Alto","Debes Seleccionar mas de un finiquito para usar esta opcion","waiting")
    }else{
            console.log(finiquitosSeleccionados);
        for (var i = 0; i < LargofiniquitosSeleccionados; i++)
        {
            var numeroEmpleado = $("#"+finiquitosSeleccionados[i].value).attr("numeroempleado");
            var empleadoFechaBaja = $("#"+finiquitosSeleccionados[i].value).attr("empleadoFechaBaja");
            var empleadoFechaAlta = $("#"+finiquitosSeleccionados[i].value).attr("empleadoFechaAlta");
            abrirPdfFiniquitoLider(numeroEmpleado, empleadoFechaBaja, empleadoFechaAlta);
            $("#"+finiquitosSeleccionados[i].value).prop("checked", false);  
        }
    }

});

$("#btnCargarGestionFini").click(function(){
    
    var numempleado = $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(); 
    var idFiniquito = $("#idFiniHidden").val(); 
    var fechaAlta = $("#fechaAltahidden").val(); 
    var fechaBaja = $("#fechaBajaHidden").val();
    var archivoGestionFini = $("#archivoGestionFini").val();
    var estatusActual = $("#estatusActual").val(); 
    var formData = new FormData($("#formArchivoGestionFini")[0]);
    alert(archivoGestionFini);
    formData.append('numempleado', numempleado);
    formData.append('idFiniquito', idFiniquito);
    formData.append('fechaAlta', fechaAlta);
    formData.append('fechaBaja', fechaBaja);
    if(archivoGestionFini!=""){
        $.ajax({
            type: "POST",
            url: "EstatusDePagoFiniquito/ajax_CargarArchivoFiniquitoFirmado.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            async:false, 
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success"){
                    swal("Listo", "Solicitud enviada y finiquito cargado correctamente ","success");
                    insertarHistoricoMovimientoFiniquitoPagoProcesoDeFirma(idFiniquito,estatusActual,3);
                    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(""); 
                    $("#idFiniHidden").val(""); 
                    $("#fechaAltahidden").val(""); 
                    $("#fechaBajaHidden").val("");
                    $("#archivoGestionFini").val("");
                    $('#ModalCargarArchivoGestionFini').modal('hide');
                }else if(response.status=="error"){
                    swal("Alto", "Error al cargar comprobacion","error");
                }
            },error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
            }
        });
    }else{
        swal("Alto", "Error Selecciona un archivo para cargar","error");
    }
});

$("#btnCancelarGestionFini").click(function(){
    $("#NumeroEmpleadoModalCargarArchivoGestionFini").val(""); 
    $("#idFiniHidden").val(""); 
    $("#fechaAltahidden").val(""); 
    $("#fechaBajaHidden").val("");
    $("#archivoGestionFini").val("");
    $('#ModalCargarArchivoGestionFini').modal('hide');
});

 function insertarHistoricoMovimientoFiniquitoPagoProcesoDeFirma(idFiniquito,estatusActual,estatusNuevo) { 
    $.ajax({
        type: "POST",
        url: "EstatusDePagoFiniquito/ajax_insertarHistoricoMovimientoFiniquitoPago.php",
        data: {"idFiniquito":idFiniquito,"estatusActual":estatusActual,"estatusNuevo":estatusNuevo}, 
        dataType: "json",
        async: false,
        success: function(response) {
            var mensaje=response.message;
            if (response.status=="success"){
                ConsultaFiniquitosEnGestion();
            }else if(response.status=="error"){
                swal("Alto", "Error al procesar el retorno a proceso de validacion del finiquito ","error");
            }
        },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    }); 
 }