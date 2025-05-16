<div class="container" align="center" >
	<form class="form-horizontal" id="form_reporteFacturacion" name="form_reporteFacturacion" action="ficheroExportReporteFacturacion.php" target="_blank" method="post">
		DE:<input id="txtFechaReporte1" name="txtFechaReporte1" type="text" class="input-medium"> A: <input id="txtFechaReporte2" name="txtFechaReporte2" type="text" class="input-medium" >
		
    <button class="btn btn-primary" type="button" onclick="crearTablaReporte();"> Generar Reporte</button>
    <button id="descargarReporteFacturacion" name="descargarReporteFacturacion" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
    
    <input type="hidden" id="datos_ReporteFacturacion" name="datos_ReporteFacturacion" />
		<br>
		<br>
		<div id="divTableReporte" name="divTableReporte" align="center" >


  		</div> <!-- Fin div table -->
	</form>
</div> <!-- Fin div container -->

<script type="text/javascript">

var style="background-color:#BDBDBD; text-align:center ; font-weight: bold;";
	
	$('#txtFechaReporte1').datetimepicker({
 
  	timepicker:false,
  	format:'Y-m-d',
  	formatDate:'Y-m-d',

	});

  	$('#txtFechaReporte2').datetimepicker({
  	timepicker:false,
  	format:'Y-m-d',
  	formatDate:'Y-m-d',

	});

  function getDetallesRequisiciones(puntoServicioId, fecha1, fecha2)
  {

      $.ajax({
            
            type: "POST",
            url: "ajax_getDetallesRequisiciones.php",
            data : {"idPuntoServicio":puntoServicioId,"fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
   

                    for ( var i = 0; i < lista.length; i++ ){

                    	  var servicioPlantillaId = lista[i].servicioPlantillaId;
                        var puntoServicio = lista[i].puntoServicio;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno= lista[i].descripcionTurno;
                        var fechaInicio= lista[i].fechaInicio;
                        var fechaTerminoPlantilla= lista[i].fechaTerminoPlantilla;
                        var totalElementos= lista[i].totalElementos;
                        var puntoServicioPlantillaId= lista[i].puntoServicioPlantillaId;

                        listaTableRequisiciones= "<tr><td>"+puntoServicioPlantillaId+"</td><td>"+servicioPlantillaId+" </td><td>"+puntoServicio+" </td><td>"+descripcionPuesto+"</th><td>"+descripcionTurno+"</td><td>"+fechaInicio+"</td><td>"+fechaTerminoPlantilla+"</td><td>"+totalElementos+"</td></tr>";
                        console.log (listaTableRequisiciones);  

                        return listaTableRequisiciones; 
                    }

                 //termina requisiciones
                 

                                   
                } //termina if success
            },           

            error: function (response)
            {
                console.log (response);

            }
        });
  }


  function crearTablaReporte()
  {
     var fecha1=$("#txtFechaReporte1").val();
     var fecha2=$("#txtFechaReporte2").val();

    var tableReporteFacturacion="<table class='table table-bordered table-striped' id='tableReporteFacturacion' name='tableReporteFacturacion'><thead>";
      tableReporteFacturacion +="<tr><th>IdPunto</th><th>IdRequisicion</th><th>Punto Servicio</th><th>No. Centro Costo</th><th>Cliente</th><th>Entidad</th>";
      tableReporteFacturacion +="<th>Fecha Inicio</th><th>Fecha Termino</th><th>No.Elementos</th><th>Puesto</th><th>Turno</th><th>Costo turno</th>";
      tableReporteFacturacion += "<th>Dias Presupues</th><th>Turnos x dia</th><th>TurnosPresupuestados</th><th>CobroPresupuestado</th><th>TurnosCubiertos</th></tr></thead><tbody></tbody></table>";

    $('#divTableReporte').html(tableReporteFacturacion); 

    reporteFacturacion(fecha1, fecha2)

  }

  function reporteFacturacion(fecha1, fecha2)
  {

          $("#tableReporteFacturacion").find("tr:gt(0)").remove();

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
                      var requisiciones= lista[i].requisiciones.detalles;

                    var dateTable="<tr><td style='"+style+"' colspan='17'>"+puntoServicio+"</td>";
                    //var dateTable="<tr><td style='"+style+"'>"+idPuntoServicio+"</td><td style='"+style+"'>"+numeroCentroCosto+"</td><td style='"+style+"' width='180px'>"+puntoServicio+"</td><td style='"+style+"'>"+nombreEntidadFederativa+"</td><td style='"+style+"' width='120px'>"+razonSocial+"</td>";
                    //var dateTable="<td style='"+style+"'>"+nombreEntidadFederativa+"</td><td style='"+style+"'>"+razonSocial+"</td><td style='"+style+"'>"+numeroCentroCosto+"</td>";
                    //dateTable += "<td style='"+style+"'>"+fechaInicioServicio+"</td><td style='"+style+"'>"+fechaTerminoServicio+"</td>";
                    dateTable += "</tr>";

                    $('#tableReporteFacturacion').append(dateTable);

                    crearCeldasRequisiciones(requisiciones);
                    //alert(requisiciones);

                  }
                    
                }
            },
            error: function (response)
            {
                //console.log (response);
            }
        });
  }

  function crearCeldasRequisiciones(requisiciones)
  {
    var fecha1=$("#txtFechaReporte1").val();
    var fecha2=$("#txtFechaReporte2").val();

    var servicioPlantillaId="";

    var sumaTurnosPresupuestados=0;
    var sumaCobroPresupuestado=0;
    var sumaTurnosCubiertosPerfil=0;


     for (var i = 0; i < requisiciones.length; i++){

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



          var dataRequisiciones="<tr><td>"+puntoServicioPlantillaId+"</td><td>"+servicioPlantillaId+"</td><td width='180px'>"+puntoServicio+"</td><td>"+numeroCentroCosto+"</td><td width='180px'>"+razonSocial+"</td><td>"+nombreEntidadFederativa+"</td>";
          dataRequisiciones += "<td>"+fechaInicio+"</td><td>"+fechaTerminoPlantilla+"</td><td>"+totalElementos+"</td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+costoPorTurno+"</td><td>"+diasPresupuestados+"</td><td>"+turnosTotalesDiarios+"</td>";
          // dataRequisiciones +="<td>"+turnosPresupuestados+"</td><td>"+currency(cobroPresupuestado, 2, [',', "'", '.'])+"</td><td>"+turnosCubiertosPerfil+"</td></tr>";
          dataRequisiciones +="<td>"+turnosPresupuestados+"</td><td>"+currency(cobroPresupuestado, 2, [',', "'", '.'])+"</td><td>SIN INFO</td></tr>";

       $('#tableReporteFacturacion').append(dataRequisiciones);
        //alert(requsicionId);
        sumaTurnosPresupuestados=parseInt(sumaTurnosPresupuestados)+parseInt(turnosPresupuestados);
        sumaCobroPresupuestado= parseFloat(sumaCobroPresupuestado) + parseFloat(cobroPresupuestado);
        sumaTurnosCubiertosPerfil=parseInt(sumaTurnosCubiertosPerfil) + parseInt(turnosCubiertosPerfil);


     } //termin for

     //alert(sumaTurnosCubiertosPerfil);
     
     //var tableTotales="<tr><td colspan='14'>Totales</td><td>"+sumaTurnosPresupuestados+"</td><td>"+currency(sumaCobroPresupuestado, 2, [',', "'", '.'])+"</td><td>"+sumaTurnosCubiertosPerfil+"</td></tr>";
     var tableTotales="<tr><td colspan='14'>Totales</td><td>"+sumaTurnosPresupuestados+"</td><td>"+currency(sumaCobroPresupuestado, 2, [',', "'", '.'])+"</td><td>SIN INFO</td></tr>";
     $('#tableReporteFacturacion').append(tableTotales);
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


     $("#descargarReporteFacturacion").click(function(event) {
     $("#datos_ReporteFacturacion").val( $("<div>").append( $("#divTableReporte").eq(0).clone()).html());
     $("#form_reporteFacturacion").submit();
      });


</script>

