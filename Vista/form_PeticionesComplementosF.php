<div id='msmPeticionesComplementos' name='msmPeticionesComplementos' ></div>
<center><h3>PETICIONES COMPLEMENTOS FINIQUITOS</h3></center>
<br>
<img style='width: 2%' title='Actualizar Modulo' src='img/Actualizar1.jpg' class='cursorImg' onclick='ConsultaComplementosFiniquitos();'>
<section>
    <table id="tablaComplementosFiniquitosSol"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>       
                <th style="text-align: center;background-color: #B0E76E">Monto Finiquito(Pagado)</th>
                <th style="text-align: center;background-color: #B0E76E">Monto Solicitado</th>
                <th style="text-align: center;background-color: #B0E76E">Aceptar</th> 
                <th style="text-align: center;background-color: #B0E76E">Declinar</th> 
            </tr>
        </thead>
   </table>
</section>
<script type="text/javascript"> 

$(inicioPetCpmF());  

function inicioPetCpmF(){
 ConsultaComplementosFiniquitos();
}

 function ConsultaComplementosFiniquitos(){ 
     tablaComplementos = [];
     $.ajax({
         type: "POST",
         url: "ajax_ConsultaFiniquitosConComplemento.php",
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaComplementos.push(record);
                 }
                 loadDataIntableCompFiniquitosSol(tablaComplementos);
             } else {
                 var mensaje = response.message;
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tablaSolictComplementosF = null;

 function loadDataIntableCompFiniquitosSol(data) {
     if (tablaSolictComplementosF != null) {
         tablaSolictComplementosF.destroy();
     }
     tablaSolictComplementosF = $('#tablaComplementosFiniquitosSol').DataTable({
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
             "data": "AceptarComplemento"
         },
         {   "className": "dt-body-center",
             "data": "DeclinarComplemento"
         }, ],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 } 

function AceptarDeclinarPeticion(numempleado,folioBaja,CantidadComplemento,opcion){
    $.ajax({
        type: "POST",
        url: "ajax_AceptarDeclinarSolicitudComplementoF.php",
        data:{"numempleado":numempleado,"folioBaja":folioBaja,"CantidadComplemento":CantidadComplemento,"opcion":opcion},
        dataType: "json",
        success: function(response) {
            if(opcion=="1"){
                var mensajeePeticionComplemento = "Solicitud Aceptada Correctamente";
                var Estatus = "success";
            }else{
                var mensajeePeticionComplemento = "Solicitud Rechazada Correctamente";
                var Estatus = "error";
            }
            $('#msmPeticionesComplementos').fadeIn('slow');
            alerterror="<div class='alert alert-"+Estatus+"' id='msmPeticionesComplementos'>"+mensajeePeticionComplemento+"<data-dismiss='alert'>";
            $("#msmPeticionesComplementos").html(alerterror);
            $('#msmPeticionesComplementos').delay(3000).fadeOut('slow');
            ConsultaComplementosFiniquitos();

        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      }); 
}


</script>