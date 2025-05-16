<center><h3>HISTORICO MOVIMIENTOS COMPLEMENTOS DE FINIQUITOS</h3>
<br>
<img title='Obtener historico movimientos de complementos de finiquitos' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaMovientoDeComplementos();" width="50px"></center>
<br>
<section>
    <table id="tablaMovimientosComplementos"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                <th style="text-align: center;background-color: #B0E76E">Monto Solicitado</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Movimiento</th> 
                <th style="text-align: center;background-color: #B0E76E">Estatus Movimiento</th> 
            </tr>
        </thead>
   </table>
</section>
<script type="text/javascript"> 

// $(inicioHistComp());  

// function inicioHistComp(){
//  ConsultaMovientoDeComplementos();
// }
 function ConsultaMovientoDeComplementos(){  
    waitingDialog.show();
     tablaMovimientoComplemento = [];
     $.ajax({
         type: "POST",
         url: "ajax_ConsultaMovimientoComplementos.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaMovimientoComplemento.push(record);
                 }
                 $("#tablaMovimientosComplementos").show();
                 loadDataIntableMovComplemento(tablaMovimientoComplemento);
                 waitingDialog.hide();
             } else {
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
 var tablaMovimientoCOmp = null;

 function loadDataIntableMovComplemento(data) {
     if (tablaMovimientoCOmp != null) {
         tablaMovimientoCOmp.destroy();
     }
     tablaMovimientoCOmp = $('#tablaMovimientosComplementos').DataTable({
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
             "data": "numeroEmpleado"
         }, 
         {   
             "data": "nombreEmpleado"
         }, 
         {   
             "data": "descripcionPuesto"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         }, 
         {   "className": "dt-body-right",
             "data": "MontoSolicitado"
         },
         {   
             "data": "FechaMovimiento"
         },  
         {   "className": "dt-body-center",
             "data": "Estatus"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 } 



</script>