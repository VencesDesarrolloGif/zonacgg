<center><h3>SOLICITUD DE UNIFORMES</h3></center>
<br>
<div id="msjErrorSolUniforme"></div>
<div id="DivTablaSolUniforme">
    <table id="tablaSolUniforme"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Punto De Servicio</th> 
                <th style="text-align: center;background-color: #B0E76E">Turno</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de Ingreso</th> 
                <th style="text-align: center;background-color: #B0E76E">Uniforme</th> 
                <th style="text-align: center;background-color: #B0E76E">Cantidad</th> 
                <th style="text-align: center;background-color: #B0E76E">Talla Camisa</th> 
                <th style="text-align: center;background-color: #B0E76E">Talla Pantalon</th> 
                <th style="text-align: center;background-color: #B0E76E">Talla Calzado</th> 
                <th style="text-align: center;background-color: #B0E76E">Confirmar</th> 
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript"> 
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioSolUnif());  

function inicioSolUnif(){
  consultarSolicitudUniforme();
}

 function consultarSolicitudUniforme() { 
     tablesolicitudUni = [];
     $.ajax({
         type: "POST",
         url: "ajax_SolicitudUniforme.php",
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var DatosTabla = response.datos[i];

                     tablesolicitudUni.push(DatosTabla);
                 }
                 loadDataInTableSolicitudDeUniformes(tablesolicitudUni);
             } else {
                 var mensaje = response.message;
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 var tblaSolUni = null;

 function loadDataInTableSolicitudDeUniformes(data) {
     if (tblaSolUni != null) {
         tblaSolUni.destroy();
     }
     tblaSolUni = $('#tablaSolUniforme').DataTable({
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
             "data": "NombrEmpleado"
         }, 
         {
             "data": "Servicio"
         }, 
         {
             "data": "Turno"
         },
         {
             "data": "FechaIngreso"
         }, 
         {   
             "data": "Uniforme"
         }, 
         { 
             "data": "Cantidadem" 
         }, 
         {
             "data": "TallaCamisa"
         },  
         {   
             "data": "TallaPantalon"
         },
         {
             "data": "TallaCalzado"
         },
         {   "className": "dt-body-center",
             "data": "AcciónYaAsignado"
         }, ],
         processing: true,
         dom: 'Bfrtip',
         buttons:{
                  buttons: ['excel']
                 }
     });
 }

 function confirmarSolicitudManual(idSolicitudUniforme){

    $.ajax({
         type: "POST",
         url: "ajax_ConfirmarSolicitudUniformes.php",
         data:{idSolicitudUniforme},
         dataType: "json", 
         success: function(response) {
             if (response.status == "success") {
                  consultarSolicitudUniforme();
                  var mensaje="Confirmado con Éxito";
                  cargarmensajeSolicitudAlmacen(mensaje,"success");

             } else {
                var mensaje="Error al confirmar";
                  cargarmensajeSolicitudAlmacen(mensaje,"error");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 
 function cargarmensajeSolicitudAlmacen(mensaje,tipo){
  $('#msjErrorSolUniforme').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+tipo+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#msjErrorSolUniforme").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#msjErrorSolUniforme').delay(3000).fadeOut('slow');

} 
 </script>