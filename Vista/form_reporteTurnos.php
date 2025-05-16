<div class="container" align="center" >
	<form class="form-horizontal" id="form_reporteTurnos" name="form_reporteTurnos" action="ficheroExportreporteTurnos.php" target="_blank" method="post">
		DE:<input id="txtFechaReporteTurnos1" name="txtFechaReporteTurnos1" type="text" class="input-medium"> A: <input id="txtFechaReporteTurnos2" name="txtFechaReporteTurnos2" type="text" class="input-medium" >
		
    <button class="btn btn-primary" type="button" onclick="crearTablaReporteTurnos();"> Generar Reporte</button>
    <button id="descargarreporteTurnos" name="descargarreporteTurnos" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
    
    <input type="hidden" id="datos_reporteTurnos" name="datos_reporteTurnos" />
		<br>
		<br>
		<div id="divTableReporteTurnos" name="divTableReporteTurnos" align="center" >


  		</div> <!-- Fin div table -->
	</form>
</div> <!-- Fin div container -->

<script type="text/javascript">

var style="background-color:#BDBDBD; text-align:center ; font-weight: bold;";
	
	$('#txtFechaReporteTurnos1').datetimepicker({
 
  	timepicker:false,
  	format:'Y-m-d',
  	formatDate:'Y-m-d',

	});

  	$('#txtFechaReporteTurnos2').datetimepicker({
  	timepicker:false,
  	format:'Y-m-d',
  	formatDate:'Y-m-d',

	});



  function crearTablaReporteTurnos()
  {
     var fecha1=$("#txtFechaReporteTurnos1").val();
     var fecha2=$("#txtFechaReporteTurnos2").val();

    var tableReporteTurnos="<table class='table table-bordered table-striped' id='tableReporteTurnos' name='tableReporteTurnos'>";
        tableReporteTurnos +="<tr style='font-weight: bold;'><td>IdPunto</td><td>IdRequisicion</td><td>Punto Servicio</td><td>No. Centro Costo</td><td>Cliente</td><td>Entidad</td>";
        tableReporteTurnos +="<td>Fecha Inicio</td><td>Fecha Termino</td><td>No.Elementos</td><td>Puesto</td><td>Turno</td><td>Costo turno</td>";
        tableReporteTurnos += "<td>Dias Presupues</td><td>TurnosPresupuestados</td><td>Turnos nómina</td><td>Turnos a cobrar</td></tr>";
        tableReporteTurnos +="<tbody></tbody></table>";

    $('#divTableReporteTurnos').html(tableReporteTurnos); 

    reporteTurnos(fecha1, fecha2)

  }

  function reporteTurnos(fecha1, fecha2)
  {

          $("#tableReporteTurnos").find("tr:gt(0)").remove();

           $.ajax({
            type: "POST",
            url: "ajax_getPuntosServiciosReporte2.php",
            data : {"fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var lista = response.data;
                   
                    for ( var i = 0; i < lista.length; i++ ){

                      var idPuntoServicio = lista[i].idPuntoServicio;
                      var puntoServicio = lista[i].puntoServicio;
                      var numeroCentroCosto = lista[i].numeroCentroCosto;
                      var nombreEntidadFederativa = lista[i].nombreEntidadFederativa;
                      var razonSocial = lista[i].razonSocial;
                      var fechaInicioServicio = lista[i].fechaInicioServicio;
                      var fechaTerminoServicio = lista[i].fechaTerminoServicio;
                      var cobraDescansos=lista[i].cobraDescansos;
                      var cobraDiaFestivo=lista[i].cobraDiaFestivo;
                      var cobra31=lista[i].cobra31;

                      var requisiciones= lista[i].requisiciones.detalles;
                      var turnosPagados= lista[i].turnosPagados.turnosPagados;
                      var turnosPorCobrar= lista[i].turnosPorCobrar;

                    

                    var dateTable="<tr><td style='"+style+"' colspan='16'>"+puntoServicio+" <br>(FECHA INICIO SERVICIO:"+fechaInicioServicio+" / FECHA TERMINO SERVICIO: "+fechaTerminoServicio+")</td></tr>";

                    
                    //var dateTable="<tr><td style='"+style+"'>"+idPuntoServicio+"</td><td style='"+style+"'>"+numeroCentroCosto+"</td><td style='"+style+"' width='180px'>"+puntoServicio+"</td><td style='"+style+"'>"+nombreEntidadFederativa+"</td><td style='"+style+"' width='120px'>"+razonSocial+"</td>";
                    //var dateTable="<td style='"+style+"'>"+nombreEntidadFederativa+"</td><td style='"+style+"'>"+razonSocial+"</td><td style='"+style+"'>"+numeroCentroCosto+"</td>";
                    //dateTable += "<td style='"+style+"'>"+fechaInicioServicio+"</td><td style='"+style+"'>"+fechaTerminoServicio+"</td>";

                    dateTable+= crearCeldasRequisicionesTurnos(requisiciones, cobraDescansos, cobraDiaFestivo, cobra31, turnosPagados, turnosPorCobrar);
                  

                    $('#tableReporteTurnos').append(dateTable);

                    
                    //alert(requisiciones);

                  }
                    
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
        });
  }

  function crearCeldasRequisicionesTurnos(requisiciones, cobraDescansos, cobraDiaFestivo, cobra31, turnosPagados, turnosPorCobrar)
  {
    var fecha1=$("#txtFechaReporteTurnos1").val();
    var fecha2=$("#txtFechaReporteTurnos2").val();

    var servicioPlantillaId="";

    var sumaTurnosPresupuestados=0;
    var sumaCobroPresupuestado=0;
    var sumaTurnosCubiertosPerfil=0;
    var sumaElementosSolicitados=0;
    var puntoServicio="";
    var nombreEntidadFederativa="";
    var puntoServicioPlantillaId="";
    

    var dataRequisiciones="<tr style='font-weight: bold;'><td>IdPunto</td><td>IdRequisicion</td><td>Punto Servicio</td><td>No. Centro Costo</td><td>Cliente</td><td>Entidad</td>";
        dataRequisiciones +="<td>Fecha Montaje</td><td>Fecha Termino M</td><td>No.Elementos</td><td>Puesto</td><td>Turno</td><td>Costo turno</td>";
        dataRequisiciones += "<td>Dias Presupues</td><td>TurnosPresupuestados</td><td>Turnos nómina</td><td>Turnos a cobrar</td></tr>";


     for (var i = 0; i < requisiciones.length; i++){
      
      //alert(row);

      puntoServicioPlantillaId=requisiciones[i]["puntoServicioPlantillaId"];
      puntoServicio=requisiciones[i]["puntoServicio"];
      servicioPlantillaId=requisiciones[i]["servicioPlantillaId"];
      descripcionPuesto=requisiciones[i]["descripcionPuesto"];
      descripcionTurno=requisiciones[i]["descripcionTurno"];
      numeroCentroCosto=requisiciones[i]["numeroCentroCosto"];
      nombreEntidadFederativa=requisiciones[i]["nombreEntidadFederativa"];
      razonSocial=requisiciones[i]["razonSocial"];
      totalElementos=requisiciones[i]["totalElementos"];
      fechaInicio=requisiciones[i]["fechaInicio"];
      fechaTerminoPlantilla=requisiciones[i]["fechaTerminoPlantilla"];
      costoPorTurno=requisiciones[i]["costoPorTurno"];
      turnosTotalesDiarios=requisiciones[i]["turnosTotalesDiarios"];
      turnosCubiertosPerfil=requisiciones[i]["turnosCubiertos"]["totalTurnosCubiertos"];

      if (fechaInicio<fecha1){
        //alert("el servicio inicio antes de la fecha de consulta");

        start_actual_time = parseDate(fecha1);
        //alert("si la fecha de inicio es menor a la de consulta entonces fecha de diferencia es fecha de consulta1 de rango"+ fecha1+ " "+ start_actual_time);

      }else {

        start_actual_time=new parseDate(fechaInicio);
        //alert("si la fecha de inicio es mayor a la de consulta entonces fecha de diferencia es fecha inicial "+ fechaInicio+ " "+ start_actual_time);

      }

      if (fechaTerminoPlantilla<fecha2){

        end_actual_time = parseDate(fechaTerminoPlantilla);

      }else{

        end_actual_time = parseDate(fecha2);

      }
      
      var diasPresupuestados=0;

        while (start_actual_time <= end_actual_time)
          {
              diasPresupuestados=diasPresupuestados+1;

              var nuevaFecha = new Date(start_actual_time);
              start_actual_time = new Date(nuevaFecha.setDate (nuevaFecha.getDate() + 1));
          }

          var turnosPresupuestados= parseInt(diasPresupuestados) * parseInt(turnosTotalesDiarios);
          var cobroPresupuestado= turnosPresupuestados * costoPorTurno;

          dataRequisiciones+="<tr><td>"+puntoServicioPlantillaId+"</td><td>"+servicioPlantillaId+"</td><td width='180px'>"+puntoServicio+"</td><td>"+numeroCentroCosto+"</td><td width='180px'>"+razonSocial+"</td><td>"+nombreEntidadFederativa+"</td>";
          dataRequisiciones += "<td>"+fechaInicio+"</td><td>"+fechaTerminoPlantilla+"</td><td>"+totalElementos+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+costoPorTurno+"</td><td>"+diasPresupuestados+"</td>";
          // dataRequisiciones +="<td>"+turnosPresupuestados+"</td><td>"+currency(cobroPresupuestado, 2, [',', "'", '.'])+"</td><td>"+turnosCubiertosPerfil+"</td></tr>";
          dataRequisiciones +="<td>"+turnosPresupuestados+"</td><td></td><td></td></tr>";


       //$('#tableReporteTurnos').append(dataRequisiciones);
        //alert(requsicionId);
        sumaTurnosPresupuestados=parseInt(sumaTurnosPresupuestados)+parseInt(turnosPresupuestados);
        sumaCobroPresupuestado= parseFloat(sumaCobroPresupuestado) + parseFloat(cobroPresupuestado);
        sumaTurnosCubiertosPerfil=parseInt(sumaTurnosCubiertosPerfil) + parseInt(turnosCubiertosPerfil);
        sumaElementosSolicitados=parseInt(sumaElementosSolicitados)+parseInt(totalElementos);


     } //termin for


     //alert(dataRequisiciones);
     

     //alert(sumaTurnosCubiertosPerfil);
     var cd="";
     if(cobraDescansos==0){
      cd="NO";
     }else if(cobraDescansos==1){
      cd="SI"
     }

     if(cobraDiaFestivo==0){
      df="NO";
     }else if(cobraDiaFestivo==1){
      df="SI"
     }
     if(cobra31==0){
      d31="NO";
     }else if(cobra31==1){
      d31="SI"
     }
     
     //dataRequisiciones+="<tr><td colspan='14'>Totales</td><td>"+sumaTurnosPresupuestados+"</td><td>"+currency(sumaCobroPresupuestado, 2, [',', "'", '.'])+"</td><td>"+sumaTurnosCubiertosPerfil+"</td></tr>";
     dataRequisiciones+="<tr><td colspan='4'>"+puntoServicio+" </td><td style='font-size:10.5px'>COBRA DES:"+cd+" 31:"+d31+" DIA FES:"+df+"</td><td>"+nombreEntidadFederativa+"</td><td colspan='2'></td><td>"+sumaElementosSolicitados+"</td><td>ELEMENTOS</td><td colspan='3'>TOTAL</td><td>"+sumaTurnosPresupuestados+"</td><td>"+turnosPagados+"</td><td>"+turnosPorCobrar+"</td></tr>";
     //$('#tableReporteTurnos').append(tableTotales);

     return dataRequisiciones;
  }

  function getTurnosCubiertos(){

  }



  function currency(value, decimals, separators) {
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || ['.', "'", ','];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return (parts.length == 3 ? '-' : '') + result;
}




     $("#descargarreporteTurnos").click(function(event) {
     $("#datos_reporteTurnos").val( $("<div>").append( $("#divTableReporteTurnos").eq(0).clone()).html());
     $("#form_reporteTurnos").submit();
      });


</script>

