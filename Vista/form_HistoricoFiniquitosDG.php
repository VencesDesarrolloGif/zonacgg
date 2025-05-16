<center><h3>Historico Acuerdos Separaciones Laborales</h3></center>
<br>
<section>
    <table id="tablaHistoricoDG"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                <th style="text-align: center;background-color: #B0E76E">Finiquito Acordado</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Acción</th> 
                       
            </tr>
        </thead>
        
    </table>
</section>
<script type="text/javascript"> 

$(inicioHistoricoFiniquitosDG());  

function inicioHistoricoFiniquitosDG(){
     consultaHistoricoFiniquitosDG();
}

 function consultaHistoricoFiniquitosDG() { 
     tablehistoricofiniquitosDG = [];
     $.ajax({
         type: "POST",
         url: "ajax_consultaHistoricoFiniquitoDG.php",
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablehistoricofiniquitosDG.push(record);
                 }
                 loadDataInTableHistoricoFiniquitosDG(tablehistoricofiniquitosDG);
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

 function loadDataInTableHistoricoFiniquitosDG(data) {
     if (tableHisFinDG != null) {
         tableHisFinDG.destroy();
     }
     tableHisFinDG = $('#tablaHistoricoDG').DataTable({
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
             "data": "numempleado"
         }, 
         {   
             "data": "nombreempleado"
         }, 
         {   
             "data": "descripcionPuesto"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         }, 
         {   "className": "dt-body-right",
             "data": "FiniquitoAcordado" 
         }, 
         {  
             "data": "Estatus"
         },  
         {   
             "data": "FechaAcción"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }
  
 </script>