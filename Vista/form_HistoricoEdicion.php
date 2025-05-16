<div align="center"><b><h1>HISTORICO EDICIONES</h1></b></div>
<br>
<div id='MensajeHistoricoEdit' ></div>
<form class="form-inline"  method="post" id="form_HistoricoEdiciones"  target="_blank" enctype='multipart/form-data'>
<!-----------------------comienza fila 1 y el formulario --------------------------------------------------->  
<div align="center">
    <button id="CargarActualizar" name="CargarActualizar" class="btn btn-primary" title="Cargar O Actualizar Tabla" type="button" onclick="insertarhistorioco();">
    <span ></span>Cargar/Actualizar</button>
</div>
  <div align="center" ><br>
   
      <div id="muestratablahistorico" style="display:none">
      <div style="text-align: left"> &nbsp<button  type="button" class="btn btn-default" onclick="downloadexcelHistoricoEdicion();">Excel</button></div>
      <table id="tablahistoricoedit"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #85CFE9">N° EMPLEADO</th>
            <th style="text-align: center;background-color: #85CFE9">FECHA EDICIÓN</th>
             <th style="text-align: center;background-color: #85CFE9">FECHA CONFIRMACIÓN</th>
            <th style="text-align: center;background-color: #85CFE9">N° CUENTA</th>
            <th style="text-align: center;background-color: #85CFE9">N° CUENTA ACTUAL</th>
            <th style="text-align: center;background-color: #85CFE9">N° CUENTA CLABE</th>
            <th style="text-align: center;background-color: #85CFE9">N° CUENTA CLABE ACTUAL</th>
            <th style="text-align: center;background-color: #85CFE9">BANCO</th>
            <th style="text-align: center;background-color: #85CFE9">CORREO</th>
            <th style="text-align: center;background-color: #85CFE9">PERIODO</th>
            <th style="text-align: center;background-color: #85CFE9">FECHA BAJA</th>
            <th style="text-align: center;background-color: #85CFE9">FECHA DE REINGRESO</th>
            <th style="text-align: center;background-color: #85CFE9">REVISADO</th>

          </tr>
        </thead>
        <tbody>
      </table>
    </div>
    

  </div>
</form>
<script type="text/javascript">
  
  function insertarhistorioco(){
    tablainserthistorico= [];
           $.ajax({
               type: "POST",
               url: "ajax_inserthistorico.php",
               data:{},
               dataType: "json",
               success: function(response) {
                //console.log(response);
                   if (response.status == "success") {
                      $("#muestratablahistorico").show();
                       for (var i = 0; i < response.datos.length; i++) {
                           var record = response.datos[i];
                           tablainserthistorico.push(record);
                          // console.log(record);
                       }
                       cargartablahistorico(tablainserthistorico);
                   } else {
                       var mensaje = response.message;
                       //console.log("mal");
                   }
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   alert(jqXHR.responseText);
               }
           });

  }
     

 var tablehistorico = null;
 function cargartablahistorico(data) {
     if (tablehistorico != null) {
         tablehistorico.destroy();
     }
     tablehistorico = $('#tablahistoricoedit').DataTable({
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
         "columns": [{
             "data": "numempleado"
         }, {
             "data": "fecha"
         },
 {
             "data": "fechaconfirmacion"
         },

         {
             "data": "numcuenta"
         },
         {
             "data": "numcuentaActual"
         },{
             "data": "numcuentaclabe"
         },{
             "data": "numcuentaclabeActual"
         },{
             "data": "banco"
         },{
             "data": "correo"
         },{
             "data": "periodo"
         },{
             "data": "fechabaja"
         },{
             "data": "fechareingreso"
         },{
             "data": "check"
         },],
         // ]

          processing: true,
         dom: 'Bfrtip',
         buttons: []
        
     });
     
 }

 function datochecado(idEdicion){
  $.ajax({

               type: "POST",
               url: "ajax_updatehistoricoEdiciones.php",
               data:{"idEdicion":idEdicion},
               dataType: "json",
               success: function(response) {
                //console.log(response);
                   if (response.status == "success") {
                     insertarhistorioco();
                   } else {
                       var mensaje = response.message;
                       //console.log("mal");
                   }
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   alert(jqXHR.responseText);
               }
           });
 }

 function downloadexcelHistoricoEdicion() {
    window.open("downloadexcelhistoricoedicion.php",'width=600,height=600,scrollbars=no'); 
}

/* function cargaerroresfrmcobroentidad(obj,mensaje){
   var Msgerror = "<div id='msgerrortblcobroentidades' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#msgerrortblcobroentidades").html(Msgerror);
          $("#"+obj).css('border', '#D0021B 1px solid');
 }*/

</script>