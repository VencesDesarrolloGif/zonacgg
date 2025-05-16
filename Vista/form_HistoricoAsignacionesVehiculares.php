<meta charset="utf-8"/>
<div id="mensajeErrorAsignacionVehiculo"></div>
<legend>HISTORICO REASIGNACIONES DE VEHICULOS</legend>

<a id="TodasLasAsignaciones"onclick="VeridicarOpcionAsignacion(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TODAS LAS REASIGNACIONES</a><br>

<div class="input-prepend" id="divEjercicioAsignaciones" style="display: none;">
  <h4 >POR EJERCICIO</h4>
  <span class="add-on">Fecha Inicial</span>
  <input class="input-prepend" id="inpEjercicioAsignacionFechaInicio" name="inpEjercicioAsignacionFechaInicio" type="date">

  <span class="add-on">Fecha Final</span>
  <input class="input-prepend" id="inpEjercicioAsignacionFechaFinal" name="inpEjercicioAsignacionFechaFinal" type="date"><br><br>
  <button type="button" class="btn btn-primary" onclick="VeridicarOpcionAsignacion(1);">BUSCAR</button>
</div><br><br>

<h3 id="listaAsignacion" style="display: none;">LISTA DE TODAS LAS REASIGNACIONES DEL PARQUE VEHICULAR</h3>
<h3 id="listaAsignacionporejercicio" style="display: none;">LISTA DE LAS REASIGNACIONES POR EJERCICIO DEL PARQUE VEHICULAR</h3>

<div align="center" id="divtablaasignaciones" style="display: none;">
        <section>
          <table id="tablaasignacionesvehiculos" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>                                                    
                <th>N° DE PLACAS</th>                   
                <th>N° EMPLEADO/NOMBRES</th> 
                <th>ENTIDAD FEDERATIVA</th>                 
                <th>PUESTO EMPLEADO</th>                  
                <th>N° DE LICENCIA</th>                  
                <th>KILOMETRAJE VEHICULO</th>                  
                <th>MOTIVO DE REASIGNACIÓN</th>                  
                <th>FECHA DE ASIGNACIÓN</th>                  
                <th>FECHA DE REASIGNACION</th>                  
                <th>USUARIO QUE EDITÓ</th>                                        
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var tablaAsignacionVehicular = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioHistAsigV());  

function inicioHistAsigV(){
    if (rolUsuario=="Control Vehicular")
    {
      MostrarTalbaAsignacionesParqueVehicular();
    } 
}
function MostrarTalbaAsignacionesParqueVehicular() {
  $("#divtablaasignaciones").hide();
  $("#TodasLasAsignaciones").show();
  $("#divEjercicioAsignaciones").show();
 
 }

function VeridicarOpcionAsignacion(consulta1) {
  var inpEjercicioAsignacionFechaInicio = $("#inpEjercicioAsignacionFechaInicio").val();
  var inpEjercicioAsignacionFechaFinal = $("#inpEjercicioAsignacionFechaFinal").val();
  if(consulta1==0){
    $("#inpEjercicioAsignacionFechaInicio").val("");
    $("#inpEjercicioAsignacionFechaFinal").val("");
    $("#listaAsignacion").show();
    $("#listaAsignacionporejercicio").hide();
    MostrarTablaAsignacionesVehiculos(consulta1,0,0);
  }else if(consulta1==1){
    if(inpEjercicioAsignacionFechaInicio==""){
      cargaerroresHistoricoAsignacion("Ingrese La Fecha Inicial");
    }else if(inpEjercicioAsignacionFechaFinal== ""){
      cargaerroresHistoricoAsignacion("Ingrese La Fecha Final");
    }else if (inpEjercicioAsignacionFechaInicio>inpEjercicioAsignacionFechaFinal){
      cargaerroresHistoricoAsignacion("La Fecha Inicial No puede Ser Mayor Que La Fecha Final");
    }else{
      $("#listaAsignacion").hide();
      $("#listaAsignacionporejercicio").show();
      MostrarTablaAsignacionesVehiculos(consulta1,inpEjercicioAsignacionFechaInicio,inpEjercicioAsignacionFechaFinal);
    }
  }
}
function MostrarTablaAsignacionesVehiculos(consulta,FechaInicial,FechaFinal) {

     tablaasig = [];
     $.ajax({
         type: "POST",
         url: "ajax_TablaHistoricoAsignacioVehicular.php",
         data:{"consulta": consulta,"FechaInicial": FechaInicial,"FechaFinal": FechaFinal},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                      //console.log(record);
                      tablaasig.push(record);
                    }  
                       loadDatatableAsignacion(tablaasig);
             } else {
                 var mensaje = response.error;
                 alert(mensaje);
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function loadDatatableAsignacion(data) {
     if (tablaAsignacionVehicular != null) {
         tablaAsignacionVehicular.destroy();
     }
     tablaAsignacionVehicular = $('#tablaasignacionesvehiculos').DataTable({
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
         destroy: true
      ,"columns": [
       { "data": "idvehiculoHistorico"}
      ,{ "data": "NumeroPlacaHistorico"}
      ,{ "data": "NombreYNumeroEmpleado"}
      ,{ "data": "EntidadEmpleado"}
      ,{ "data": "PuestoEmpleadoHistorico"}
      ,{ "data": "NumeroLicenciaHistorico"}
      ,{ "data": "KilometrajeHistorico"}
      ,{ "data": "MotivodeCambioHistorico"}
      ,{ "data": "FechaAsignacionHistorico"}
      ,{ "data": "FechaInsercionAlHistorico"}
      ,{ "data": "UsuarioCapturaHistorico"}
      ],
        processing: true,
        dom: 'Bfrtip',
        buttons: ['excel']
     });
$("#divtablaasignaciones").show();
 }

 function cargaerroresHistoricoAsignacion(mensaje){
  $('#mensajeErrorAsignacionVehiculo').fadeIn('slow');
  alertmensajeerror="<div class='alert alert-error' id='mensajeErrorAsignacionVehiculo'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeErrorAsignacionVehiculo").html(alertmensajeerror);
  $('#mensajeErrorAsignacionVehiculo').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
}

  </script>

