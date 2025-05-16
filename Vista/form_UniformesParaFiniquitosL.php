<center><h3>Historico Uniformes Recibidos (Para Finiquito)</h3></center>
<br>
<center>
    <img title='Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaUniformesParaDescuentoFiniquito();" width="50px">
</center>
<br>
<section>
    <table id="tablaUniParaFiniquitos"  width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Descripción Uniforme</th>
                <th style="text-align: center;background-color: #B0E76E">Costo Uniforme</th>
                <th style="text-align: center;background-color: #B0E76E">Porcentaje Cobrado %</th>             
                <th style="text-align: center;background-color: #B0E76E">Monto Cobrado (Uniforme)</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Recepción</th>       
                <th style="text-align: center;background-color: #B0E76E">Tipo Movimiento</th>        
            </tr>
        </thead>        
    </table>
</section>
<script type="text/javascript"> 

 function ConsultaUniformesParaDescuentoFiniquito() { //finiquitos calculados con piramidar
     tableHistoricoUniformesFin = [];
     $("#tablaUniParaFiniquitos").show();
     $.ajax({
         type: "POST",
         url: "ajax_ConsultaUniformeRecibidosParaFiniquito.php",
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") { 
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tableHistoricoUniformesFin.push(record);
                 }
                 loadDataInTableHistoricoUnifin(tableHistoricoUniformesFin);
             }else {
                 var mensaje = response.message;
                 console.log(mensaje);
              }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tableHistoricoUniformesRecFin = null;

 function loadDataInTableHistoricoUnifin(data) {
     if (tableHistoricoUniformesRecFin != null) {
         tableHistoricoUniformesRecFin.destroy();
     }
     tableHistoricoUniformesRecFin = $('#tablaUniParaFiniquitos').DataTable({
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
             "data": "nombreHA"
         }, 
         {   
             "data": "descripcionUnif"
         },
         {   
             "data": "CostoUniforme"
         },
         {   
             "data": "porciento"
         },         
         {   "className": "dt-body-right",
             "data": "montoDeudaHA" 
         }, 
         {   
             "data": "fechaRecibidoHis"
         }, 
         {   
             "data": "DescripcionEstatusUni"
         },   
          ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }
 </script>