
<meta charset="utf-8"/>
<dir id="mensajeErrorEdicionVehiculo"></dir>
<legend>HISTORICO EDICIONES DE VEHICULOS</legend>

<a id="TodasLasEdiciones"onclick="VeridicarOpcion(0)"style="cursor: pointer;display: none;" data-toggle="tab">LISTA DE TODAS LAS EDICIONES</a><br>

<div class="input-prepend" id="divEjercicio" style="display: none;">
  <h4 >POR EJERCICIO</h4>
  <span class="add-on">Fecha Inicial</span>
  <input class="input-prepend" id="inpEjercicioFechaInicio" name="inpEjercicioFechaInicio" type="date">

  <span class="add-on">Fecha Final</span>
  <input class="input-prepend" id="inpEjercicioFechaFinal" name="inpEjercicioFechaFinal" type="date"><br><br>
  <button type="button" class="btn btn-primary" onclick="VeridicarOpcion(1);">BUSCAR</button>
</div><br><br>

<h3 id="listaedicion" style="display: none;">LISTA DE TODAS LAS EDIONES DEL PARQUE VEHICULAR</h3>
<h3 id="listaedicionporejercicio" style="display: none;">LISTA DE LAS EDICIONES POR EJERCICIO DEL PARQUE VEHICULAR</h3>

<div align="center" id="divtablaediciones" style="display: none;">
        <section>
          <table id="tablaedicionesvehiculos" align="center" border="1" cellspacing="0" width="90%">
            <thead>
              <tr>
                <th>N° ECONOMICO</th>
                <th>PLACAS</th>
                <th>LINEA DE NEGOCIO</th>
                <th>ENTIDAD FEDERATIVA</th>
                <th>COLOR DEL ENGOMADO</th>
                <th>TIPO DE TARJETA</th>
                <th>FECHA INICIO VIGENCIA T.CIRCULACION</th>
                <th>FECHA FIN VIGENCIA T.CIRCULACION</th>
                <th>TIENE NUMERO DE MOTOR</th>
                <th>N° DE MOTOR</th>
                <th>PAIS DE ORIGEN</th>
                <th>N° DE TARJETA LLAVE</th>
                <th>N° DE TARJETA DE GAS</th>
                <th>N° DE NIP</th>
                <th>ASEGURADORA</th>
                <th>TIPO DE COBERTURA</th>
                <th>N° DE POLIZA</th>
                <th>FECHA INICIO VIGENCIA POLIZA</th>
                <th>FECHA FIN VIGENCIA POLIZA</th>
                <th>NOMBRE TARJETA DE CIRCULACION</th>
                <th>NOMBRE POLIZA DE SEGURO</th>
                <th>NOMBRE DE FACTURA</th>
                <th>USUARIO QUE EDITÓ</th>
                <th>FECHA DE EDICIÓN</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </section>
      </div>
<script type="text/javascript">

var tablaEdicionVehicular = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioHistoricoEdicionV());  

function inicioHistoricoEdicionV(){
    if (rolUsuario=="Control Vehicular"){
      MostrarTalbaEdicionesParqueVehicular();
    } 
}


function MostrarTalbaEdicionesParqueVehicular() {
  $("#divtablaediciones").hide();
  $("#TodasLasEdiciones").show();
  $("#divEjercicio").show();
 }

function VeridicarOpcion(consulta1) {
  var inpEjercicioFechaInicio = $("#inpEjercicioFechaInicio").val();
  var inpEjercicioFechaFinal = $("#inpEjercicioFechaFinal").val();
  if(consulta1==0){
    $("#inpEjercicioFechaInicio").val("");
    $("#inpEjercicioFechaFinal").val("");
    $("#listaedicion").show();
    $("#listaedicionporejercicio").hide();
    MostrarTablaEdicionesVehiculos(consulta1,0,0);
  }else if(consulta1==1){
    if(inpEjercicioFechaInicio==""){
      cargaerroresHistoricoEdicon("Ingrese La Fecha Inicial");
    }else if(inpEjercicioFechaFinal== ""){
      cargaerroresHistoricoEdicon("Ingrese La Fecha Final");
    }else if (inpEjercicioFechaInicio>inpEjercicioFechaFinal){
      cargaerroresHistoricoEdicon("La Fecha Inicial No puede Ser Mayor Que La Fecha Final");
    }else{
      $("#listaedicion").hide();
      $("#listaedicionporejercicio").show();
      MostrarTablaEdicionesVehiculos(consulta1,inpEjercicioFechaInicio,inpEjercicioFechaFinal);
    }
  }
}
    function MostrarTablaEdicionesVehiculos(consulta,FechaInicial,FechaFinal)
    {
      tabltablaeditvehi = [];
        $.ajax({
         type: "POST",
         url: "ajax_obtenerTablaEdicionVehicular.php",
         data:{"consulta": consulta,"FechaInicial": FechaInicial,"FechaFinal": FechaFinal},
         dataType: "json",
         success: function(response) {
          console.log(response);
          if (response.status == "success") {
            for (var i = 0; i < response.data.length; i++) {
              var record = response.data[i];
              tabltablaeditvehi.push(record);
            }// se cierrra el for 
            loadDatatableEdicion(tabltablaeditvehi);
          }else {
            var mensaje = response.error;
            alert(mensaje);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });
    }

 function loadDatatableEdicion(data) {
     if (tablaEdicionVehicular != null) {
         tablaEdicionVehicular.destroy();
     }
          tablaEdicionVehicular = $('#tablaedicionesvehiculos').DataTable({
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
       { "data": "NumeroEco"}
      ,{ "data": "Placas"}
      ,{ "data": "LineaNegocio"}
      ,{ "data": "Entidad"}
      ,{ "data": "ColorEngomado"}
      ,{ "data": "TipoTarjeta"}
      ,{ "data": "FechaInicioVegenciaTC"}
      ,{ "data": "FechaFinVigenciaTC"}
      ,{ "data": "TieneMotor"}
      ,{ "data": "NumeroDeMotor"}
      ,{ "data": "Pais"}
      ,{ "data": "NumeroTarjetaLlave"}
      ,{ "data": "NumeroTarjetaGas"}
      ,{ "data": "NumeroNip"}
      ,{ "data": "Aseguradora"}
      ,{ "data": "TipoPoliza"}
      ,{ "data": "NumeroPoliza"}
      ,{ "data": "FechaInicioPoliza"}
      ,{ "data": "FechaFinalPoliza"}
      ,{ "data": "NombreTarjetaC"}
      ,{ "data": "NombrePoliza"}
      ,{ "data": "NombreFactura"}
      ,{ "data": "UsuarioEdited"}
      ,{ "data": "FechaEdicion"}
      ],
        processing: true,
        dom: 'lBf',
        buttons: [{
      extend: 'excel',
      title: 'Historico Edicion Del Vehiculo',
      messageTop: '',
      messageBottom: '',
      orientation: 'landscape',
      customizeData: function(data) {//esto se hizo para cambiar el tipo de dato de entero a texto para evitar que el excel 
        for(var i = 0; i < data.body.length; i++) {
          for(var j = 0; j < data.body[i].length; j++) {
            data.body[i][j] = '\u200C' + data.body[i][j];
          }
        }
      }
    }]
     });
$("#divtablaediciones").show();
 }

 function cargaerroresHistoricoEdicon(mensaje){
  $('#mensajeErrorEdicionVehiculo').fadeIn('slow');
  alertmensajeerror="<div class='alert alert-error' id='mensajeErrorEdicionVehiculo'>"+mensaje+"<data-dismiss='alert'>";
  $("#mensajeErrorEdicionVehiculo").html(alertmensajeerror);
  $('#mensajeErrorEdicionVehiculo').delay(3000).fadeOut('slow');
  $(document).scrollTop(0);
}

  </script>

