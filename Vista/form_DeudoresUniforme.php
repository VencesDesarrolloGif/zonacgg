<center><h3>Deudores de uniforme</h3></center>
<br>
<div id="divMensajeDeudasUnif"></div>   
<section>
    <table id="tablaDeudoresUnif"  width="100%" class="records_list table table-striped table-bordered table-hover" cellspacing="0">
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
                <th style="text-align: center;background-color: #B0E76E">Confirmar Pago</th>
            </tr>
        </thead>        
    </table>
</section>
<script type="text/javascript"> 

$(consultaDeudoresUnif());  

function GenerarPapeletaDeudaAsignacion(entidadEmpDeudaU,consecutivoEmpDeudaU,categoriaEmpDeudaU,idDeudaUni){
window.open("ajax_cargaPapeletaDeuda.php?&entidadEmpDeudaU=" + entidadEmpDeudaU + "&consecutivoEmpDeudaU=" + consecutivoEmpDeudaU + "&categoriaEmpDeudaU=" + categoriaEmpDeudaU + "&idDeudaUni=" + idDeudaUni,'fullscreen=no');
}

function consultaDeudoresUnif() { 

  tableDeudas = [];
  $.ajax({
          type: "POST",
          url: "ajax_ConsultaDeudasUniformesAsignados.php",
          dataType: "json", 
          success: function(response){
              if(response.status == "success") {
                  for(var i = 0; i < response.datos.length; i++){
                    var entidadEmpDeudaU = response.datos[i]["entidadEmpDeudaU"];
                    var consecutivoEmpDeudaU= response.datos[i]["consecutivoEmpDeudaU"];
                    var categoriaEmpDeudaU= response.datos[i]["categoriaEmpDeudaU"];
                    var idDeudaUni= response.datos[i]["idDeudaUni"];
response.datos[i]["Papeleta"]="<img style='width: 24%' title='Papeleta' src='img/hojaDatos.png' class='cursorImg' id='btnPapeleta' onclick=GenerarPapeletaDeudaAsignacion('"+entidadEmpDeudaU+"','"+consecutivoEmpDeudaU+"','"+categoriaEmpDeudaU+"','"+idDeudaUni+"')>"; 

response.datos[i]["Pagado"]="<img style='width: 24%' title='Confirmar Pago de la deuda' src='img/confirmarImss.png' class='cursorImg' id='btnPagado' onclick=aceptarPago('"+entidadEmpDeudaU+"','"+consecutivoEmpDeudaU+"','"+categoriaEmpDeudaU+"','"+idDeudaUni+"')>";  

                       var record = response.datos[i];
                       tableDeudas.push(record);
                     }
                loadDataInTableHistoricoALl(tableDeudas);
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

 var tableDeudasUniformes = null;

 function loadDataInTableHistoricoALl(data) {
     if (tableDeudasUniformes != null) {
         tableDeudasUniformes.destroy();
     }
     tableDeudasUniformes = $('#tablaDeudoresUnif').DataTable({
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
             "data": "Pagado"
         }, ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: []
    }
         
     });
 }
 
 function aceptarPago(entidadEmpDeudaU,consecutivoEmpDeudaU,categoriaEmpDeudaU,idDeudaUni){
    
        $.ajax({
          type: "POST",
          url: "ajax_ActualizarDeudaUniforme.php",
          data:{entidadEmpDeudaU,consecutivoEmpDeudaU,categoriaEmpDeudaU,idDeudaUni},
          dataType: "json",
           success: function(response) {
              if(response.status == "success"){
                var mansaje="Aceptado con Éxito";
                cargarmensajeerrorDesudaUniformes(mansaje,response.status);
                consultaDeudoresUnif();
                }else{
                      var mansaje="Ocurrio un error";
                      cargarmensajeerrorDesudaUniformes(mansaje,response.status);
                     }
           },
           error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
                 waitingDialog.hide();
          }
      });
    }

function cargarmensajeerrorDesudaUniformes(mensaje,tipo){
  $('#divMensajeDeudasUnif').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+tipo+"'><strong></strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeDeudasUnif").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeDeudasUnif').delay(3000).fadeOut('slow');
}
 </script>