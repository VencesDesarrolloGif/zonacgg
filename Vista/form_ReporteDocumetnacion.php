<div id="mensajeerrorDocumenosEmpleados"></div>
<center><h3>REPORTE DOCUMENTOS EMPLEADOS POR FECHAS</h3></center>
<br>
  <center>
    <span class="add-on">Inicio:</span>
    <input class="input-medium" id="FechaInicioDoc" name="FechaInicioDoc" type="date">
    <span class="add-on">Termino:</span>
    <input class="input-medium" id="FechaFinDoc" name="FechaFinDoc" type="date">
    &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="consultaDocumentosEmpleados();">Buscar</button>  
   <!-- <div id="btnexcel" style="display:none">
      <div  style="text-align: left;"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
    </div>-->
  </center>

<section>
    <table id="tablaDocumentosTotalesEmpleados" style="display: none;" width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Documento</th>
                <th style="text-align: center;background-color: #B0E76E">Tipo Documento</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus Documento</th>                 
            </tr>
        </thead>        
    </table>
</section>
<script type="text/javascript"> 

 function consultaDocumentosEmpleados() { //finiquitos calculados con piramidar

    var FechaInicioDoc = $("#FechaInicioDoc").val();
    var FechaFinDoc = $("#FechaFinDoc").val();
    var Caso = "1";

    if(FechaInicioDoc==""){
        mensajeerrorDocumentosEmpleados("ingrese Una Fecha De Inicio");
    }else if(FechaFinDoc==""){
        mensajeerrorDocumentosEmpleados("ingrese Una Fecha De Termino");
    }else if(FechaInicioDoc>FechaFinDoc){
        mensajeerrorDocumentosEmpleados("La Fecha De Inicio NO Puede Ser Mayor A La Fecha De Termino");
    }else{
        reporteDocumentos = [];
        $.ajax({
            type: "POST",
            url: "ajax_ReporteDocumentacion.php",
            data:{"FechaInicioDoc":FechaInicioDoc,"FechaFinDoc":FechaFinDoc},
            dataType: "json",
            async:false, 
            success: function(response) {
                if (response.status == "success") {
                    for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        reporteDocumentos.push(record);
                    }
                    loadDataInReporteDocumentos(reporteDocumentos);
                    $("#tablaDocumentosTotalesEmpleados").show();
                } else {
                    var mensaje = response.message;
                    mensajeerrorDocumentosEmpleados(mensaje);
                    $("#tablaDocumentosTotalesEmpleados").hide();

                    
                 }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText); 
            }
        });
    }
 }
 var tableReporteDocumentos = null;

 function loadDataInReporteDocumentos(data) {
     if (tableReporteDocumentos != null) {
         tableReporteDocumentos.destroy();
     }
     tableReporteDocumentos = $('#tablaDocumentosTotalesEmpleados').DataTable({
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
             "data": "EstatusEmpleado"
         }, 
         {   
             "data": "NombreDocumento"
         }, 
         { 
             "data": "TipoDocumetno"
         },
         {   
             "data": "EstatusDocumento"
         },  ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel','pdf']
    }
         
     });
 }
function mensajeerrorDocumentosEmpleados(mensaje){
    $("#mensajeerrorDocumenosEmpleados").fadeIn();
    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#mensajeerrorDocumenosEmpleados").html(alertMsg1); 
    $("#mensajeerrorDocumenosEmpleados").delay('3000').fadeOut('slow');
    $("#tablaDocumentosTotalesEmpleados").hide();
    $("#tablaDocumentosTotalesEmpleados").html("");
}






 </script>