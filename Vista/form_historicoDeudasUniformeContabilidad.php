<center><h3>Historico Deudas Pagadas</h3></center>
<br>
<img id="btnActualizarPagosUnif" src="img\Actualizar1.JPG" onclick="consultaDeudasPagadas();" style="width: 2%;" title="Actualizar">
<section>
    <table id="tablaHistoricoPagos"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Uniforme</th>
                <th style="text-align: center;background-color: #B0E76E">cantidad</th>
                <th style="text-align: center;background-color: #B0E76E">Usuario Asignación</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad Asignación</th>                 
                <th style="text-align: center;background-color: #B0E76E">Fecha Asignación</th>       
                <th style="text-align: center;background-color: #B0E76E">importe</th>
                <th style="text-align: center;background-color: #B0E76E">Papeleta Deuda</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha de Pago</th>
                       
            </tr>
        </thead>
        
    </table>
</section>
<script type="text/javascript"> 

$(inicioHistDeudasUnif());  

function inicioHistDeudasUnif(){
     consultaDeudasPagadas();
}

 function consultaDeudasPagadas() { 

  tablePagos = [];
  $.ajax({
          type: "POST",
          url: "ajax_consultaDeudasPagadasUniformesByConta.php",
          dataType: "json", 
          success: function(response){
              if(response.status == "success") {
                  for(var i = 0; i < response.datos.length; i++){
                    var entidadEmpDeudaU = response.datos[i]["entidadEmpDeudaU"];
                    var consecutivoEmpDeudaU= response.datos[i]["consecutivoEmpDeudaU"];
                    var categoriaEmpDeudaU= response.datos[i]["categoriaEmpDeudaU"];
                    var idDeudaUni= response.datos[i]["idDeudaUni"];
response.datos[i]["Papeleta"]="<img style='width: 24%' title='Papeleta' src='img/hojaDatos.png' class='cursorImg' id='btnPapeleta' onclick=GenerarPapeletaDeudaAsignacion('"+entidadEmpDeudaU+"','"+consecutivoEmpDeudaU+"','"+categoriaEmpDeudaU+"','"+idDeudaUni+"')>"; 
                       var record = response.datos[i];
                       tablePagos.push(record);
                     }
                loadDataInTablePagosUnif(tablePagos);
               }else{
                     var mensaje = response.message;
                     console.log("mal");
                    }
             },
          error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
  });
 }

 var tablePagosUnifbyCont = null;

 function loadDataInTablePagosUnif(data) {
     if (tablePagosUnifbyCont != null) {
         tablePagosUnifbyCont.destroy();
     }
     tablePagosUnifbyCont = $('#tablaHistoricoPagos').DataTable({
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
         {   "className": "dt-body-center",
             "data": "numeroEmpDeuda"
         }, 
         {   
             "data": "nombreEmpDeuda"
         }, 
         {   "className": "dt-body-center",
             "data": "descripcionTipo"
         }, 
         {   "className": "dt-body-center",
             "data": "cantidadUnifDeuda"
         }, 
         {   "className": "dt-body-center",
             "data": "usuarioAsigDeuda" 
         }, 
         {   "className": "dt-body-center",
             "data": "nombreEntidadFederativa"
         },
         {   "className": "dt-body-center",
             "data": "FechaAsigUnifD"
         },
         {   "className": "dt-body-center",
             "data": "montoDeuda"
         },
         {   "className": "dt-body-center",
             "data": "Papeleta"
         },
         {   "className": "dt-body-center",
             "data": "estatusDeuda"
         },
         {   "className": "dt-body-center",
             "data": "FechaPagoUnifD"
         }, ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }
  
 </script>