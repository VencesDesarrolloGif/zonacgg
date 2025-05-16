<center><h3>HISTORICO CUENTAS DEUDORES REVISADOS !!</h3></center>

<img title='Actualizar Pagina' src='img/Actualizar1.jpg' class='cursorImg' id='btnguardar' onclick="consultaAdeudosEmpleadosRevisado();" width="50px" align="center">
<section>
    <table id="tablaAdeudosEmpleadosRevisados" width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0">
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
            </tr>
        </thead>        
    </table>
</section>
<script type="text/javascript"> 

$(inicioHistAdeudosEmpRev());  

function inicioHistAdeudosEmpRev(){
  consultaAdeudosEmpleadosRevisado();
}

 function consultaAdeudosEmpleadosRevisado() { //finiquitos calculados con piramidar
    var Caso ="2";
    var FechaInicioAdeudo = "";
    var FechaFinAdeudo = "";
    tableHistoricoAdeudosrevisados = [];
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
                    tableHistoricoAdeudosrevisados.push(record);
                }
                loadDataInHistoricoAdeudosRevisado(tableHistoricoAdeudosrevisados);
            } else {
                var mensaje = response.message;                    
             }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}
 var tableHistoricoAdeudosRevisado1 = null;

 function loadDataInHistoricoAdeudosRevisado(data) {
     if (tableHistoricoAdeudosRevisado1 != null) {
         tableHistoricoAdeudosRevisado1.destroy();
     }
     tableHistoricoAdeudosRevisado1 = $('#tablaAdeudosEmpleadosRevisados').DataTable({
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
         },],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }

 </script>