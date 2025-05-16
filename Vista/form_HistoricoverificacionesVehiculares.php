<meta charset="utf-8"/>
<dir id="mensajeErrorVerificacionVehiculo"></dir>
<legend>HISTORICO VERIFICACIÓN DE LOS VEHICULOS</legend>

<a id="TodasLasVerificaciones"onclick="VerificarOpcionVerificacion(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TODAS LAS VERIFICACIONES</a><br>

<div class="input-prepend" id="divEjercicioVerificaciones" style="display: none;">
  <h4 >POR EJERCICIO</h4>
  <span class="add-on">Fecha Inicial</span>
  <input class="input-prepend" id="inpEjercicioVerificacionFechaInicio" name="inpEjercicioVerificacionFechaInicio" type="date">

  <span class="add-on">Fecha Final</span>
  <input class="input-prepend" id="inpEjercicioVerificacionFechaFinal" name="inpEjercicioVerificacionFechaFinal" type="date"><br><br>
  <button type="button" class="btn btn-primary" onclick="VerificarOpcionVerificacion(1);">BUSCAR</button>
</div><br><br>

<h3 id="listaVericacion" style="display: none;">LISTA DE TODAS LAS VERIFICACIONES DEL PARQUE VEHICULAR</h3>
<h3 id="listaVericacionporejercicio" style="display: none;">LISTA DE LAS VERIFICACIOES POR EJERCICIO DEL PARQUE VEHICULAR</h3>

<div align="center" id="divtablaVerificacioines" style="display: none;">
        <section>
          <table id="tablaVerifiacionesvehiculos" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>                                                    
                <th>N° DE PLACAS</th>                   
                <th>COLOR DEL ENGOMADO</th> 
                <th>SE VERIFICA CONSTANTEMENTE?</th>                 
                <th>MONTO DE LA VERIFICACIÓN</th>                  
                <th>SE VERIFICÓ A TIEMPO?</th>                  
                <th>SE PAGO MULTA</th>                  
                <th>MONTO DE LA MULTA</th>                  
                <th>FOLIO DE LA MULTA</th>                  
                <th>PORQUE NO SE PAGO MULTA?</th>
                <th>NOMBRE TALÓN DE VERIFICACIÓN</th>
                <th>NOMBRE DOCUMENTO MULTA</th>
                <th>COMENTARIO GENERAL</th>                  
                <th>EL CALENDARIO ES NORMAL?</th>
                <th>SEMESTRE DE VERIFICACIÓN</th>
                <th>FECHA INICIO VERIFICACIÓ</th>
                <th>FECHA FIN VERIFICACIÓ</th>
                <th>USUARIO QUE VERIFICÓ</th>
                <th>FECHA DE REGISTRO DE LA VERIFIACIÓN</th>              
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>

<script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";
 var tablaVerificacionVehicular = null;

$(inicioHistoricoVerificacionVehicular());  

function inicioHistoricoVerificacionVehicular(){
    if (rolUsuario=="Control Vehicular"){
      MostrarTalbaVerificacionesParqueVehicular();
    } 
}


function MostrarTalbaVerificacionesParqueVehicular() {
  $("#divtablaVerificacioines").hide();
  $("#TodasLasVerificaciones").show();
  $("#divEjercicioVerificaciones").show();
 }

function VerificarOpcionVerificacion(consulta1) {
  var inpEjercicioVerificacionFechaInicio = $("#inpEjercicioVerificacionFechaInicio").val();
  var inpEjercicioVerificacionFechaFinal = $("#inpEjercicioVerificacionFechaFinal").val();
  if(consulta1==0){
    $("#inpEjercicioVerificacionFechaInicio").val("");
    $("#inpEjercicioVerificacionFechaFinal").val("");
    $("#listaVericacion").show();
    $("#listaVericacionporejercicio").hide();
    MostrarTablaVerificacionesVehiculos(consulta1,0,0);
  }else if(consulta1==1){
    if(inpEjercicioVerificacionFechaInicio==""){
      cargaerroresHistoricoVerificaciones("Ingrese La Fecha Inicial");
    }else if(inpEjercicioVerificacionFechaFinal== ""){
      cargaerroresHistoricoVerificaciones("Ingrese La Fecha Final");
    }else if (inpEjercicioVerificacionFechaInicio>inpEjercicioVerificacionFechaFinal){
      cargaerroresHistoricoVerificaciones("La Fecha Inicial No puede Ser Mayor Que La Fecha Final");
    }else{
      $("#listaVericacion").hide();
      $("#listaVericacionporejercicio").show();
      MostrarTablaVerificacionesVehiculos(consulta1,inpEjercicioVerificacionFechaInicio,inpEjercicioVerificacionFechaFinal);
    }
  }
}
function MostrarTablaVerificacionesVehiculos(consulta,FechaInicial,FechaFinal) {

     tablaVerific = [];
     $.ajax({
         type: "POST",
         url: "ajax_TablaHistoricoVerificacionVehicular.php",
         data:{"consulta": consulta,"FechaInicial": FechaInicial,"FechaFinal": FechaFinal},
         dataType: "json",
         success: function(response) {
             if (response.status == "success") {
                   for (var i = 0; i < response.data.length; i++) {
                      var record = response.data[i];
                      //console.log(record);
                      tablaVerific.push(record);
                    }  
                       loadDatatableVerifiacion(tablaVerific);
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

 function loadDatatableVerifiacion(data) {
     if (tablaVerificacionVehicular != null) {
         tablaVerificacionVehicular.destroy();
     }
     tablaVerificacionVehicular = $('#tablaVerifiacionesvehiculos').DataTable({
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
       { "data": "idVehiculoAVerificar"}
      ,{ "data": "PlacasVerificacion"}
      ,{ "data": "idColorEngomadoVerificacion"}
      ,{ "data": "VerificacionConstante"}
      ,{ "data": "MontoVerificacion"}
      ,{ "data": "SeVerificoATiempo"}
      ,{ "data": "SePagoMulta"}
      ,{ "data": "MontoMulta"}
      ,{ "data": "FolioMulta"}
      ,{ "data": "PorQueNoPagoMulta"}
      ,{ "data": "FotoTalonVerificacion"}
      ,{ "data": "FotoMultaVerificacion"}
      ,{ "data": "Comentarios"}
      ,{ "data": "CalendarioNormal"}
      ,{ "data": "SemestreVerificacion"}
      ,{ "data": "FechaInicioVerificacion"}
      ,{ "data": "FechaFinalVerificacion"}
      ,{ "data": "Usuarioverificacion"}
      ,{ "data": "FechaInsertVerificacion"}
      ],
        processing: true,
        dom: 'Bfrtip',
        buttons: ['excel']
     });
$("#divtablaVerificacioines").show();
 }

 function cargaerroresHistoricoVerificaciones(mensaje){
  $('#mensajeErrorVerificacionVehiculo').fadeIn('slow');
  alertmensajeerror="<div class='alert alert-error' id='mensajeErrorVerificacionVehiculo'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeErrorVerificacionVehiculo").html(alertmensajeerror);
  $('#mensajeErrorVerificacionVehiculo').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
}

  </script>

