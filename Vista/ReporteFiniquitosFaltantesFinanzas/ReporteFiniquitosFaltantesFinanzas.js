function ConsultaHistoricoMovimientosFiniquitoPago(){

    waitingDialog.show();
    finiFaltanytesFinanzas = [];
    $.ajax({
        type: "POST",
        url: "ReporteFiniquitosFaltantesFinanzas/ajax_ConsultaReporteFinFiniquitosFaltantes.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    finiFaltanytesFinanzas.push(record);
                }
                loadDataIntableFFFP(finiFaltanytesFinanzas);
                $("#tablaReporteFinanzasFiniquitsFaltantes").show();
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
 var tablaDeHistoricoFiniquitosEnPago = null;

 function loadDataIntableFFFP(data) {
    if(tablaDeHistoricoFiniquitosEnPago != null) {
        tablaDeHistoricoFiniquitosEnPago.destroy();
    }
    tablaDeHistoricoFiniquitosEnPago = $('#tablaReporteFinanzasFiniquitsFaltantes').DataTable({
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
            "className": "dt-body-right","data": "netoAlPago1", 
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel',{
                extend: 'pdf',
                title: function () {
                    var date = new Date();
                    var year = date.getFullYear();
                    var month = ("0" + (date.getMonth() + 1)).slice(-2);
                    var day = ("0" + date.getDate()).slice(-2);
                    var hours = ("0" + date.getHours()).slice(-2);
                    var minutes = ("0" + date.getMinutes()).slice(-2);
                    return ("GIF SEGURIDAD S.A DE C.V \n\n FINIQUITOS PENDIENTES DE PAGO AL: " + day + "-" + month + "-" + year + " " + hours + ":" + minutes);
                },customize: function (data) {
                      var rowCount = data.content[1].table.body.length;
                      for (i = 1; i < rowCount; i++) {
                          data.content[1].table.body[i][0].alignment = 'right';
                          data.content[1].table.body[i][3].alignment = 'right';
                      }
                },
            }]
        }
    });
} 