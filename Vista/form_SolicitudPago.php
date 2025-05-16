<?php
if ($usuario["rol"] == "Comprobacion Regional" || $usuario["rol"] == "Finanzas") {
    $catalogoLineadeNegocio = $negocio->negocio_obtenerListaLineaNegocio(); 
      $fechaActual= $negocio ->negocio_consultaFecha();  
}
?>
<div id="msgerrortblsolicitudpago" id="msgerrortblsolicitudpago"> </div>
  <center><h3>Solicitudes De Pagos</h3><h5 style="" id="tituloSolicitudPago"></center>
    <section>
    <div id="muestratablaSolicitudPago" style="display:none; max-width: 110rem;">
      <table id="tablaSolicitudPago"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #85CFE9">Estatus </th>
            <th style="text-align: center;background-color: #85CFE9">Linea De Negocio </th>
            <th style="text-align: center;background-color: #85CFE9">Fecha</th>
            <th style="text-align: center;background-color: #85CFE9">N° De Empleado</th>
            <th style="text-align: center;background-color: #85CFE9">Beneficiario</th>
            <th style="text-align: center;background-color: #85CFE9">Entidad</th>
            <th style="text-align: center;background-color: #85CFE9">Concepto</th>
            <th style="text-align: center;background-color: #85CFE9">Total</th>
            <th style="text-align: center;background-color: #85CFE9">Autorizar</th>
            <th style="text-align: center;background-color: #85CFE9">Declinar</th>
            <th style="text-align: center;background-color: #85CFE9">Cancelar</th>
        </thead>
        <tbody>
      </table>
    </div>
  </section> 
 <script type="text/javascript">
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioActSPS());  

function inicioActSPS(){

}
 
$(document).ready(function(){
  buscarSolicitudesDePagos();
});

function buscarSolicitudesDePagos() {
    tableSolicitudesDePago = [];
    $.ajax({
      type: "POST",
      url: "ajax_consultartablasolicitudesdepago.php",
      data:{},
      dataType: "json",
      success: function(response) {
        if (response.status == "success"){
          $("#muestratablaSolicitudPago").show();
          for(var i = 0; i < response.datos.length; i++){
              var record = response.datos[i];
              tableSolicitudesDePago.push(record);
          }
          loadDataInTablesolicitudpago(tableSolicitudesDePago);
        } 
        else{
             var mensaje = response.message;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }

 var tablesolicitudpago = null;

 function loadDataInTablesolicitudpago(data){
 
    if(tablesolicitudpago != null){
       tablesolicitudpago.destroy();
    }
    
    tablesolicitudpago = $('#tablaSolicitudPago').DataTable({
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
             "data": "estatusdescripcion"
         },{
             "data": "lineanegocio"
         },{"className": "dt-body-center",
             "data": "fechasolicitud"
         },{"className": "dt-body-center",
             "data": "numeroempleado"
         },{
             "data": "beneficiario"
         },{
             "data": "entidad"
         },{
             "data": "concepto"
         },{"className": "dt-body-right",
             "data": "total"
         },{"className": "dt-body-center",
             "data": "autorizado"
         },{"className": "dt-body-center",
             "data": "declinado"
         },{"className": "dt-body-center",
             "data": "cancelado"
         }, ],
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     }); 
 }

function cargaerroresgastocosto(obj,mensaje){
    var Msgerror = "<div id='msgerrortblsolicitudpago' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrortblsolicitudpago").html(Msgerror);
    $("#"+obj).css('border', '#D0021B 1px solid');
}

function limpiaerroresgastocosto(){
    $("#msgerrortblsolicitudpago").html("");
}
</script>