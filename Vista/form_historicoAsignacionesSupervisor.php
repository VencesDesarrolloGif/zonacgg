<center><h3>Historico Asignaciones</h3></center>
<br>
<section>
    <table id="tablaHistoricoAsigXSup"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Asignación</th>       
                <th style="text-align: center;background-color: #B0E76E">Uniforme</th>
                <th style="text-align: center;background-color: #B0E76E">Talla</th>
                <th style="text-align: center;background-color: #B0E76E">Cantidad</th>
            </tr>
        </thead>
        
    </table>
</section>
<script type="text/javascript"> 

$(inicioHistAsigSup());  

function inicioHistAsigSup(){
 consultaHistoricoAsigXsip();
}


 function consultaHistoricoAsigXsip() { 
     tablehistoricoAsigSup = [];
     $.ajax({
         type: "POST",
         url: "ajax_AsignacionesUniformeXSup.php",
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablehistoricoAsigSup.push(record);
                 }
                 loadDataInTableHistoricoAsigXsup(tablehistoricoAsigSup);
             } else {
                 var mensaje = response.message;
                // console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableHisFinDG = null;

 function loadDataInTableHistoricoAsigXsup(data) {
     if (tableHisFinDG != null) {
         tableHisFinDG.destroy();
     }
     tableHisFinDG = $('#tablaHistoricoAsigXSup').DataTable({
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
         {   "className": "dt-body-center",
             "data": "numeroGuardia"
         }, 
         {   "className": "dt-body-center",
             "data": "nombreHA"
         }, 
         {   "className": "dt-body-center",
             "data": "fechaAsignacionHis"
         }, 
         {   "className": "dt-body-center",
             "data": "descripcionUnif"
         }, 
         {   "className": "dt-body-center",
             "data": "tallaUniforme" 
         },
         {   "className": "dt-body-center",
             "data": "cantidadUniformeHis" 
         },],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }
  
 </script>