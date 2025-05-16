$("#fechaInicioHisMov").focus(function (){
   $("#opcionconsultahidden").val("1");
   $("#NumEmpleadoCosHistoMov").val(""); 
});

$("#fechaFinHisMov").focus(function (){
    $("#opcionconsultahidden").val("1");
    $("#NumEmpleadoCosHistoMov").val("");
});

$("#NumEmpleadoCosHistoMov").focus(function (){
    $("#opcionconsultahidden").val("2");
    $("#fechaInicioHisMov").val(""); 
    $("#fechaFinHisMov").val(""); 
});
function ConsultaHistoricoMovimientosFiniquitoPago11(){
    var fechaInicioHisMov = $("#fechaInicioHisMov").val();
    var fechaFinHisMov = $("#fechaFinHisMov").val();
    var NumEmpleadoCosHistoMov = $("#NumEmpleadoCosHistoMov").val();
    var opcion = $("#opcionconsultahidden").val();

    if(fechaInicioHisMov == "" && fechaFinHisMov == "" && NumEmpleadoCosHistoMov == ""){
        swal("Alto","Ingresa el rango de fechas o el número de empleado que desea buscar","warning");
    }else if(fechaInicioHisMov>fechaFinHisMov){
        swal("Alto","La fecha de inicio no puede ser mayor a la fecha fin","warning");
    }else if(fechaInicioHisMov == "" && fechaFinHisMov == "" && NumEmpleadoCosHistoMov == ""){
        swal("Alto","Ingresa el rango de fechas o el número de empleado que desea buscar","warning");
    }else{
        listaTable="<table class='table table-hover' ><thead><th>Departamento</th><th>Nomenclatura</th><th>Color</th></thead><tbody>";
        listaTable += "<tr><td>GENERADO</td><td>S/N</td><td  style='color: rgb(15,195,235);'>AZUL</td></tr><tr><td>LIDER DE UNIDAD</td><td>LU</td><td  style='color: rgb(255,0,0);'>ROJO</td></tr><tr>";
        listaTable += "<tr><td>FINANZAS</td><td>FI</td><td style='color: rgb(255,155,0);'>NARANJA</td></tr>";
        listaTable += "<tr><td>TERMINADO</td><td>S/N</td><td style='color: rgb(4,139,20);'>VERDE</td></tr>";
        listaTable += "</tbody></table>";
        $('#tablanomeclaturaAA').html(listaTable);
        waitingDialog.show();
        historicoMovFiniPago = [];
        $.ajax({
            type: "POST",
            url: "HistoricoMovimientosFiniquitosPago/ajax_ConsultaHistoricoMovimientosFiniquitoPago.php",
            data: {"fechaInicioHisMov":fechaInicioHisMov,"fechaFinHisMov":fechaFinHisMov,"NumEmpleadoCosHistoMov":NumEmpleadoCosHistoMov,"opcion":opcion}, 
            dataType: "json",
            async: false,
            success: function(response) {
                if(response.status == "success") {
                   for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        historicoMovFiniPago.push(record);
                    }
                    loadDataIntableHisotricoMovimientosFiniPago(historicoMovFiniPago);
                    $("#tablaHistoricoMovimientosFiniquitoPago").show();
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
}
 var tablaDeHistoricoFiniquitosEnPago = null;

 function loadDataIntableHisotricoMovimientosFiniPago(data) {
    if(tablaDeHistoricoFiniquitosEnPago != null) {
        tablaDeHistoricoFiniquitosEnPago.destroy();
    }
    tablaDeHistoricoFiniquitosEnPago = $('#tablaHistoricoMovimientosFiniquitoPago').DataTable({
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
             "data": "EstatusAnterior"
         },
         {   
             "data": "EstatusActual"
         },
         {   
             "data": "fechamovimiento"
         },
         {   
             "data": "docComprovante"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 

function abrirPdfcomprobanteFinanzas(nombreDoc){
    window.open("uploads/comprobantesPagoFiniquitos/"+nombreDoc);

}
