<center> 
  <br>
   <div class="col-lg-12" style="font-size:50px;">Cobertura</div>
</center>
<br>

<center>
  <br>
  <div id="DivLineaNegocio">
    <select id="seleccionarLineNegocio" name="seleccionarLineNegocio"></select><br>
  </div>
  <div id="DivSeleccionarSup" style="display: none;">
    <select name="seleccionarSupervisor" id="seleccionarSupervisor"></select>   
  </div>

<select id="periodoConsultaSup" name="periodoSup" class="input-large" style="display: none;">
  <option value="0">PERIODO</option>
  <option value="1">ENERO</option>
  <option value="2">FEBRERO</option>
  <option value="3">MARZO</option>
  <option value="4">ABRIL</option>
  <option value="5">MAYO</option>
  <option value="6">JUNIO</option>
  <option value="7">JULIO</option>
  <option value="8">AGOSTO</option>
  <option value="9">SEPTIEMBRE</option>
  <option value="10">OCTUBRE</option>
  <option value="11">NOVIEMBRE</option>
  <option value="12">DICIEMBRE</option>
</select>

 <select id="anioDetalleContrato1" name="anioDetalleContrato1">
      <option value="" selected>Año</option>
      <?php $year = date("Y");
      for($i=$year; $i>=2020; $i--){
          echo '<option value="'.$i.'">'.$i.'</option>';
         }
      ?>
    </select>

</center>

<section>
    <table id="tablaCoberturaGeneral"  class="records_list table table-striped table-bordered table-hover" style="display: none;" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Entidad</th>
                <th style="text-align: center;background-color: #B0E76E"># Vehiculos</th>
                <th style="text-align: center;background-color: #B0E76E">Total Puntos servicio</th>
                <th style="text-align: center;background-color: #B0E76E">Elementos Requisición Ventas</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Operativa</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Administrativa</th>       
                <th style="text-align: center;background-color: #B0E76E">Estado De Fuerza Cubre</th>       
                <th style="text-align: center;background-color: #B0E76E">12X12X7</th>
                <th style="text-align: center;background-color: #B0E76E">12X12X6</th>
                <th style="text-align: center;background-color: #B0E76E">12x12x5</th> 
                <th style="text-align: center;background-color: #B0E76E">12X12X3</th> 
                <th style="text-align: center;background-color: #B0E76E">12X24X7</th> 
                <th style="text-align: center;background-color: #B0E76E">24X24X7</th> 
                <th style="text-align: center;background-color: #B0E76E">NO DEFINIDO</th> 
                <th style="text-align: center;background-color: #B0E76E">HORARIO DE OFICINA</th> 
                <th style="text-align: center;background-color: #B0E76E">Conteo General Cobertura(Ventas)</th>
                <th style="text-align: center;background-color: #B0E76E">Cobertura Dia(Ventas)</th> 
                <th style="text-align: center;background-color: #B0E76E">Cobertura Noche(Ventas)</th> 
            </tr>
        </thead>
   </table>
</section>

<script type="text/javascript">

$(document).ready(function() {

  $.ajax({
          type: "POST",
          url: "ajax_obtenerLineasdeNegocio.php",
          dataType: "json",
          success: function(response) {
            $("#seleccionarLineNegocio").empty();  
            $('#seleccionarLineNegocio').append('<option value="0">LINEA DE NEGOCIO</option>');
              if(response.status == "success"){
                for (var i = 0; i < response.valor.length; i++){
                    $('#seleccionarLineNegocio').append('<option value="'+(response.valor[i].idLineaNegocio)+'">'+response.valor[i].descripcionLineaNegocio+'</option>');
                  }
              }else{
                alert("Error al cargar Linea de Negocio");
              }
          },
            error: function(jqXHR, textStatus, errorThrown){
                   alert(jqXHR.responseText);
            }
  });
});//termina ready

$("#seleccionarLineNegocio").change(function(){

  var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
  $.ajax({
          type: "POST",
          url: "ajax_obtenerSupervisoresXLineaNegocio.php",
          data: {"LineaNegocioElegida": LineaNegocioElegida},
          dataType: "json",
          success: function(response) {
            $("#seleccionarSupervisor").empty();  
            $('#seleccionarSupervisor').append('<option value="0">SUPERVISOR</option>');
              if(response.status == "success"){
                 for(var i = 0; i < response.datos.length; i++){
                      $('#seleccionarSupervisor').append('<option value="' + (response.datos[i].NumEmpSupervisor) + '">' + response.datos[i].Nombre + '</option>');
                 }
                 $("#DivSeleccionarSup").show();
               }else{
                   alert("Error al cargar Entidades");
                   $("#DivSeleccionarSup").hide();

                 }
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
            $("#DivSeleccionarSup").hide();
          }
     });
});

$("#seleccionarSupervisor").change(function(){
    $("#periodoConsultaSup").show();
});

$("#periodoConsultaSup").change(function(){
   
   var periodo =$("#periodoConsultaSup").val();
    if (periodo =='0') {
        alert("elija un periodo");
        } 
        else{
            $("#anioConsultaSup").show();
        }
});

$("#periodoConsultaSup").change(function(){
    waitingDialog.show();
    tablaCoberturaGeneralArray = [];
    var noSupervisor= $("#seleccionarSupervisor").val();
    var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
    $.ajax({
        type: "POST",
        url: "ajax_infoXEntidadesSupervisor.php",
        data: {"noSupervisor": noSupervisor,"LineaNegocioElegida": LineaNegocioElegida},
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                 for (var i = 0; i < response.datos.length; i++) {
                     var record = response.datos[i];
                     tablaCoberturaGeneralArray.push(record);
                 }
                 waitingDialog.hide();
                 loadDataIntableCoberturaGeneral(tablaCoberturaGeneralArray);
                 
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
});


 var tablaCoberGeneral = null;

 function loadDataIntableCoberturaGeneral(data) {
     if (tablaCoberGeneral != null) {
         tablaCoberGeneral.destroy();
     }
     tablaCoberGeneral = $('#tablaCoberturaGeneral').DataTable({
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
             "data": "EntidadesRegion"
         },
         {  
             "data": "TotalVehiculos"
         },
         {  
             "data": "TotalPuntos"
         },
         {  
             "data": "RequisicionVentas"
         },
         {  
             "data": "TotalElementosOp"
         },
         {  
             "data": "TotalElementosTA"
         },
         {  
             "data": "TotalElementosOpGif"
         },
         {  
             "data": "Rol12x7"
         },
         {  
             "data": "Rol12x6"
         }, 
         {  
             "data": "Rol12x5"
         },
         {  
             "data": "Rol12x3"
         },
         {  
             "data": "Rol24x7"
         },
         {  
             "data": "Rol24x24"
         },
         {  
             "data": "RolNA"
         },
         {  
             "data": "RolOF"
         },
         {  
             "data": "turnosPorDia"
         },
         {  
             "data": "turnoDeDia"
         },
         {  
             "data": "turnosDeNoche"
         },],
         processing: true,
         dom: 'Bfrtip',

          buttons: {
        buttons: ['excel']
    }
         
     });
 }




</script>



