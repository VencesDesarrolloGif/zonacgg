  function ConsultaElementosVetadosEmp(){ 
    waitingDialog.show();
    elementosVetados = [];
    $.ajax({ 
        type: "POST",
        url: "HistoricoVetoElementos/ajax_ConsultaElementosVetadosHistorico.php",
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    elementosVetados.push(record);
                }
                loadDataIntableElementosVetados(elementosVetados);
                waitingDialog.hide();
                $("#tablaHistoricoVeto").show();
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
 var tablaDeHistoricoVetados = null;

 function loadDataIntableElementosVetados(data) {
    if(tablaDeHistoricoVetados != null) {
        tablaDeHistoricoVetados.destroy();
    }
    tablaDeHistoricoVetados = $('#tablaHistoricoVeto').DataTable({
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
             "data": "MotivoVeto"
         },
         {   
             "data": "procedencia"
         },
         {   
             "data": "Archivo"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 } 
function abrirPdfVetado(RutaArchivo,Extencion){
    window.open("uploads/ArchivosElementosVetados/"+RutaArchivo+"");
}