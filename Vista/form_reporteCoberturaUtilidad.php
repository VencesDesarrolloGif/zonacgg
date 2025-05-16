<div class="container" align="center" >
  <form class="form-horizontal" id="form_reporteCoberturaCosto" name="form_reporteCoberturaCosto" action="ficheroExportreporteCobertura.php" target="_blank" method="post">
    <!-- 
    DE:<input id="txtFechaConsultaCobertura1" name="txtFechaConsultaCobertura1" type="text" class="input-medium"> A: <input id="txtFechaConsultaCobertura2" name="txtFechaConsultaCobertura2" type="text" class="input-medium" >
    
    <button class="btn btn-primary" type="button" onclick="crearTablaCobertura();"> Generar Reporte</button>
    <button id="descargarReporteCobertura" name="descargarReporteCobertura" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
    -->
    <input type="hidden" id="datos_reporteCobertura" name="datos_reporteCobertura" />
    <br>
    <br>

      <div>

        <select name="selectMesCobertura" id="selectMesCobertura" onchange="crearTablaCobertura1();">
            <option value="01">ENERO</option>
            <option value="02">FEBRERO</option>
            <option value="03">MARZO</option>
            <option value="04">ABRIL</option>
            <option value="05">MAYO</option>
            <option value="06">JUNIO</option>
            <option value="07">JULIO</option>
            <option value="08">AGOSTO</option>
            <option value="09">SEPTIEMBRE</option>
            <option value="10">OCTUBRE</option>
            <option value="11">NOVIEMBRE</option>
            <option value="12">DICIEMBRE</option>
        </select>
          <select name="anioCobertura" id="anioCobertura" onchange="crearTablaCobertura1();">
            <?php
            for($i=date('o'); $i>=2014; $i--){
                if ($i == date('o'))
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                else
                    echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
           <button id="descargarReporteCobertura" name="descargarReporteCobertura" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
        <br>
        <br>

  </div>
    <div id="divTableReporteCobertura" name="divTableReporteCobertura" align="center" >


    </div> <!-- Fin div table -->
    <div id="divTableReporteCobertura1" name="divTableReporteCobertura1" align="center" >


    </div> <!-- Fin div table -->
  </form>
</div> <!-- Fin div container -->

<script type="text/javascript">

var style="background-color:#BDBDBD; text-align:center ; font-weight: bold;";
  
  $('#txtFechaConsultaCobertura1').datetimepicker({
 
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',

  });

    $('#txtFechaConsultaCobertura2').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',

  });


  function crearTablaCobertura1()
  {
     
    var month=$("#selectMesCobertura").val();
    var year=$("#anioCobertura").val();

    var tableReporteCobertura="<table id='tableReporteCobertura1' name='tableReporteCobertura1' class='table table-bordered' >";
        tableReporteCobertura +="<tr style='font-weight: bold;'><td>Entidad</td>";
        tableReporteCobertura +="<td>Turnos al mes</td><td>Costo Turno</td><td>Cobro Presupuestado</td><td>Perdida/Utilidad</td></tr>";
     

    $('#divTableReporteCobertura1').html(tableReporteCobertura); 

    reporteCobertura1(month, year);

  }


  function reporteCobertura1(month, year)
  {         

          //var granTotalElementos=0;
          $("#tableReporteCobertura1").find("tr:gt(0)").remove();
          waitingDialog.show();

           $.ajax({
            type: "POST",
            url: "ajax_getCoberturaReporte.php",
            data : {"month":month, "year":year},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                  
                  var lista = response.lista;
                  var elementosEntidad=0;
                  var dataTable="";
                   
                  for ( var i = 0; i < lista.length; i++ )
                  {

                    var nombreEntidadFederativa = lista[i].nombreEntidadFederativa;
                    var razonSocial=lista[i].razonSocial;
                    var cuotaDiariaEmpleado= lista[i].cuotaDiariaEmpleado;
                    var claveClienteNomina= lista[i].claveClienteNomina;
                    
                    // Calcular la altura del rowspan para la entidad federativa
                    // La altura se calcula como la suma de todos los elementos que
                    // contienen los puestos de los puntos de servicio de la entidad.
                    
                    
                    dataTable+="<tr><td bgcolor='#DDE0FC'>"+nombreEntidadFederativa+"</td>";
                      //dataTable+="</tr>";// termina tr de entidades federativas

                   

                   } // termina for entidades
                   //alert(granTotalElementos);
                      dataTable+="<tr><td colspan='5' bgcolor='#FFCCCC'>GRAN TOTAL</td><td bgcolor='#FFCCCC' id='granTotalElementos'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='granTotalTurnosPresupuestados'>Total</td><td bgcolor='#FFCCCC' id='granTotalCostoTurno'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='granCobroPresupuestado'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='granTotalTurnosPagados'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='diferenciaTurnos'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='granTotalPagoNomina'>Total</td>";
                      dataTable+="<td bgcolor='#FFCCCC' id='perdidaUtilidad'>Total</td></tr>";
                   $('#tableReporteCobertura1').append(dataTable);

                   
                   
                   realizarSumatoriaFinal = true;
                   $( document ).ajaxStop (function () {
                       if (realizarSumatoriaFinal == true)
                       {
                           // Poner la bandera de realizar la sumatoria en false para que en 
                           // llamadas posteriores del ajax no se actualice la gran sumatoria.
                           realizarSumatoriaFinal = false;
                           
                            console.log ("Finalizaron las llamadas ajax. Realizar la Gran sumatoria");

                            granTotalTurnosPresupuestados = 0;
                            $.each( totalTurnosAlMes, function( key, value ) {
                                granTotalTurnosPresupuestados += value;
                            });
                            
                            granTotalElementos = 0;
                            $.each( totalElementosEntidad, function( key, value ) {
                                granTotalElementos += value;
                            });
                            
                            granTotalCostoTurno = 0;
                            $.each( totalCostoTurno, function( key, value ) {
                                granTotalCostoTurno += value;
                            });
                            
                            granCobroPresupuestado = 0;
                            $.each( totalCobroPresupuestado, function( key, value ) {
                                granCobroPresupuestado += value;
                            });
                            
                            granTotalTurnosPagados = 0;
                            $.each( totalTurnosPagados, function( key, value ) {
                                granTotalTurnosPagados += value;
                            });
                            
                            granTotalPagoNomina = 0;
                            $.each( totalMontoPagado, function( key, value ) {
                                granTotalPagoNomina += value;
                            });
                
                            /*
                            granTotalTurnosPresupuestados+=totalTurnosAlMes[response.idEntidadFederativa];
                            granTotalElementos+=totalElementosEntidad[response.idEntidadFederativa];
                            granTotalCostoTurno+=totalCostoTurno[response.idEntidadFederativa];
                            granCobroPresupuestado+=totalCobroPresupuestado[response.idEntidadFederativa];
                            granTotalTurnosPagados+=totalTurnosPagados[response.idEntidadFederativa];
                            granTotalPagoNomina+=totalMontoPagado[response.idEntidadFederativa];
                            */
                          
                            $("#granTotalElementos").html(granTotalElementos);
                            $("#granTotalTurnosPresupuestados").html(granTotalTurnosPresupuestados);
                            $("#granTotalCostoTurno").html(parseFloat(granTotalCostoTurno).toFixed(2));
                            $("#granCobroPresupuestado").html(parseFloat(granCobroPresupuestado).toFixed(2));
                            $("#granTotalTurnosPagados").html(granTotalTurnosPagados);

                            diferenciaTurnos=parseInt(granTotalTurnosPresupuestados)-parseInt(granTotalTurnosPagados);
                            $("#diferenciaTurnos").html(diferenciaTurnos);
                            $("#granTotalPagoNomina").html(parseFloat(granTotalPagoNomina).toFixed(2));
                            perdidaUtilidad=parseInt(granCobroPresupuestado)-parseInt(granTotalPagoNomina);
                            $("#perdidaUtilidad").html(parseFloat(perdidaUtilidad).toFixed(2));
                            waitingDialog.hide();  
                       }
                   });
                   
                  } // if (response.status == success)
                  
                  
            },
            error: function (response)
            {
                //console.log (response);
            }
        });
  }
  
  var realizarSumatoriaFinal = false;
  
  var totalTurnosAlMes = {};
  var totalCostoTurno = {};
  var totalTurnosPagados = {};
  var totalElementosEntidad={};
  var diferenciaTurnosEntidad={};
  var totalCobroPresupuestado={};
  var totalMontoPagado={};
  var totalPerdidaUtilidad={};
  var granTotalElementos=0;
  var granTotalTurnosPresupuestados=0;
  var granTotalCostoTurno=0;
  var granCobroPresupuestado=0;
  var granTotalTurnosPagados=0;
  var diferenciaTurnos=0;
  var granTotalPagoNomina=0;
  var perdidaUtilidad=0;


   function consultaDetallesCobertura(puntoServicioId, puestoId, month, year,idEntidadFederativa){
    //var detalle="<td>"+puntoServicioId+"</td><td>"+puestoId+"</td>";
    //return detalle;
    ///alert(idEntidadFederativa);

        // reincia las variables de calculo de totales
        totalTurnosAlMes = {};
        totalCostoTurno = {};
        totalTurnosPagados = {};
        totalElementosEntidad={};
        diferenciaTurnosEntidad={};
        totalCobroPresupuestado={};
        totalMontoPagado={};
        totalPerdidaUtilidad={};
        granTotalElementos=0;
        granTotalTurnosPresupuestados=0;
        granTotalCostoTurno=0;
        granCobroPresupuestado=0;
        granTotalTurnosPagados=0;
        diferenciaTurnos=0;
        granTotalPagoNomina=0;
        perdidaUtilidad=0;
        
        
    
           $.ajax({
            type: "POST",
            url: "ajax_getDetallesCoberturaByPuntoPuesto.php",
            data : {"month":month, "year":year, "puntoServicioId":puntoServicioId,"puestoId":puestoId , "idEntidadFederativa":idEntidadFederativa},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {

                  var totalElementos = response.totalElementos;
                  //var totalTurnosDiarios = response.totalTurnosDiarios;
                  var turnosPeriodo= response.turnosPeriodo;
                  var costoPorTurno=response.costoPorTurno;
                  var turnosPagadosNomina=response.turnosPagadosNomina;
                  var diferenciaTurnos=parseInt(turnosPeriodo)-parseInt(turnosPagadosNomina);
                  var cobroPresupuestado=parseInt(turnosPeriodo*costoPorTurno);
                  var montoPagado=parseFloat(response.montoPagado).toFixed(2);
                  var diferenciaMontoPagado=parseFloat(cobroPresupuestado).toFixed(2)-parseFloat(response.montoPagado).toFixed(2);


                  $("#td_pp_"+puntoServicioId+"_"+puestoId).html(totalElementos);
                  $("#td_pp_"+puntoServicioId+"_"+puestoId).attr("elementos", totalElementos);
                  //$("#td_pp_td"+puntoServicioId+"_"+puestoId).html(totalTurnosDiarios);
                  $("#td_pp_tt"+puntoServicioId+"_"+puestoId).html(turnosPeriodo);
                  $("#td_pp_ct"+puntoServicioId+"_"+puestoId).html(costoPorTurno);
                  $("#td_turnos_nomina"+puntoServicioId+"_"+puestoId).html(turnosPagadosNomina);
                  $("#td_diferencia_turnos"+puntoServicioId+"_"+puestoId).html(diferenciaTurnos);
                  $("#td_cobro_presupuestado"+puntoServicioId+"_"+puestoId).html(cobroPresupuestado);
                  $("#td_monto_Pagado"+puntoServicioId+"_"+puestoId).html(montoPagado);
                  $("#td_diferencia_Monto_Pagado"+puntoServicioId+"_"+puestoId).html(parseFloat(diferenciaMontoPagado).toFixed(2));

                  

                  if (totalTurnosAlMes.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalTurnosAlMes[response.idEntidadFederativa] = 0;
                  }
                  
                  if (totalCostoTurno.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalCostoTurno[response.idEntidadFederativa] = 0;
                  }
                  
                  if (totalTurnosPagados.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalTurnosPagados[response.idEntidadFederativa] = 0;
                  }
                  if (totalElementosEntidad.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalElementosEntidad[response.idEntidadFederativa] = 0;
                  }
                  if (diferenciaTurnosEntidad.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      diferenciaTurnosEntidad[response.idEntidadFederativa] = 0;
                  }

                  if (totalCobroPresupuestado.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalCobroPresupuestado[response.idEntidadFederativa] = 0;
                  }
                  if (totalMontoPagado.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalMontoPagado[response.idEntidadFederativa] = 0;
                  }
                  if (totalPerdidaUtilidad.hasOwnProperty (response.idEntidadFederativa) == false)
                  {
                      totalPerdidaUtilidad[response.idEntidadFederativa] = 0;
                  }

                  totalTurnosAlMes[response.idEntidadFederativa] += parseFloat (turnosPeriodo);        
                  totalCostoTurno[response.idEntidadFederativa] +=  parseFloat (costoPorTurno);        
                  totalTurnosPagados[response.idEntidadFederativa] +=  parseFloat (turnosPagadosNomina);  
                  diferenciaTurnosEntidad[response.idEntidadFederativa] +=  parseFloat (diferenciaTurnos);  
                  totalCobroPresupuestado[response.idEntidadFederativa] +=  parseFloat (cobroPresupuestado);
                  totalElementosEntidad[response.idEntidadFederativa] +=  parseFloat (totalElementos);
                  totalMontoPagado[response.idEntidadFederativa] +=  parseFloat (montoPagado);
                  totalPerdidaUtilidad[response.idEntidadFederativa] +=  parseFloat (diferenciaMontoPagado);

                  
                  //alert( totalTurnosAlMes[response.idEntidadFederativa]);
                  $("#totalTurnosAlMes_" + response.idEntidadFederativa).html(totalTurnosAlMes[response.idEntidadFederativa]);
                  $("#totalTurnosAlMes_" + response.idEntidadFederativa).attr("totalTurnosAlMes",totalTurnosAlMes[response.idEntidadFederativa]);

                  $("#totalCostoTurno_" + response.idEntidadFederativa).html(totalCostoTurno[response.idEntidadFederativa].toFixed(2));
                  $("#totalCobroPresupuestado_" + response.idEntidadFederativa).html(parseFloat(totalCobroPresupuestado[response.idEntidadFederativa]).toFixed(2));

                  
                  $("#totalTurnosPagados_" + response.idEntidadFederativa).html(totalTurnosPagados[response.idEntidadFederativa]);
                  $("#totalElementosAlMes_" + response.idEntidadFederativa).html(totalElementosEntidad[response.idEntidadFederativa]);
                  $("#totalElementosAlMes_" + response.idEntidadFederativa).attr("totalElementosAlMes",totalElementosEntidad[response.idEntidadFederativa]);
                  $("#diferenciaTurnosEntidad_" + response.idEntidadFederativa).html(diferenciaTurnosEntidad[response.idEntidadFederativa]);
                  $("#totalMontoPagado_" + response.idEntidadFederativa).html(parseFloat(totalMontoPagado[response.idEntidadFederativa]).toFixed(2));
                  $("#totalPerdidaUtilidad_" + response.idEntidadFederativa).html(parseFloat(totalPerdidaUtilidad[response.idEntidadFederativa]).toFixed(2));
                }
            },
            error: function (response)
            {
                //console.log (response);
            }
        });
          
   }

  








     $("#descargarReporteCobertura").click(function(event) {
     $("#datos_reporteCobertura").val( $("<div>").append( $("#divTableReporteCobertura1").eq(0).clone()).html());
     $("#form_reporteCoberturaCosto").submit();
      });


</script>

