<div id='msmPeticionesComplementos' name='msmPeticionesComplementos' ></div> 
<center><h3>CONFIRMACIÓN PAGO DE COMPLEMENTOS FINIQUITOS</h3>
<br>
<img title='Obtener pago de complementos finiquitos' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="ConsultaConfirmacionComplementosFiniquitos();" width="50px"></center>
<br>
<section>
    <table id="tablaConfimacionPagoComplementos"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                <th style="text-align: center;background-color: #B0E76E">Monto Finiquito(Pagado)</th>
                <th style="text-align: center;background-color: #B0E76E">Monto Solicitado</th>
                <th style="text-align: center;background-color: #B0E76E">Acción</th> 
            </tr>
        </thead>
   </table>
</section>
<script type="text/javascript"> 

// $(ConsultaConfirmacionComplementosFiniquitos());  

 function ConsultaConfirmacionComplementosFiniquitos(){ 
    waitingDialog.show();
     tablaComplementosAConfirmar = [];
     $.ajax({
         type: "POST",
         url: "ajax_ConsultaFiniquitosConComplementoAPagar.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaComplementosAConfirmar.push(record);
                 }
                 loadDataIntableCompFiniquitosConf(tablaComplementosAConfirmar);
                 $("#tablaConfimacionPagoComplementos").show();
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
 var tablaConfirmacionComplementosF = null;

 function loadDataIntableCompFiniquitosConf(data) {
     if (tablaConfirmacionComplementosF != null) {
         tablaConfirmacionComplementosF.destroy();
     }
     tablaConfirmacionComplementosF = $('#tablaConfimacionPagoComplementos').DataTable({
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
             "data": "netoAlPago"
         }, 
         {   "className": "dt-body-right",
             "data": "CantidadComplemento"
         }, 
         {   "className": "dt-body-center",
             "data": "Accion"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 } 

function ConfirmarComplementoPagodo(numempleado,folioBaja,CantidadComplemento){
   
    $.ajax({
        type: "POST",
        url: "ajax_ConfirmarComplementoPagado.php",
        data:{"numempleado":numempleado,"folioBaja":folioBaja,"CantidadComplemento":CantidadComplemento},
        dataType: "json",
        success: function(response) {
            var mensajeconfirmacionpago = "Confirmación Del Pago Registrada Exitosamente !!";
            var Estatus = "success";

            $('#msmPeticionesComplementos').fadeIn('slow');
            alerterror="<div class='alert alert-"+Estatus+"' id='msmPeticionesComplementos'>"+mensajeconfirmacionpago+"<data-dismiss='alert'>";
            $("#msmPeticionesComplementos").html(alerterror);
            $('#msmPeticionesComplementos').delay(3000).fadeOut('slow');
            ConsultaConfirmacionComplementosFiniquitos();

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      }); 
}


</script>