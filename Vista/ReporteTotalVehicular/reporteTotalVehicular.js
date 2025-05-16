 // $(document).ready(function() {
 //    consultaParqueVehicularCompleto();
 // });

$("#btnConsultarReporte").click(function(event) {
    consultaParqueVehicularCompleto();
});

 function consultaParqueVehicularCompleto(){ 
    waitingDialog.show();
    historicotablaPeticiones = [];
    $.ajax({
        type: "POST",
        url: "ReporteTotalVehicular/ajax_ConsultaParqueVehicular.php",
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    historicotablaPeticiones.push(record);
                }
                $("#tablaPeticionesTurnosCapacitacionHis").show();
                loadDataIntableHistoricoPeticionesTurnos(historicotablaPeticiones);
                waitingDialog.hide();
            }else{
                var mensaje = response.message;
                $("#tablaPeticionesTurnosCapacitacionHis").hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
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
             "data": "descripcionLineaNegocio"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         }, 
         {   
             "data": "NumeroPlaca"
         }, 
         {   
             "data": "Marca"
         }, 
         {   
             "data": "Modelo"
         },
         {   
             "data": "Descripcion"
         },  
         {   
             "data": "AnioVehiculo"
         },
         {   
             "data": "CentimetrosCubicos"
         },
         {   
             "data": "EstatusDelVehiculo"
         },
         {   
             "data": "noEmp"
         },
         {   
             "data": "nombreEmp"
         },
         {   
             "data": "empleadoEstatusId"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 } 
