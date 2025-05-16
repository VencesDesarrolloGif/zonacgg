<div id="mensajeerrorAdeudosEmpleados"></div>
<center><h3>CARGAR A CUENTAS DEUDORES</h3></center>
<br>
  <center>
    <span class="add-on">Inicio:</span>
    <input class="input-medium" id="FechaInicioAdeudo" name="FechaInicioAdeudo" type="date">
    <span class="add-on">Termino:</span>
    <input class="input-medium" id="FechaFinAdeudo" name="FechaFinAdeudo" type="date">
    &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="consultaAdeudosEmpleados();">Buscar</button>  
   <!-- <div id="btnexcel" style="display:none">
      <div  style="text-align: left;"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
    </div>-->
  </center>

<section>
    <table id="tablaAdeudosEmpleados" style="display: none;" width="100%" >
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Reingreso</th>
                <th style="text-align: center;background-color: #B0E76E">Linea Negocio</th>
                <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad A Trabajar</th>                 
                <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>                                
                <th style="text-align: center;background-color: #B0E76E">Deuda</th>
                <th style="text-align: center;background-color: #B0E76E">Archivo</th>      
            </tr>
        </thead>        
    </table>
</section>
<script type="text/javascript"> 

 function consultaAdeudosEmpleados() { //finiquitos calculados con piramidar

    var FechaInicioAdeudo = $("#FechaInicioAdeudo").val();
    var FechaFinAdeudo = $("#FechaFinAdeudo").val();
    var Caso = "1";

    if(FechaInicioAdeudo==""){
        mensajeerroraduedosempleados("ingrese Una Fecha De Inicio");
    }else if(FechaFinAdeudo==""){
        mensajeerroraduedosempleados("ingrese Una Fecha De Termino");
    }else if(FechaInicioAdeudo>FechaFinAdeudo){
        mensajeerroraduedosempleados("La Fecha De Inicio NO Puede Ser Mayor A La Fecha De Termino");
    }else{
        tableHistoricoAdeudos = [];
        $.ajax({
            type: "POST",
            url: "ajax_AdeudosEmpleados.php",
            data:{"FechaInicioAdeudo":FechaInicioAdeudo,"FechaFinAdeudo":FechaFinAdeudo,"Caso":Caso},
            dataType: "json",
            async:false, 
            success: function(response) {
                if (response.status == "success") {
                    for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        tableHistoricoAdeudos.push(record);
                    }
                    loadDataInHistoricoAdeudos(tableHistoricoAdeudos);
                    $("#tablaAdeudosEmpleados").show();
                } else {
                    var mensaje = response.message;
                    mensajeerroraduedosempleados(mensaje);
                    $("#tablaAdeudosEmpleados").hide();

                    
                 }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }
 }
 var tableHistoricoAdeudos1 = null;

 function loadDataInHistoricoAdeudos(data) {
     if (tableHistoricoAdeudos1 != null) {
         tableHistoricoAdeudos1.destroy();
     }
     tableHistoricoAdeudos1 = $('#tablaAdeudosEmpleados').DataTable({
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
             "data": "fechaReingreso"
         }, 
         {   
             "data": "LineaNegocio"
         }, 
         { 
             "data": "PuestoEmpleado"
         },
         {   
             "data": "EntidadEmpleado"
         }, 
         {   
             "data": "RolOperativo"
         }, 
         {   "className": "dt-body-right",
             "data": "DeudaEmpleado1" 
         }, 
         {   
             "data": "rutarachivo"
         },  ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }

 function abrirarchivoAdeudosEmpleados(NombreArchivo,NumeroEmpleado,IdEmpleado){
      window.open("uploads/DocumentosPagoDeudaReingreso/"+NumeroEmpleado +"/"+NombreArchivo, 'fullscreen=no',"scrollbars=no");

      $.ajax({
            type: "POST",
            url: "ajax_UpdateAdeudosEmpleados.php",
            data:{"IdEmpleado":IdEmpleado},
            dataType: "json",
            async:false, 
            success: function(response) {
                if (response.status == "success") {
                    consultaAdeudosEmpleados();
                } else {
                    var mensaje = response.message;
                    mensajeerroraduedosempleados(mensaje);
                    $("#tablaAdeudosEmpleados").hide();

                    
                 }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });


    }

    function mensajeerroraduedosempleados(mensaje){
        $("#mensajeerrorAdeudosEmpleados").fadeIn();
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#mensajeerrorAdeudosEmpleados").html(alertMsg1); 
        $("#mensajeerrorAdeudosEmpleados").delay('3000').fadeOut('slow');
        $("#tablaAdeudosEmpleados").hide();
        $("#tablaAdeudosEmpleados").html("");


    }






 </script>