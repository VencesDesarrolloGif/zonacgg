document.getElementById('btnConsultaStockSuper').addEventListener("click", function(){
    consultaStockUniformesXsup();
 });

 function consultaStockUniformesXsup(){  
    waitingDialog.show();
    uniformesStock = [];

    $("#mensajeSinSolicitudesUsuarios").hide();
    $.ajax({
        type: "POST",
        url: "stockSupervisor/ajax_ConsultaStockUniformesXsup.php",
        dataType: "json",
         success: function(response) {
                if(response.status == "success") {
                    var count=response.datos.length;
                   for (var i = 0; i < response.datos.length; i++){
                        var record = response.datos[i];
                        uniformesStock.push(record);
                    }
                    $("#tablaStockUniformeSup").show();
                    loadDataIntableStockUniformeXSup(uniformesStock);
                    waitingDialog.hide();
                    $("#tablaStockUniformeSup").show();
                    $("#msjSinSolicitudesPendientes").hide();
                }else{
                    var mensaje = response.message;
                    CargarMensajeFotoVehiculoApp(mensaje,"error");
                    waitingDialog.hide();
                }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
    });
}

var tablaStockSupervisor = null;
 function loadDataIntableStockUniformeXSup(data) {
    if(tablaStockSupervisor != null) {
        tablaStockSupervisor.destroy();
    }
    tablaStockSupervisor = $('#tablaStockUniformeSup').DataTable({
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
             "data": "cantidadUniformeSup"
         },
         {   
             "data": "codigoUniforme"
         }, 
         {   
             "data": "descUniforme"
         },
        ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 }