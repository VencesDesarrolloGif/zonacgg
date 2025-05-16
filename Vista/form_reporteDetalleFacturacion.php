<?php
 $fechaMinima="2022-01-01";
 $fechaInicio=strtotime($fechaMinima);
 $anioConsultaInicio=date('Y',$fechaInicio);
 $anioActual= DATE('Y');    
?><div class="container" align="center" >
    <form class="form-horizontal" id="form_consultaReporteDetalle" name="form_consultaReporteDetalle" action="ficheroExportReporteDetalle.php" target="_blank" method="post">
        <div><center>
            <select id="selectClienteReporte" name="selectClienteReporte" class="selectpicker" data-live-search="true" class="input-large" data-size="9">
                      <option value="0">CLIENTE</option>
                      <option>TODOS</option>
                      <?php
                        for ($i = 0; $i < count($catatoloClientes); $i++) {
                            echo "<option value='" . $catatoloClientes[$i]["idCliente"] . "'>" . $catatoloClientes[$i]["razonSocial"] . " </option>";
                        }
                      ?>
                    </select><br><br>
            
            <select id="selectTipoConsultaDF" name="selectTipoConsultaDF" data-live-search="true" class="input-large" data-size="9">
              <option value="0">TIPO</option>
              <option value="1">SEMANAL</option>
              <option value="2">QUINCENAL</option>
              <option value="3">MENSUAL</option>
            </select>

            <select id="selectEjercicioDF" name="selectEjercicioDF" data-live-search="true" class="input-large" data-size="9">
                      <option value="0">EJERCICIO</option>
                      <?php
                        for($i = $anioConsultaInicio; $i <= $anioActual; $i++) {                                
                          echo "<option value='" . $i. "'>" . $i. " </option>";
                        }
                      ?>
            </select>

            <select id="selectMesDF" name="selectMesDF"  data-live-search="true" class="input-extralarge">
              <option value="0">MES</option>
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
            <br>
            <br>
            <div id="divSelectSemana" style="display: none;">
              <select id="selectSemanaDF" name="selectSemanaDF">
                <option value="0">SEMANA</option>
              </select>
            </div>

            <div id="divSelectQuincena" style="display: none;">
              <select id="selectQuincenaDF" name="selectQuincenaDF">
                <option value="0">QUINCENA</option>
              </select>
            </div>

            <br><br>
            <button class="btn btn-primary" type="button" onclick="seleccionarReporte();"> Generar Reporte</button>
        
        </div><br><br>
        
        <input type="hidden" id="datos_reporte" name="datos_reporte"/>

        <div id="divReporteDetalle" name="divReporteDetalle" align="center" class='container'><br><br><br><br>
          <div id="divTableReporteDetalle" name="divTableReporteDetalle"></div><br><br>
        </div><br><br><br><br>

        <div align="left" style="display:none;" id="mensajeCostoTurno">
          <h5>Recuerda  que el Costo Turno no es promedio, se genera por plantilla y el costo mostrado es de la plantilla activa(el detalle se visualiza en el pie de este reporte).</h6>
        </div>

        <table id="tableReporteGeneral" name="tableReporteGeneral" class='table table-bordered table-striped'></table>
        <br>
        <button style="display:none;" id="descargarReporteDetalle" name="descargarReporteDetalle" class="btn btn-success" type="button"><span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button><br><br>
        
        <table id="tableReporteGraficas" name="tableReporteGraficas" class='table table-bordered table-striped'></table>
        <br>
        <button style="display:none;" id="descargarReportePB" name="descargarReportePB" class="btn btn-success" type="button"><span class="glyphicon glyphicon-download-alt"></span>Descargar Excel Power BI</button>
        <br>
        <br>
    </form>
</div> <!-- fin div container -->

<script type="text/javascript">

var contadorTurnos=0;
var consulta=0;
var listaTablaGraficas="";

$("#selectTipoConsultaDF").change(function(event) {
  var tipoConsulta = $("#selectTipoConsultaDF").val();
  $("#selectSemanaDF").empty(); 
  $("#selectSemanaDF").append('<option value="0">SEMANA</option>');
  $("#selectQuincenaDF").empty(); 
  $("#selectQuincenaDF").append('<option value="0">QUINCENA</option>');
  $("#selectMesDF").val(0);

  if(tipoConsulta=='0' || tipoConsulta=='3'){
    $("#divSelectSemana").hide();
    $("#divSelectQuincena").hide();
  }if(tipoConsulta=='1'){
      $("#divSelectSemana").show();
      $("#divSelectQuincena").hide();
  }if(tipoConsulta=='2'){
      $("#divSelectSemana").hide();
      $("#divSelectQuincena").show();
  }
});

$("#selectMesDF").change(function(event) {

  var tipoConsulta = $("#selectTipoConsultaDF").val();
  var ejercicio = $("#selectEjercicioDF").val();
  var mes = $("#selectMesDF").val();
  
  var ultimoDia = new Date(ejercicio,mes, 0).getDate();
  
  if(tipoConsulta=='1'){
    $("#selectSemanaDF").empty(); 
    $("#selectSemanaDF").append('<option value="0">SEMANA</option>');
    $("#selectSemanaDF").append('<option value="1">01-07</option>');
    $("#selectSemanaDF").append('<option value="2">08-14</option>');
    $("#selectSemanaDF").append('<option value="3">15-21</option>');
    $('#selectSemanaDF').append('<option value="4">22-'+ultimoDia+'</option>');

  }if(tipoConsulta=='2'){
    $("#selectQuincenaDF").empty(); 
    $("#selectQuincenaDF").append('<option value="0">QUINCENA</option>');
    $("#selectQuincenaDF").append('<option value="1">01-15</option>');
    $('#selectQuincenaDF').append('<option value="2">16-'+ultimoDia+'</option>');
  }
});

function seleccionarReporte(){

  var tipoConsulta= $("#selectTipoConsultaDF").val();
  var fecha1="";
  var fecha2="";


  if(tipoConsulta=='0'){
    swal("Atencion","ELIJA CUAL ES SU TIPO DE BUSQUEDA","warning");
  }else{

    var mes = $("#selectMesDF").val();
    var ejercicio= $("#selectEjercicioDF").val();
    
    if(ejercicio=="0"){
      swal("Atencion","ELIJA EJERCICIO CONSULTAR","warning");
    }else if(mes=="0"){
              swal("Atencion","ELIJA MES CONSULTAR","warning");
    }else{
          if(tipoConsulta=='1'){
            var semana= $("#selectSemanaDF").val();  
            var semanaTxt= $('select[name="selectSemanaDF"] option:selected').text();
            if(semana=='0'){
              swal("Atencion","ELIJA LA SEMANA A CONSULTAR","warning");
            }else{
              var splitUltimoDia= semanaTxt.split("-");
              var diaUno=splitUltimoDia[0];
              var ultimoDia=splitUltimoDia[1];
              fecha1= ejercicio+"-"+mes+"-"+diaUno;
              fecha2= ejercicio+"-"+mes+"-"+ultimoDia;
            }

          }if(tipoConsulta=='2'){
            var quincena= $("#selectQuincenaDF").val();
            var quincenaTxt= $('select[name="selectQuincenaDF"] option:selected').text();
            if(quincena=="0"){
              swal("Atencion","ELIJA LA QUINCENA A CONSULTAR","warning");
            }else{
              var splitUltimoDia15na= quincenaTxt.split("-");
              var DiaUno15na=splitUltimoDia15na[0];
              var ultimoDia15na=splitUltimoDia15na[1];
              fecha1= ejercicio+"-"+mes+"-"+DiaUno15na;
              fecha2= ejercicio+"-"+mes+"-"+ultimoDia15na;
            }
          }

          if(tipoConsulta=='3'){
            var ultimoDiaMes = new Date(ejercicio,mes, 0).getDate();
            fecha1= ejercicio+"-"+mes+"-01";
            fecha2= ejercicio+"-"+mes+"-"+ultimoDiaMes;
          }

          var idClientePunto= $("#selectClienteReporte").val();

          if(idClientePunto==0){
             swal("Atencion","ELIJA EL CLIENTE A CONSULTAR","warning");
          }else if(idClientePunto!='TODOS' && idClientePunto!=0){
            if(tipoConsulta=='1'){
              var diasElegidos=semana;
            }
            if(tipoConsulta=='2'){
              var diasElegidos=quincena;
            }
            if(tipoConsulta=='3'){
              var diasElegidos="mes";
            }

            crearTablaDetalleReporte(idClientePunto,tipoConsulta,fecha1,fecha2,diasElegidos);
          }else{
            if(tipoConsulta=='1'){
              var diasElegidos=semana;
            }
            if(tipoConsulta=='2'){
              var diasElegidos=quincena;
            }
            if(tipoConsulta=='3'){
              var diasElegidos="mes";
            }
            consulta=0;
            consultaClientes(fecha1,fecha2,tipoConsulta,diasElegidos);
          }
    }
  }//else tipo consulta
}

function crearTablaDetalleReporte(idClientePunto,tipoConsulta,fecha1,fecha2,diasElegidos){
  
  waitingDialog.show();
  $("#mensajeCostoTurno").hide();
  $("#descargarReporteDetalle").hide();
  $("#descargarReportePB").hide();
  $("#tableReporteGeneral").hide();
  $("#tableReporteGraficas").hide();
  $.ajax({
        type: "POST",
        url: "ajax_reporteIngresoByCliente.php",
        data : {"fecha1":fecha1, "fecha2":fecha2, idClientePunto:idClientePunto,"tipoConsulta":tipoConsulta,"diasElegidos":diasElegidos},
        dataType: "json",
        success: function(response){
          if(response.status == "success"){
            var lista = response.lista;
            var listaGraf = response.listaGrafica;
            var result = "";
            var nombreEntidadFederativaE="";
            $("#mensajeCostoTurno").show();
            $("#descargarReporteDetalle").show();
            $("#descargarReportePB").show();
            $("#tableReporteGeneral").show();
            $("#tableReporteGraficas").show();
            //ENCABEZADO DE FECHA
            moment.locale('Es');
            var dateTime = moment(fecha1);
            var fullTime = dateTime.format('LL');
            var dateTime2 = moment(fecha2);
            var fullTime2 = dateTime2.format('LL');
            var turnosCliente=0;
            var cobroCliente=0;
            var turnosPresupuestadosCliente=0;
            var totalTurnosPresupuestoCliente=0;
            var cobroPresupuestadosCliente=0;

            listaTable="";
            var totalTurnosPresupuestados = 0;
            var totalTurnosPresupuesto=0;
            var totalCobroPresuppuestado=0;
            var totalTurnosCubiertos=0;
            var totalCobroByCobertura=0;
            var pagoNominaTotal=0;
            var pagoNominaTotalEntidad=0;
            var pagoNominaTotalCliente=0;

            //NUEVOS CAMPOS DE SUA (EMA)
            var totalDiasImssEntidad=0;
            var totalPagoSuaEntidad=0

            //CAMPOS PARA LA EBA
            var totalDiasEbaEntidad=0;
            var totalSumaEbaEntidad=0
            var totalSumaInfonavitEntidad=0
            var totalDiasInfoCliente=0;
            var totalPagoEbaCliente=0;
            var totalInfonavitCliente=0;
            var totalDiasImssCliente=0;
            var totalPagoSuaCliente=0;

            //VARIABLES DE COSTO UNIFORMES
            var totalUniformesEntidad=0;
            var totalUniformesCliente=0;

            //VARIABLES FACTURACION
            var turnosFacEntidad=0;
            var turnosFacCliente=0;
            var montoFacEntidad=0;
            var montoFacCliente=0;

            //contadora de elementos
            var totalGastoEntidad=0;
            var totalGastoCliente=0;

            var totalTurnos=0;
            var totalTurnosEntidad=0;
            var totalTurnosCliente=0;
            var promedio=0.0;
            listaTablaGraficas="";
            var a=0;
            listaTable+= "<tr><td style='background-color:#5ECFF3; text-align:center ;font-size:x-large; font-weight: bold;display:none;' colspan='32'> PERIODO: "+fullTime+" AL "+fullTime2+"</td></tr>";
            
            listaTablaGraficas+="<tr style='text-align:center ; font-weight: bold;'><td>Entidad</td><td>Punto de Servicio</td><td>Fecha inicio plantilla</td><td>Fecha Termino Plantilla</td><td>Cobra 31</td><td>Flat</td><td>Elementos Plantilla</td><td>Costo por Turno</td><td>ID Punto de Servicio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Estatus Punto de Servicio</td><td>ID Plantilla</td><td>Estatus Plantilla</td><td>Presupuesto Cobertura</td><td>Turnos de Dia Totales</td><td>Turnos de Noche Totales</td><td>Turnos Cubiertos Dia</td><td>Turnos Cubiertos Noche</td>   <td>Porcentaje Cubierto Dia</td><td>Porcentaje Cubierto Noche</td><td>Porcentaje Cubierto General</td></tr>";
                    
            for(var i in listaGraf){
              // agregado
              var nombrePuntoServ = listaGraf[i]["nombrePunto"];
              var puntoServ = listaGraf[i]["PuntoServicio"];
              var plantilla = listaGraf[i]["plantilla"];
              var statusPsID= listaGraf[i]["statusps"];
              var statusPlID= listaGraf[i]["statusplantilla"];
              var entidadPS = listaGraf[i]["entidadPS"];
              var rolOp2    = listaGraf[i]["rolOperativo2"];
              var rolOpCom2 = listaGraf[i]["rolOperativoCompleto2"];
              var puesto2   = listaGraf[i]["descripcionPuesto"];
              var noElementos = listaGraf[i]["noElementos"];
              var fechaInicioPL = listaGraf[i]["fechaInicioPL"];
              var fechaFinPL = listaGraf[i]["fechaFinPL"];
              var cobra31 = listaGraf[i]["cobra31"];
              var flat = listaGraf[i]["flat"];
              var costoPorTurnoPL = listaGraf[i]["costoPorTurnoPL"];


              if(statusPsID=='1'){
                  var statusPs="ACTIVO";
              }else if (statusPsID=='0'){
                  var statusPs="BAJA";
              }
              
              if(statusPlID=='1'){
                  var statusPl="ACTIVA";
              }else if (statusPlID=='0'){
                  var statusPl="BAJA";
              }

              var turnosXDiaGenerales = listaGraf[i][plantilla]["turnosXDia"];
              var turnoDiaTotales     = listaGraf[i][plantilla]["turnoDiaTotales"];
              var turnosNocheTotales  = listaGraf[i][plantilla]["turnosNocheTotales"];
              var turnosCubiertosDia  = listaGraf[i][plantilla]["turnosCubiertosDia"];
              var turnosCubiertosNoche= listaGraf[i][plantilla]["turnosCubiertosNoche"];

              if((turnoDiaTotales ==0 && turnosCubiertosDia>=0) || (turnoDiaTotales ==0 && turnosCubiertosDia==0)){
               var porcentajeTurnosDia=100;
              }else{
                   var porcentajeTurnosDiaComp=(turnosCubiertosDia/turnoDiaTotales)*100;
                   var porcentajeTurnosDia= porcentajeTurnosDiaComp.toFixed(0); 
              }

              if((turnosNocheTotales ==0 && turnosCubiertosNoche>=0) || (turnosNocheTotales ==0 && turnosCubiertosNoche==0)){
               var porcentajeTurnosNoche=100;
              }else{
                   var porcentajeTurnosNocheComp=(turnosCubiertosNoche/turnosNocheTotales)*100;
                   var porcentajeTurnosNoche= porcentajeTurnosNocheComp.toFixed(0); 
              }
                      
              var sumaTurnosCubiertos= turnosCubiertosDia+turnosCubiertosNoche;

              if(turnosXDiaGenerales ==0 && sumaTurnosCubiertos>=0){
                var porcentajeGeneralCobertura=100;
              }else{
                    var porcentajeGeneralCoberturaComp=(sumaTurnosCubiertos/turnosXDiaGenerales)*100;
                    var porcentajeGeneralCobertura= porcentajeGeneralCoberturaComp.toFixed(0); 
              }//ya
              
              listaTablaGraficas += "<tr>";
              listaTablaGraficas += "<td>" +entidadPS+"</td>";
              listaTablaGraficas += "<td>" +nombrePuntoServ+"</td>";
              listaTablaGraficas += "<td>" +fechaInicioPL+"</td>";
              listaTablaGraficas += "<td>" +fechaFinPL+"</td>";
              listaTablaGraficas += "<td>" +cobra31+"</td>";
              listaTablaGraficas += "<td>" +flat+"</td>";
              listaTablaGraficas += "<td>" +noElementos+"</td>";
              listaTablaGraficas += "<td>" +costoPorTurnoPL+"</td>";
              listaTablaGraficas += "<td>" +puntoServ+"</td>";
              listaTablaGraficas += "<td>" +puesto2+"</td>";
              listaTablaGraficas += "<td>" +rolOp2+"</td>";
              listaTablaGraficas += "<td>" +rolOpCom2+"</td>";
              listaTablaGraficas += "<td>" +statusPs+"</td>";
              listaTablaGraficas += "<td>" +plantilla+"</td>";
              listaTablaGraficas += "<td>" +statusPl+"</td>";
              listaTablaGraficas += "<td>" +turnosXDiaGenerales+"</td>";
              listaTablaGraficas += "<td>" +turnoDiaTotales+"</td>";
              listaTablaGraficas += "<td>" +turnosNocheTotales+"</td>";
              listaTablaGraficas += "<td>" +turnosCubiertosDia+"</td>";
              listaTablaGraficas += "<td>" +turnosCubiertosNoche+"</td>";
              listaTablaGraficas += "<td>" +porcentajeTurnosDia+"</td>";
              listaTablaGraficas += "<td>" +porcentajeTurnosNoche+"</td>";
              listaTablaGraficas += "<td>" +porcentajeGeneralCobertura+"</td>";
              listaTablaGraficas += "</tr>";

              $('#tableReporteGraficas').html(listaTablaGraficas);
            }//FOR var i in listaGraf
            // fin agregado

            for(var i in lista){
              
              var nombreEntidadFederativa= lista[i].Entidad;
              var idEstado=lista[i].idEstado;
              var fechaInicio=lista[i].fechaInicio;
              var fechaTermino=lista[i].fechaTermino;
              var idPuntoServicioNom=lista[i].idPuntoServicio;
              var nombrePuntoServicio=lista[i].PuntoServicio;
              var puestoCobertura=lista[i].idPuesto;
              var roloperativo =lista[i].rolOperativo;

              var cobra31   =lista[i].cobra31;
              var turnosFlat=lista[i].turnosFlat;
              // var diasFlat  =lista[i].diasFlat;      
              var fechaInicioPlantilla  =lista[i].fechaInicioPlantilla;      
              var fechaFinPlantilla  =lista[i].fechaFinPlantilla;      
              var turnosPresupuesto  =lista[i].turnosPresupuesto;      

              if(nombreEntidadFederativaE!=nombreEntidadFederativa){
                promedio=parseFloat(calculoSumaGastoEntidad(idEstado,fecha1,fecha2));
                if(totalTurnosPresupuestados > 0){
                  var porcentajeTurnosT=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                  listaTable += "<tr>";
                  listaTable += "<td colspan='14'>Total Entidad:</td>";//por entidad
                  listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuesto+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                  listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                  listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
                  listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                  listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosT.toFixed(2)+" %</td>";
                  listaTable += "</tr>";
                }
                listaTable+= "<tr><td style='background-color:#BDBDBD; text-align:center ; font-weight: bold;' colspan='32'>"+nombreEntidadFederativa+" </td></tr>";
                listaTable+="<tr style='text-align:center ; font-weight: bold;'><td>#Elementos</td><td>Linea Negocio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Punto Servicio</td><td>Region</td><td>Supervisor a Cargo</td><td>#Centro de Costo</td><td>Cuenta contable</td>";
                listaTable+="<td>Entidad</td><td>Fecha inicio</td><<td>Fecha fin</td><td>Costo Turno</td>";
                listaTable+="<td style='background-color:#AED6F1;'>Turnos Presupuesto</td>";
                listaTable+="<td style='background-color:#FFFF00;'>Presupuesto Cobertura</td> <td style='background-color:#05F9AB;'>Cobro Presupuestado</td><td style='background-color:#FFFF00;'>Turnos Cubiertos Perfil</td><td style='background-color:#05F9AB;'>Cobro Cobertura</td><td>Diferencia Turnos</td><td style='background-color:#05F9AB;'>Diferencia $</td><td style='background-color:#F7AC20;'>Turnos Pagados</td><td style='background-color:#F7AC20;'>$ Pago Nomina</td><td>Dias Imss</td><td>Pago Sua</td><td style='background-color:#F7CCCC;'>Dias EBA</td><td style='background-color:#F7CCCC;'>Suma EBA</td><td style='background-color:#F7CCCC;'>Suma Infonavit</td><td style='background-color:#89E0F9;'>Costo Uniformes</td><td style='background-color:#89E0F9;'>Gasto</td><td style='background-color:#FFFF00;'>Cobertura %</td></tr>"; // <td style='background-color:#FFFF00;'>Cobertura %</td> agregar cuando este bien
                nombreEntidadFederativaE=nombreEntidadFederativa;
                totalTurnosPresupuestados = 0;
                totalTurnosPresupuesto=0;
                totalCobroPresuppuestado=0;
                totalTurnosCubiertos=0;
                totalCobroByCobertura=0;
                pagoNominaTotalEntidad=0;
                totalTurnosEntidad=0;
                
                //CAMPOS SUA
                totalDiasImssEntidad=0;
                totalPagoSuaEntidad=0

                //CAMPOS EBA
                totalDiasEbaEntidad=0;
                totalSumaEbaEntidad=0;
                totalSumaInfonavitEntidad=0;

                //CAMPOS FACTURACION
                turnosFacEntidad=0;
                montoFacEntidad=0;

                //CAMPOS COSTO UNIFORMES
                totalUniformesEntidad=0;
                totalGastoEntidad=0;
              }
              
              var turnosCubiertos=getCoberturaPerfil(lista[i].asistencia, lista[i].cobraDescansos, lista[i].cobraDiaFestivo, lista[i].cobra31);
              var cobroCobertura= turnosCubiertos*lista[i].CostoTurno;
              var turnosPresupuestados=lista [i].turnosPresupuestadosPeriodo;
              if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                var cobroPresupuestado = lista [i].CostoTurno*turnosPresupuesto;
              }else{
                var cobroPresupuestado=lista [i].cobroPresupuestado;
              }
              var diferenciaCobro=(cobroPresupuestado-cobroCobertura)* -1;
              var diferenciaTurnosEntidad=0;
              var diferenciaCobroEntidad=0;
              pagoNominaTotal= obtenerNominaTotalPuntoServicio(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);
              // console.log(pagoNominaTotal);

              //FUNCION QUE TRAE LOS COSTOS DE SUA POR PUNTO DE SERVICIO
              valoresEma= obtenerTotalesEma (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

              //FUNCION PARA OBTENER EL TOTAL DE COSTO EN ASIGNACIÓN DE UNIFORMES PARA EL PUNTO DE SERVICIO
              var costoUniformes=parseFloat(obtenerCostoUniformes(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo));

              //FUNCION PARA OBTENER GASTO POR ENTIDAD
              var gastoElemento=parseFloat(promedio*lista [i].numEle);

              var diasImss=valoresEma.totalDias;
              var pagoSua= valoresEma.totalPago;

              //OBTENCION DE DATOS PARA EBA
              var valoresEva= obtenerTotalesEva (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);
              var diasInfo=valoresEva.totalDias;
              var suma1= valoresEva.totalSuma1;
              var sumaInfo= valoresEva.totalInfonavit;
              totalTurnos=contadorTurnos;
              contadorTurnos=0;
              
              valores=obtenerDatosmontoturnosfacturados(idPuntoServicioNom,puestoCobertura,fecha1,fecha2,roloperativo);
              var TurnosFacturadoos=valores.TurnosFacturados;
              var montoFacturado=valores.montoFacturado;
              TurnosFacturadoos=parseInt(TurnosFacturadoos);
              montoFacturado=parseFloat(montoFacturado);

              listaTable += "<tr>";
              listaTable += "<td>" + lista [i].numEle + "</td>";
              listaTable += "<td>" + lista [i].LineaNegocio +"</td>";
              listaTable += "<td>" + lista [i].Puesto +"</td>";
              listaTable += "<td>" + lista [i].Rol + "</td>";
              listaTable += "<td>" + lista [i].rolOperativo + "</td>";
              listaTable += "<td>" + lista [i].PuntoServicio + "</td>";
              listaTable += "<td>" + lista [i].region + "</td>";
              listaTable += "<td>" + lista [i].supervisor + "</td>";
              listaTable += "<td>" + lista [i].centroCosto + "</td>";
              listaTable += "<td>" + lista [i].claveClienteNomina + "</td>";
              listaTable += "<td>" + lista [i].Entidad + "</td>";
              listaTable += "<td>" + fechaInicio + "</td>";
              listaTable += "<td>" + fechaTermino + "</td>"; 
              listaTable += "<td>" + lista [i].CostoTurno + "</td>";


              if(turnosCubiertos=='0' && (lista [i].turnosPresupuestadosPeriodo)=='0'){
                var porcentajeTurnos='0'
              }else{
                if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                  var porcentajeTurnos1=(turnosCubiertos / (turnosPresupuesto))*100;
                }else{
                  var porcentajeTurnos1=(turnosCubiertos / (lista [i].turnosPresupuestadosPeriodo))*100;
                }
                  var porcentajeTurnos= porcentajeTurnos1.toFixed(2);
              }

              listaTable += "<td style='background-color:#AED6F1;'>" + turnosPresupuesto + "</td>";//lo que va en cada columna de las plantillas
              if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                listaTable += "<td style='background-color:#FFFF00;'>" + turnosPresupuesto + "</td>";// por peticion solo para 12x12x5
                listaTable += "<td style='background-color:#05F9AB;'>" +format((lista [i].CostoTurno*turnosPresupuesto),2)+"</td>";
                var diferenciaTurnos= parseInt(turnosPresupuesto)- parseInt(turnosCubiertos);
              }else{
                listaTable += "<td style='background-color:#FFFF00;'>" + lista [i].turnosPresupuestadosPeriodo + "</td>";
                listaTable += "<td style='background-color:#05F9AB;'>" +format(lista [i].cobroPresupuestado,2)+"</td>";
                var diferenciaTurnos= parseInt(turnosPresupuestados)- parseInt(turnosCubiertos);
              }              
              listaTable += "<td style='background-color:#FFFF00;'>" +turnosCubiertos+"</td>";
              listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCobertura,2)+"</td>";
              a++;
              listaTable += "<td>" +diferenciaTurnos * -1 +"</td>";
              listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobro,2)  +"</td>";
              listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnos+"</td>";//aqui ya no cuentan el descuento
              listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotal,2) +"</td>";
              listaTable += "<td>" +diasImss +"</td>";
              listaTable += "<td>" +format(pagoSua,2)+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +diasInfo+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +format(suma1,2)+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +format(sumaInfo,2)+"</td>";
              listaTable += "<td style='background-color:#89E0F9;'>" +format(costoUniformes,2)+"</td>";
              listaTable += "<td style='background-color:#89E0F9;'>" +format(gastoElemento,2)+"</td>";
              listaTable += "<td style='background-color:#FFFF00;'>" + porcentajeTurnos +" % </td>";

              // incrementamos la sumatoria
              totalTurnosPresupuesto+= lista [i].turnosPresupuesto;
              if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                totalTurnosPresupuestados+= lista [i].turnosPresupuesto;
                totalCobroPresuppuestado += lista [i].CostoTurno*turnosPresupuesto;
                turnosPresupuestadosCliente+=lista [i].turnosPresupuesto;
              }else{
                totalTurnosPresupuestados+= lista [i].turnosPresupuestadosPeriodo;
                totalCobroPresuppuestado += lista [i].cobroPresupuestado;
                turnosPresupuestadosCliente+=lista [i].turnosPresupuestadosPeriodo;

              }
              
              totalTurnosCubiertos += turnosCubiertos;
              totalCobroByCobertura+= cobroCobertura;
              totalTurnosEntidad += totalTurnos;
              totalTurnosCliente += totalTurnos;
              pagoNominaTotalEntidad += pagoNominaTotal;
              pagoNominaTotalCliente += pagoNominaTotal;

              //campos para ema
              totalDiasImssEntidad+=diasImss;
              totalPagoSuaEntidad +=pagoSua;

              totalDiasImssCliente+=diasImss;
              totalPagoSuaCliente +=pagoSua;

              //CAMPOS EBA
              totalDiasEbaEntidad+=diasInfo;
              totalSumaEbaEntidad+=suma1;
              totalSumaInfonavitEntidad+=sumaInfo;
              totalDiasInfoCliente +=diasInfo;
              totalPagoEbaCliente  +=suma1;
              totalInfonavitCliente+=sumaInfo;

              //CAMPOS FACTURACION
              turnosFacEntidad+=TurnosFacturadoos;
              turnosFacCliente+=TurnosFacturadoos;
              montoFacEntidad +=montoFacturado;
              montoFacCliente +=montoFacturado;

              //SUMATORIA PARA COSTOS UNIFORMES
              totalUniformesEntidad+=costoUniformes;
              totalUniformesCliente+=costoUniformes;

              //SUMATORIA TOTAL CLIENTE GASTO
              totalGastoEntidad+=gastoElemento;
              totalGastoCliente+=gastoElemento;
              turnosCliente+=turnosCubiertos;
              cobroCliente +=cobroCobertura;
              
              totalTurnosPresupuestoCliente+=lista [i].turnosPresupuesto;
              cobroPresupuestadosCliente +=cobroPresupuestado;
              diferenciaTurnosEntidad=(totalTurnosPresupuestados-totalTurnosCubiertos)*-1;
              diferenciaCobroEntidad =(totalCobroPresuppuestado-totalCobroByCobertura)*-1;
              listaTable += "</tr>";
            }

            if(totalTurnosPresupuestados > 0){
              var porcentajeTurnosTotal1=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
              listaTable += "<tr>";
              listaTable += "<td colspan='14'>Total Entidad:</td>";
              listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuesto+"</td>";
              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
              listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
              listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
              listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
              listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
              listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
              listaTable += "<td>" +totalDiasImssEntidad+"</td>";
              listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
              listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosTotal1.toFixed(2)+" %</td>";
              listaTable += "</tr>";
            }

            var porcentajeTurnosTotal2=(turnosCliente/turnosPresupuestadosCliente)*100;
            listaTable += "<tr>";
            listaTable += "<td colspan='14'>Total Completo:</td>";
            listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuestoCliente+"</td>";
            listaTable += "<td style='background-color:#FFFF00;'>" +turnosPresupuestadosCliente+"</td>";
            listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroPresupuestadosCliente,2)+"</td>";
            listaTable += "<td style='background-color:#FFFF00;'>" +turnosCliente+"</td>";
            listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCliente,2)+"</td>";
            listaTable += "<td>" +(turnosPresupuestadosCliente-turnosCliente)*-1+"</td>";
            listaTable += "<td style='background-color:#05F9AB;'>" +format((cobroPresupuestadosCliente-cobroCliente)*-1,2)+"</td>";
            listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosCliente+"</td>";
            listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalCliente,2)+"</td>";
            listaTable += "<td>" +totalDiasImssCliente+"</td>";
            listaTable += "<td>" +format(totalPagoSuaCliente,2)+"</td>";
            listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasInfoCliente+"</td>";
            listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalPagoEbaCliente,2)+"</td>";
            listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalInfonavitCliente,2)+"</td>";
            listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesCliente,2)+"</td>";
            listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoCliente,2)+"</td>";
            listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosTotal2.toFixed(2)+" %</td>";
            listaTable += "</tr>";
            $('#tableReporteGeneral').html(listaTable);
              waitingDialog.hide();
          }//termina if success
        },error: function(jqXHR, textStatus, errorThrown){
                  waitingDialog.hide();
                  alert(jqXHR.responseText);
        }
      });
}

function consultaClientes(fecha1,fecha2,tipoConsulta,diasElegidos){

  $("#tableReporteGeneral").find("tr:gt(0)").remove();
  $("#tableReporteGraficas").find("tr:gt(0)").remove();
  waitingDialog.show();

  $.ajax({
          type: "POST",
          url: "ajax_obtenerListaClientes.php",
          dataType: "json",
          success: function(response) {
            if(response.status == "success"){
              var listaClientes = response.listaClientes;
              var listaTableClientes="";
              var granTotalTurnosPresupuestados=0;
              var granTotalcobroPresupuestadosCliente=0;
              var granTotalturnosCliente=0;
              var granTotalcobroCliente =0;
              var granTotalNominaCliente=0;
              var granTotalTurnosCliente=0;
              var granTotalTurnosPresupuesto=0;

              //CAMPOS EMA
              var granTotalDiasImssCliente=0;
              var granTotalPagoSuaCliente =0;

              //CAMPOS EBA
              var granTotalDiasInfoCliente =0;
              var granTotalSumaInfoCliente =0;
              var granTotalInfonavitCliente=0;

              //CAMPOS FACTURACION
              var granTotalTurnosFacCliente=0;
              var granTotalMontoFacCliente =0;

              //CAMPOS COSTOS UNIFORMES
              var granTotalUniformesCliente=0;

              //CAMPO GASTO
              var granTotalGastoCliente=0;

              for( var i = 0; i < listaClientes.length; i++ ){
                var idClientePunto = listaClientes[i].idCliente;
                var razonSocial = listaClientes[i].razonSocial;
                listaTableClientes+= "<tr><td style='background-color:#BDBDBD; text-align:center ; font-weight: bold;' colspan='32'>"+idClientePunto+"-"+razonSocial+" </td></tr>";
                if(idClientePunto!=2){
                  var resultado=crearTablaDetalleReporte1(idClientePunto,fecha1,fecha2,tipoConsulta,diasElegidos);
                  consulta=1;
                  var elementosResultado= resultado.split ("_");
                  var table=elementosResultado[0];
                  var turnosPresupuestados=elementosResultado[1];
                  var cobroPresupuestadosCliente=elementosResultado[2];
                  var turnosCliente=elementosResultado[3];
                  var cobroCliente =elementosResultado[4];
                  var nominaCliente=elementosResultado[5];
                  var turnosPagadosCliente=elementosResultado[6];
                  var diasImssTotal =elementosResultado[7];
                  var pagoSuaTotal  =elementosResultado[8];
                  var costoUniformes=elementosResultado[9];
                  var gastoElemento =elementosResultado[10];
                  var diasInfo =elementosResultado[11];
                  var sumaInfo =elementosResultado[12];
                  var infonavit=elementosResultado[13];
                  var turnosFac=elementosResultado[14];
                  var montoFac =elementosResultado[15];
                  var turnosPresupuestoC =elementosResultado[16];

                  granTotalTurnosPresupuestados=parseInt(granTotalTurnosPresupuestados)+parseInt(turnosPresupuestados);
                  granTotalTurnosPresupuesto=parseInt(granTotalTurnosPresupuesto)+parseInt(turnosPresupuestoC);

                  granTotalcobroPresupuestadosCliente=parseInt(granTotalcobroPresupuestadosCliente)+parseInt(cobroPresupuestadosCliente);
                  granTotalturnosCliente=parseInt(granTotalturnosCliente)+parseInt(turnosCliente);
                  granTotalcobroCliente =parseInt(granTotalcobroCliente)+parseInt(cobroCliente);
                  granTotalNominaCliente=parseInt(granTotalNominaCliente)+parseInt(nominaCliente);
                  granTotalTurnosCliente=parseInt(granTotalTurnosCliente)+parseInt(turnosPagadosCliente);

                  //CAMPOS EBA
                  granTotalDiasInfoCliente =parseInt(granTotalDiasInfoCliente)+parseInt(diasInfo);
                  granTotalSumaInfoCliente =parseInt(granTotalSumaInfoCliente)+parseInt(sumaInfo);
                  granTotalInfonavitCliente=parseInt(granTotalInfonavitCliente)+parseInt(infonavit);
                  granTotalDiasImssCliente =parseInt(granTotalDiasImssCliente)+parseInt(diasImssTotal);
                  granTotalPagoSuaCliente  =parseInt(granTotalPagoSuaCliente)+parseInt(pagoSuaTotal);

                  //CAMPOS FACTURACION
                  granTotalTurnosFacCliente=parseInt(granTotalTurnosFacCliente)+parseInt(turnosFac);
                  granTotalMontoFacCliente =parseFloat(granTotalMontoFacCliente)+parseFloat(montoFac);
                  granTotalUniformesCliente=parseInt(granTotalUniformesCliente)+parseInt(costoUniformes);
                  granTotalGastoCliente    =parseInt(granTotalGastoCliente)+parseInt(gastoElemento);
                  listaTableClientes +=table;
                }//se cierraif de diferente cliente 13
              }// se cierra el for de largo cliente
              $('#tableReporteGraficas').html(listaTablaGraficas);

              var coberturaTotalTurnos=(granTotalturnosCliente/granTotalTurnosPresupuestados)*100;
              listaTableClientes += "<tr style='background-color:#F78181'>";
              listaTableClientes += "<td colspan='14'> Gran Total:</td>";
              listaTableClientes += "<td id='turnosTotalesPresupuesto'    name='turnosTotalesPresupuesto' style='background-color:#AED6F1;'>"+granTotalTurnosPresupuesto+"</td>";
              listaTableClientes += "<td id='turnosTotalesPresupuestados' name='turnosTotalesPresupuestados' style='background-color:#FFFF00;'>"+granTotalTurnosPresupuestados+"</td>";
              listaTableClientes += "<td style='background-color:#05F9AB;'>"+format(granTotalcobroPresupuestadosCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#FFFF00;'>"+granTotalturnosCliente+"</td>";
              listaTableClientes += "<td style='background-color:#05F9AB;'>"+format(granTotalcobroCliente,2)+"</td>";
              listaTableClientes += "<td>"+parseInt(granTotalTurnosPresupuestados-granTotalturnosCliente)*-1+"</td>";
              listaTableClientes += "<td style='background-color:#05F9AB;'>"+format((granTotalcobroPresupuestadosCliente-granTotalcobroCliente)*-1,2)+"</td>";
              listaTableClientes += "<td style='background-color:#F7AC20;'>"+granTotalTurnosCliente+"</td>";
              listaTableClientes += "<td style='background-color:#F7AC20;'>"+format(granTotalNominaCliente,2)+"</td>";
              listaTableClientes += "<td>"+granTotalDiasImssCliente+"</td>";
              listaTableClientes += "<td>"+format(granTotalPagoSuaCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#F7CCCC;'>"+granTotalDiasInfoCliente+"</td>";
              listaTableClientes += "<td style='background-color:#F7CCCC;'>"+format(granTotalSumaInfoCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#F7CCCC;'>"+format(granTotalInfonavitCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#89E0F9;'>"+format(granTotalUniformesCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#89E0F9;'>"+format(granTotalGastoCliente,2)+"</td>";
              listaTableClientes += "<td style='background-color:#FFFF00;'>"+coberturaTotalTurnos.toFixed(2)+" %</td>";
              listaTableClientes += "</tr>";
              $('#tableReporteGeneral').html(listaTableClientes);
              waitingDialog.hide();
            }else if (response.status == "error" && response.message == "No autorizado"){
              //window.location = "login.php";
              waitingDialog.hide();
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            waitingDialog.hide();
            alert(jqXHR.responseText);
          }
        });
}

function crearTablaDetalleReporte1(idClientePunto,fecha1,fecha2,tipoConsulta,diasElegidos){

    $("#mensajeCostoTurno").hide();
    $("#descargarReporteDetalle").hide();
    $("#descargarReportePB").hide();
    $("#tableReporteGeneral").hide();
    $("#tableReporteGraficas").hide();
    var result="";
    $.ajax({
            type: "POST",
            url: "ajax_reporteIngresoByCliente.php",
            data : {"fecha1":fecha1, "fecha2":fecha2, idClientePunto:idClientePunto,"tipoConsulta":tipoConsulta,"diasElegidos":diasElegidos},
            dataType: "json",
            async: false,
            success: function(response){
              if(response.status == "success"){
                var lista = response.lista;
                var listaGraf = response.listaGrafica;
                var nombreEntidadFederativaE="";
                $("#mensajeCostoTurno").show();
                $("#descargarReporteDetalle").show();
                $("#descargarReportePB").show();
                $("#tableReporteGeneral").show();
                $("#tableReporteGraficas").show();
                //ENCABEZADO DE FECHA
                moment.locale('Es');
                var dateTime  = moment(fecha1);
                var fullTime  = dateTime.format('LL');
                var dateTime2 = moment(fecha2);
                var fullTime2 = dateTime2.format('LL');
                var turnosCliente= 0;
                var cobroCliente = 0;
                var turnosPresupuestadosCliente= 0;
                var totalTurnosPresupuestoCliente=0;//agregado
                var cobroPresupuestadosCliente = 0;

                var listaTable = "";
                var totalTurnosPresupuestados= 0;
                var totalTurnosPresupuesto=0;//agregado
                var totalCobroPresuppuestado = 0;
                var totalTurnosCubiertos = 0;
                var totalCobroByCobertura= 0;
                var pagoNominaTotal = 0;
                var pagoNominaTotalEntidad = 0;
                var pagoNominaTotalCliente = 0;

                //CAMPOS PARA EMA
                var totalDiasImssEntidad= 0;
                var totalPagoSuaEntidad = 0;

                //CAMPOS EBA
                var totalDiasEbaEntidad=0;
                var totalSumaEbaEntidad=0
                var totalSumaInfonavitEntidad=0
                var totalDiasInfoCliente = 0;
                var totalPagoEbaCliente  = 0;
                var totalInfonavitCliente= 0;
                var totalDiasImssCliente = 0;
                var totalPagoSuaCliente  = 0;

                //VARIABLES DE COSTO UNIFORMES
                var totalUniformesEntidad=0;
                var totalUniformesCliente=0;

                //VARIABLES FACTURACION
                var turnosFacEntidad=0;
                var turnosFacCliente=0;
                var montoFacEntidad =0;
                var montoFacCliente =0;

                //VARIABLES GASTO
                var totalGastoEntidad = 0;
                var totalGastoCliente = 0;

                var totalTurnos = 0;
                var totalTurnosEntidad = 0;
                var totalTurnosCliente = 0;
                var promedio = 0.0;
                var a = 0;
                    
                if(listaTablaGraficas==''){
                   listaTablaGraficas+="<tr style='text-align:center ; font-weight: bold;'><td>Entidad</td><td>Punto de Servicio</td><td>Fecha inicio plantilla</td><td>Fecha Termino Plantilla</td><td>cobra 31</td><td>flat</td><td>Elementos Plantilla</td><td>ID Punto de Servicio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Estatus Punto de Servicio</td><td>ID Plantilla</td><td>Estatus Plantilla</td><td>Presupuesto Cobertura</td><td>Turnos de Dia Totales</td><td>Turnos de Noche Totales</td><td>Turnos Cubiertos Dia</td><td>Turnos Cubiertos Noche</td><td>Porcentaje Cubierto Dia</td><td>Porcentaje Cubierto Noche</td><td>Porcentaje Cubierto General</td></tr>";
                }

                if(listaGraf.length!='0'){
                  for(var i in listaGraf){
                      // agregado reporte de abajo
                      var nombrePuntoServ = listaGraf[i]["nombrePunto"];
                      var puntoServ = listaGraf[i]["PuntoServicio"];
                      var plantilla = listaGraf[i]["plantilla"];
                      var statusPsID= listaGraf[i]["statusps"];
                      var statusPlID= listaGraf[i]["statusplantilla"];
                      var entidadPS = listaGraf[i]["entidadPS"];
                      var rolOp2    = listaGraf[i]["rolOperativo2"];
                      var rolOpCom2 = listaGraf[i]["rolOperativoCompleto2"];
                      var puesto2   = listaGraf[i]["descripcionPuesto"];
                      var noElementos  = listaGraf[i]["noElementos"];
                      var fechaInicioPL= listaGraf[i]["fechaInicioPL"];
                      var fechaFinPL   = listaGraf[i]["fechaFinPL"];
                      var cobra31= listaGraf[i]["cobra31"];
                      var flat   = listaGraf[i]["flat"];

                      if(statusPsID=='1'){
                          var statusPs="ACTIVO";
                      }else if (statusPsID=='0'){
                          var statusPs="BAJA";
                      }
                        
                      if(statusPlID=='1'){
                          var statusPl="ACTIVA";
                      }else if (statusPlID=='0'){
                          var statusPl="BAJA";
                      }

                      var turnosXDiaGenerales = listaGraf[i][plantilla]["turnosXDia"];
                      var turnoDiaTotales     = listaGraf[i][plantilla]["turnoDiaTotales"];
                      var turnosNocheTotales  = listaGraf[i][plantilla]["turnosNocheTotales"];
                      var turnosCubiertosDia  = listaGraf[i][plantilla]["turnosCubiertosDia"];
                      var turnosCubiertosNoche= listaGraf[i][plantilla]["turnosCubiertosNoche"];

                      if((turnoDiaTotales ==0 && turnosCubiertosDia>=0) || (turnoDiaTotales ==0 && turnosCubiertosDia==0)){
                        var porcentajeTurnosDia=100;
                      }else{
                            var porcentajeTurnosDiaComp=(turnosCubiertosDia/turnoDiaTotales)*100;
                            var porcentajeTurnosDia= porcentajeTurnosDiaComp.toFixed(0); 
                      }

                      if((turnosNocheTotales ==0 && turnosCubiertosNoche>=0) || (turnosNocheTotales ==0 && turnosCubiertosNoche==0)){
                        var porcentajeTurnosNoche=100;
                      }else{
                            var porcentajeTurnosNocheComp=(turnosCubiertosNoche/turnosNocheTotales)*100;
                            var porcentajeTurnosNoche= porcentajeTurnosNocheComp.toFixed(0); 
                      }

                      var sumaTurnosCubiertos= turnosCubiertosDia+turnosCubiertosNoche;

                      if(sumaTurnosCubiertos ==0 && turnosXDiaGenerales==0){
                         var porcentajeGeneralCobertura=100;
                      }else{
                            var porcentajeGeneralCoberturaComp=(sumaTurnosCubiertos/turnosXDiaGenerales)*100;
                            var porcentajeGeneralCobertura= porcentajeGeneralCoberturaComp.toFixed(0); 
                      }

                      listaTablaGraficas += "<tr>";
                      listaTablaGraficas += "<td>" +entidadPS+"</td>";
                      listaTablaGraficas += "<td>" +nombrePuntoServ+"</td>";
                      listaTablaGraficas += "<td>" +fechaInicioPL+"</td>";
                      listaTablaGraficas += "<td>" +fechaFinPL+"</td>";
                      listaTablaGraficas += "<td>" +cobra31+"</td>";
                      listaTablaGraficas += "<td>" +flat+"</td>";
                      listaTablaGraficas += "<td>" +noElementos+"</td>";
                      listaTablaGraficas += "<td>" +puntoServ+"</td>";
                      listaTablaGraficas += "<td>" +puesto2+"</td>";
                      listaTablaGraficas += "<td>" +rolOp2+"</td>";
                      listaTablaGraficas += "<td>" +rolOpCom2+"</td>";
                      listaTablaGraficas += "<td>" +statusPs+"</td>";
                      listaTablaGraficas += "<td>" +plantilla+"</td>";
                      listaTablaGraficas += "<td>" +statusPl+"</td>";
                      listaTablaGraficas += "<td>" +turnosXDiaGenerales+"</td>";
                      listaTablaGraficas += "<td>" +turnoDiaTotales+"</td>";
                      listaTablaGraficas += "<td>" +turnosNocheTotales+"</td>";
                      listaTablaGraficas += "<td>" +turnosCubiertosDia+"</td>";
                      listaTablaGraficas += "<td>" +turnosCubiertosNoche+"</td>";
                      listaTablaGraficas += "<td>" +porcentajeTurnosDia+"</td>";
                      listaTablaGraficas += "<td>" +porcentajeTurnosNoche+"</td>";
                      listaTablaGraficas += "<td>" +porcentajeGeneralCobertura+"</td>";
                      listaTablaGraficas += "</tr>";
                      // fin agregado
                    }//FOR I
                  }//LISTA GRAF

                  if(consulta==0)
                    listaTable+="<tr><td style='background-color:#5ECFF3;text-align:center;font-size:x-large;font-weight: bold;display:none;' colspan='32'> PERIODO: "+fullTime+" AL "+fullTime2+"</td></tr>";
                  for(var i in lista){

                    var nombreEntidadFederativa= lista[i].Entidad;
                    var idEstado=lista[i].idEstado;
                    var fechaInicio=lista[i].fechaInicio;
                    var fechaTermino=lista[i].fechaTermino;
                    var idPuntoServicioNom=lista[i].idPuntoServicio;
                    var puestoCobertura=lista[i].idPuesto;
                    var roloperativo =lista[i].rolOperativo;
                    var turnosPresupuesto  =lista[i].turnosPresupuesto;   //agregado

                    if(nombreEntidadFederativaE!=nombreEntidadFederativa){
                      promedio=parseFloat(calculoSumaGastoEntidad(idEstado,fecha1,fecha2));
                      if(totalTurnosPresupuestados > 0){
                        var porcentajeTurnosT=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                        listaTable += "<tr>";
                        listaTable += "<td colspan='14'>Total entidad1:</td>";
                        listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuesto+"</td>";//agregado
                        listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                        listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                        listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                        listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2) +"</td>";
                        listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                        listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                        listaTable += "<td style='background-color:#FFFF00;'>" +porcentajeTurnosT.toFixed(2)+" %</td>";
                        listaTable += "</tr>";
                      }//IF totalTurnosPresupuestados

                      listaTable+= "<tr><td style='background-color:#BCF5A9; text-align:center ; font-weight: bold;' colspan='32'>"+nombreEntidadFederativa+" </td></tr>";
                      listaTable+="<tr style='text-align:center ; font-weight: bold;'><td>#Elementos</td><td>Linea Negocio</td><td>Puesto</td><td>Rol</td><td>Rol Operativo</td><td>Punto Servicio</td><td>Region</td><td>Supervisor a Cargo</td><td>#Centro de Costo</td><td>Cuenta contable</td>";
                      listaTable+="<td>Entidad</td><td>Fecha inicio</td><td>Fecha fin</td><td>Costo Turno</td>";
                      listaTable+="<td style='background-color:#AED6F1;'>Turnos Presupuesto</td>";
                      listaTable+="<td style='background-color:#FFFF00;'>Presupuesto Cobertura</td><td style='background-color:#05F9AB;'>Cobro Presupuestado</td><td style='background-color:#FFFF00;'>Turnos Cubiertos Perfil</td><td style='background-color:#05F9AB;'>Cobro Cobertura</td><td>Diferencia Turnos</td><td style='background-color:#05F9AB;'>Diferencia $</td><td style='background-color:#F7AC20;'>Turnos Pagados</td><td style='background-color:#F7AC20;'>$ Pago Nomina</td><td>Dias Imss</td><td>Pago Sua</td><td style='background-color:#F7CCCC;'>Dias EBA</td><td style='background-color:#F7CCCC;'>Suma EBA</td><td style='background-color:#F7CCCC;'>Suma Infonavit</td><td style='background-color:#89E0F9;'>Costo Uniformes</td><td style='background-color:#89E0F9;'>Gasto</td><td style='background-color:#FFFF00;'>Cobertura %</td></tr>";//<td style='background-color:#FFFF00;'>Cobertura %</td> agregar cuando se corrija

                      nombreEntidadFederativaE=nombreEntidadFederativa;
                      // Reiniciamos la variable de la sumatoria
                      totalTurnosPresupuestados = 0;
                      totalTurnosPresupuesto=0;
                      totalCobroPresuppuestado=0;
                      totalTurnosCubiertos=0;
                      totalCobroByCobertura=0;
                      pagoNominaTotalEntidad=0;
                      totalTurnosEntidad=0;

                      //CAMPOS SUA
                      totalDiasImssEntidad=0;
                      totalPagoSuaEntidad=0;

                      //campos eba
                      totalDiasEbaEntidad=0;
                      totalSumaEbaEntidad=0;
                      totalSumaInfonavitEntidad=0;

                      //CAMPOS FACTURACION
                      turnosFacEntidad=0;
                      montoFacEntidad=0;

                      //CAMPOS COSTO UNIFORMES
                      totalUniformesEntidad=0;
                      totalGastoEntidad=0;
                    }//IF nombreEntidadFederativaE!=nombreEntidadFederativa

                    var turnosCubiertos=getCoberturaPerfil(lista[i].asistencia, lista[i].cobraDescansos, lista[i].cobraDiaFestivo, lista[i].cobra31);
                    var cobroCobertura= turnosCubiertos*lista[i].CostoTurno;
                    var turnosPresupuestados=lista [i].turnosPresupuestadosPeriodo;
                    if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                      var cobroPresupuestado=lista [i].CostoTurno*turnosPresupuesto;
                    }else{
                      var cobroPresupuestado=lista [i].cobroPresupuestado;
                    }

                    var diferenciaCobro=(cobroPresupuestado-cobroCobertura)* -1;
                    var diferenciaTurnosEntidad=0;
                    var diferenciaCobroEntidad=0;
                    pagoNominaTotal= obtenerNominaTotalPuntoServicio(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

                    //FUNCION QUE TRAE LOS COSTOS DE SUA POR PUNTO DE SERVICIO
                    valoresEma= obtenerTotalesEma (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);

                    //FUNCION PARA OBTENER EL TOTAL DE COSTO EN ASIGNACIÓN DE UNIFORMES PARA EL PUNTO DE SERVICIO
                    var costoUniformes=parseFloat(obtenerCostoUniformes(puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo));

                    //FUNCION PARA OBTENER GASTO POR ENTIDAD
                    var gastoElemento=parseFloat(promedio*lista [i].numEle);
                    var diasImss=valoresEma.totalDias;
                    var pagoSua= valoresEma.totalPago;

                    //CALCULO PARA EBA
                    var valoresEva= obtenerTotalesEva (puestoCobertura,fecha1,fecha2,idPuntoServicioNom,roloperativo);
                    var diasInfo=valoresEva.totalDias;
                    var suma1= valoresEva.totalSuma1;
                    var sumaInfo= valoresEva.totalInfonavit;
                    totalTurnos=contadorTurnos;
                    valores=obtenerDatosmontoturnosfacturados(idPuntoServicioNom,puestoCobertura,fecha1,fecha2,roloperativo);
                    var TurnosFacturadoos=valores.TurnosFacturados;
                    var montoFacturado=valores.montoFacturado;
                    TurnosFacturadoos=parseInt(TurnosFacturadoos);
                    montoFacturado=parseFloat(montoFacturado);

                    if(turnosCubiertos=='0' && (lista [i].turnosPresupuestadosPeriodo)=='0'){
                      var totalCoberturat='0'
                    }else{
                      if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                        var porcentajeTurnos1=(turnosCubiertos / (turnosPresupuesto))*100;
                      }else{
                        var porcentajeTurnos1=(turnosCubiertos / (lista [i].turnosPresupuestadosPeriodo))*100;
                      }
                        var totalCoberturat= porcentajeTurnos1.toFixed(2);
                    }
                    listaTable += "<tr>";
                    listaTable += "<td>" + lista [i].numEle + "</td>";
                    listaTable += "<td>" + lista [i].LineaNegocio + "</td>";
                    listaTable += "<td>" + lista [i].Puesto + "</td>";
                    listaTable += "<td>" + lista [i].Rol + "</td>";
                    listaTable += "<td>" + lista [i].rolOperativo + "</td>";
                    listaTable += "<td>" + lista [i].PuntoServicio + "</td>";
                    listaTable += "<td>" + lista [i].region + "</td>";
                    listaTable += "<td>" + lista [i].supervisor + "</td>";
                    listaTable += "<td>" + lista [i].centroCosto + "</td>";
                    listaTable += "<td>" + lista [i].claveClienteNomina + "</td>";
                    listaTable += "<td>" + lista [i].Entidad + "</td>";
                    listaTable += "<td>" + fechaInicio+ "</td>";
                    listaTable += "<td>" + fechaTermino + "</td>";
                    listaTable += "<td>" + lista [i].CostoTurno + "</td>";
                    listaTable += "<td style='background-color:#AED6F1;'>" + turnosPresupuesto + "</td>";//lo que va en cada columna de las plantillas
                    if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                      listaTable += "<td style='background-color:#FFFF00;'>" + turnosPresupuesto + "</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format((lista [i].CostoTurno*turnosPresupuesto),2)+"</td>";
                      var diferenciaTurnos= parseInt(turnosPresupuesto)- parseInt(turnosCubiertos);
                    }else{
                      listaTable += "<td style='background-color:#FFFF00;'>" + lista [i].turnosPresupuestadosPeriodo + "</td>";
                      listaTable += "<td style='background-color:#05F9AB;'>" +format(lista [i].cobroPresupuestado,2)+"</td>";
                      var diferenciaTurnos= parseInt(turnosPresupuestados)- parseInt(turnosCubiertos);
                    }
                    listaTable += "<td style='background-color:#FFFF00;'>" +turnosCubiertos+"</td>";
                    listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCobertura,2)+"</td>";
                    a++;
                    listaTable += "<td>" +diferenciaTurnos * -1 +"</td>";
                    listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobro,2)  +"</td>";
                    listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnos+"</td>";
                    listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotal,2)+"</td>";
                    listaTable += "<td>" +diasImss +"</td>";
                    listaTable += "<td>" +format(pagoSua,2)+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +diasInfo+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +format(suma1,2)+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +format(sumaInfo,2)+"</td>";
                    listaTable += "<td style='background-color:#89E0F9;'>" +format(costoUniformes,2)+"</td>";
                    listaTable += "<td style='background-color:#89E0F9;'>" +format(gastoElemento,2)+"</td>";
                    listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturat+" %</td>";
                    listaTable += "</tr>";

                    if(lista [i].rolOperativo == "12X12X5" || lista [i].rolOperativo == "12x12x5" || lista [i].rolOperativo == "12X12x5" || lista [i].rolOperativo == "12x12X5"){
                      totalTurnosPresupuestados+= lista [i].turnosPresupuesto;
                      totalCobroPresuppuestado += lista [i].CostoTurno*turnosPresupuesto;
                      turnosPresupuestadosCliente+=lista [i].turnosPresupuesto;
                    }else{
                      totalTurnosPresupuestados+= lista [i].turnosPresupuestadosPeriodo;
                      totalCobroPresuppuestado += lista [i].cobroPresupuestado;
                      turnosPresupuestadosCliente+=lista [i].turnosPresupuestadosPeriodo;

                    }
                    // incrementamos la sumatoria
                    totalTurnosPresupuesto+= lista [i].turnosPresupuesto;//agregado
                    totalTurnosCubiertos+=turnosCubiertos;
                    totalCobroByCobertura+=cobroCobertura;
                    totalTurnosEntidad+=totalTurnos;
                    totalTurnosCliente+=totalTurnos;
                    pagoNominaTotalEntidad+=pagoNominaTotal;
                    pagoNominaTotalCliente+=pagoNominaTotal;

                    //CAMPOS EMA
                    totalDiasImssEntidad+=diasImss;
                    totalPagoSuaEntidad+=pagoSua;
                    totalDiasImssCliente+=diasImss;
                    totalPagoSuaCliente+=pagoSua;

                    //CAMPOS PARA EBA
                    totalDiasEbaEntidad+=diasInfo;
                    totalSumaEbaEntidad+=suma1;
                    totalSumaInfonavitEntidad+=sumaInfo;
                    totalDiasInfoCliente+=diasInfo;
                    totalPagoEbaCliente+=suma1;
                    totalInfonavitCliente+=sumaInfo;

                    //CAMPOS FACTURACION
                    turnosFacEntidad+=TurnosFacturadoos;
                    turnosFacCliente+=TurnosFacturadoos;    
                    montoFacEntidad+=montoFacturado;
                    montoFacCliente+=montoFacturado;

                    //SUMATORIA PARA COSTOS UNIFORMES
                    totalUniformesEntidad+=costoUniformes;
                    totalUniformesCliente+=costoUniformes;

                    //SUMATORIA TOTAL CLIENTE GASTO
                    totalGastoEntidad+=gastoElemento;
                    totalGastoCliente+=gastoElemento;
                    turnosCliente+=turnosCubiertos;
                    cobroCliente+=cobroCobertura;
                    totalTurnosPresupuestoCliente+=lista [i].turnosPresupuesto;//agregado
                    cobroPresupuestadosCliente+=cobroPresupuestado;
                    diferenciaTurnosEntidad=(totalTurnosPresupuestados-totalTurnosCubiertos)*-1;
                    diferenciaCobroEntidad=(totalCobroPresuppuestado-totalCobroByCobertura)*-1;
                    // listaTable += "</tr>";esta del otro lado
                  } //termina for i in lista

                  if(totalTurnosPresupuestados > 0){
                    var totalCoberturaentidad=(totalTurnosCubiertos/totalTurnosPresupuestados)*100;
                    listaTable += "<tr>";
                    listaTable += "<td colspan='14'>Total entidad2:</td>";
                    listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuesto+"</td>";
                    listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosPresupuestados+"</td>";
                    listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroPresuppuestado,2)+"</td>";
                    listaTable += "<td style='background-color:#FFFF00;'>" +totalTurnosCubiertos+"</td>";
                    listaTable += "<td style='background-color:#05F9AB;'>" +format(totalCobroByCobertura,2)+"</td>";
                    listaTable += "<td>" +diferenciaTurnosEntidad+"</td>";
                    listaTable += "<td style='background-color:#05F9AB;'>" +format(diferenciaCobroEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosEntidad+"</td>";
                    listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalEntidad,2)+"</td>";
                    listaTable += "<td>" +totalDiasImssEntidad+"</td>";
                    listaTable += "<td>" +format(totalPagoSuaEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasEbaEntidad+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaEbaEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalSumaInfonavitEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoEntidad,2)+"</td>";
                    listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturaentidad.toFixed(2)+" %</td>";
                    listaTable += "</tr>";
                  }
                  var totalCoberturacliente=(turnosCliente/turnosPresupuestadosCliente)*100;
                  listaTable += "<tr>";
                  listaTable += "<td colspan='14'>Total cliente1:</td>";
                  listaTable += "<td style='background-color:#AED6F1;'>" +totalTurnosPresupuestoCliente+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +turnosPresupuestadosCliente+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroPresupuestadosCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +turnosCliente+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format(cobroCliente,2)+"</td>";
                  listaTable += "<td>" +(turnosPresupuestadosCliente-turnosCliente)*-1+"</td>";
                  listaTable += "<td style='background-color:#05F9AB;'>" +format((cobroPresupuestadosCliente-cobroCliente)*-1,2)+"</td>";
                  listaTable += "<td style='background-color:#F7AC20;'>" +totalTurnosCliente+"</td>";
                  listaTable += "<td style='background-color:#F7AC20;'>" +format(pagoNominaTotalCliente,2)+"</td>";
                  listaTable += "<td>" +totalDiasImssCliente+"</td>";
                  listaTable += "<td>" +format(totalPagoSuaCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +totalDiasInfoCliente+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalPagoEbaCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#F7CCCC;'>" +format(totalInfonavitCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#89E0F9;'>" +format(totalUniformesCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#89E0F9;'>" +format(totalGastoCliente,2)+"</td>";
                  listaTable += "<td style='background-color:#FFFF00;'>" +totalCoberturacliente.toFixed(2)+" %</td>";
                  listaTable += "</tr>";
                  result=listaTable+"_"+turnosPresupuestadosCliente+"_"+cobroPresupuestadosCliente+"_"+turnosCliente+"_"+cobroCliente+"_"+pagoNominaTotalCliente+"_"+totalTurnosCliente+"_"+totalDiasImssCliente+"_"+totalPagoSuaCliente+"_"+totalUniformesCliente+"_"+totalGastoCliente+"_"+totalDiasInfoCliente+"_"+totalPagoEbaCliente+"_"+totalInfonavitCliente+"_"+turnosFacCliente+"_"+montoFacCliente+"_"+totalTurnosPresupuestoCliente;
                } //termina if success
          },
    error: function(jqXHR, textStatus, errorThrown){
      waitingDialog.hide();
                  alert(jqXHR.responseText);
    }
  });
  return result;
}

function getCoberturaPerfil(asistencia, cobraDescansos,cobraDiaFestivo,cobra31){

  var turnos=0;
  for(var i=0; i < asistencia.length; i++){
    var valorCobertura=asistencia[i].valorCobertura;
    var nomenclaturaIncidencia=asistencia[i].nomenclaturaIncidencia;
    var fechaAsistencia=asistencia[i].fechaAsistencia;

    if(cobraDescansos==1){
      if(nomenclaturaIncidencia=="DES"){
        
          valorCobertura=1;
        
      }
    }

    if(cobraDiaFestivo==0){
      if(nomenclaturaIncidencia=="DF"){
        valorCobertura=0;
      }
    }

    if(cobra31==0){
      var dia=fechaAsistencia.substring(8);

      if(dia==31){
        valorCobertura=0;
      }
    }
    turnos=parseInt(turnos)+parseInt(valorCobertura);
  }//for
  return turnos;
}

function obtenerNominaTotalPuntoServicio(puesto,fecha1,fecha2,idPuntoServicioNom,roloperativo){
// alert("1");
  var totalPagoNomina=0;
  $.ajax({
      async: false,
      type: "POST",
      url: "ajax_obtenerEmpleadorNominaPuntoServicio.php",
      data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicioId":idPuntoServicioNom, "puestoCubierto":puesto,"roloperativo":roloperativo},
      dataType: "json",
      success: function(response) {
        if(response.status == "success"){
          var empleadoEncontrado = response.listaEmpleados;
          var faltas=0;
          var incapacidades=0;
          var permisos=0;
          var dt=0;
          var vpagadas=0;
          var vdisfrutadas=0;
          var baja=0;
          var tQuicena=0;
          var sueldoBrutoE=0;
          var montoVacacionesPagadas=0;
          var contTurnos=0;

          for ( var i = 0; i < empleadoEncontrado.length; i++ ){
            var numeroEmpleado=empleadoEncontrado[i].empleadoEntidad+"-"+empleadoEncontrado[i].empleadoConsecutivo+"-"+empleadoEncontrado[i].empleadoTipo;
            var listaAsistencia = empleadoEncontrado[i].asistencia;
            var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
            var descuentos=empleadoEncontrado[i].descuentos.descuentos;
            var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
            var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
            var cuotaDiariaEmpleado=parseFloat(empleadoEncontrado[i].cuotaDiariaEmpleado).toFixed(2);
            var bonoAsistenciaEmpleado=parseFloat(empleadoEncontrado[i].bonoAsistenciaEmpleado).toFixed(2);
            var bonoPuntualidadEmpleado=parseFloat(empleadoEncontrado[i].bonoPuntualidadEmpleado).toFixed(2);
            var bonoAplicado=parseInt(bonoAsistenciaEmpleado)+parseInt(bonoPuntualidadEmpleado);
            if(incidenciasEspeciales==null){
              incidenciasEspeciales=0;
            }

            if(descuentos==null){
              descuentos=0;
            }

            if(sumaTurnosExtras==null){
              sumaTurnosExtras=0;
            }
            
            for(var j=0; j<listaAsistencia.length; j++){
              var asistenciaText = listaAsistencia [j]["nomenclaturaIncidencia"];
              var valorAsistencia= listaAsistencia [j]["valorAsistencia"];

              if(valorAsistencia== null){
                valorAsistencia=0;
              }

              tQuicena+=parseInt(valorAsistencia);

              if(asistenciaText=="F"){
                faltas=faltas+1;
              }
              
              if(asistenciaText=="PER"){
                permisos=permisos+1;
              }
              if(asistenciaText=="INC"){
                incapacidades=incapacidades+1;
              }
              if(asistenciaText=="B"){
                baja=baja+1;
              }
              if(asistenciaText=="V/P" || asistenciaText=="V/P2"){
                vpagadas+=parseInt(valorAsistencia);
              }
              if(asistenciaText=="V/D" || asistenciaText=="V/D2"){
                vdisfrutadas+=parseInt(valorAsistencia);
              }
            }//for j

            if(faltas>=1 || baja>=1){
              bonoAplicado=0;
            }
            if(incapacidades>=3){
              bonoAplicado=0;
            }
            if(permisos>=3){
              bonoAplicado=0;
            }
            if(incidenciasEspeciales>=1){
              bonoAplicado=0
            }

            if((incapacidades+permisos)>=3){
              bonoAplicado=0;
            }
            if(tQuicena<=6){
              bonoAplicado=0;
            }

            if(vpagadas>0){
              montoVacacionesPagadas=parseInt(vpagadas)*parseFloat(cuotaDiariaEmpleado);

            }

            var diasVacaciones=parseInt(vpagadas)+parseInt(vdisfrutadas);
            var primaVacacional=(diasVacaciones*cuotaDiariaEmpleado)*0.25;
            var turnosTotales= parseInt(tQuicena) + parseInt(sumaTurnosExtras) - Math.abs(descuentos) + parseInt(sumaDiasFestivos);
            contTurnos+=turnosTotales;
            var sueldo=turnosTotales*cuotaDiariaEmpleado;
            sueldoBrutoE+=(parseFloat(sueldo)+parseFloat(bonoAplicado)+parseFloat(montoVacacionesPagadas)+parseFloat(primaVacacional));
            tQuicena=0;
            faltas  =0;
            permisos=0;
            incapacidades=0;
            baja=0;
            vpagadas=0;
            vdisfrutadas=0;
          }//for i
          contadorTurnos=contTurnos;
          var sueldoTotales=sueldoBrutoE;
          totalPagoNomina=  sueldoTotales;
        }//termina if success
      },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
      }
    });
    return totalPagoNomina;
}

function format(amount, decimals) {
  
  var ban=0;
  if(amount<0)
    ban=1;
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
  if(isNaN(amount) || amount === 0)
      return parseFloat(0).toFixed(decimals);
      // si es mayor o menor que cero retorno el valor formateado como numero
      amount = '' + amount.toFixed(decimals);
      var amount_parts = amount.split('.'),
      regexp = /(\d+)(\d{3})/;

      while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

      if(ban==0)
        return "$"+amount_parts.join('.');
      else
        return "-$"+amount_parts.join('.');
}

function obtenerTotalesEma (puesto,fecha1,fecha2,puntoServicio,roloperativo){

  var emaArray= new Array();
  $.ajax({
          async: false,
          type: "POST",
          url: "ajax_calculoEmaPuntoServicio.php",
          data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto, "roloperativo":roloperativo},
          dataType: "json",
          success: function(response) {
            if(response.status == "success"){
              var valores = response.valoresEma;
              emaArray=valores;
            }//termina if success
          },error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
        });
  return emaArray;
}

function obtenerTotalesEva (puesto,fecha1,fecha2,puntoServicio,roloperativo){

  var infoArray= new Array();
  $.ajax({
      async: false,
      type: "POST",
      url: "ajax_calculoEvaPuntoServicio.php",
      data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto,"roloperativo":roloperativo},
      dataType: "json",
      success: function(response) {
          if(response.status == "success"){
            var valores = response.valoresInfo;
            infoArray=valores;
          }//termina if success
      },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
      }
  });
  return infoArray;
}

function obtenerCostoUniformes (puesto,fecha1,fecha2,puntoServicio,roloperativo){

  var totalCosto= 0;
  $.ajax({
      async: false,
      type: "POST",
      url: "ajax_calcularCostoUniformes.php",
      data : {"fecha1":fecha1, "fecha2":fecha2, "puntoServicio":puntoServicio, "puesto":puesto, "roloperativo":roloperativo},
      dataType: "json",
      success: function(response) {
          if (response.status == "success"){
              var costo = response.totalUniformes;
              totalCosto=costo;
          }//termina if success
      },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
      }
  });
  return totalCosto;
}

function calculoSumaGastoEntidad(entidad,fecha1,fecha2){

  var gasto=0;
  $.ajax({
          async: false,
          type: "POST",
          url: "ajax_sumaGastoByEntidad.php",
          data : {"fecha1":fecha1, "fecha2":fecha2, "entidad":entidad},
          dataType: "json",
          success: function(response) {
            if (response.status == "success"){
               var total = response.totalPromedio;
               gasto=total;
            }//termina if success
       },error: function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText);
       }
  });
  return gasto;
}

$("#descargarReporteDetalle").click(function(event) {
  $("#datos_reporte").val( $("<div>").append( $("#tableReporteGeneral").eq(0).clone()).html());
  $("#form_consultaReporteDetalle").submit();
});

$("#descargarReportePB").click(function(event) {
  $("#datos_reporte").val( $("<div>").append( $("#tableReporteGraficas").eq(0).clone()).html());
  $("#form_consultaReporteDetalle").submit();
});

$('#txtFechaReporteDetalle1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaReporteDetalle2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

function editar(i){
  $("#montofacturado"+i).prop('readonly', false);
  $("#turnosfacturacion"+i).prop('readonly', false);
  $("#imgsave"+i).prop('readonly', false);
}

function guardar(puntoservicio,puesto,i){
  var fechaini=$("#txtFechaReporteDetalle1").val();
  var fechafi=$("#txtFechaReporteDetalle2").val();
  var monto=$("#montofacturado"+i).val();
  var turnosfactu=  $("#turnosfacturacion"+i).val();
  var llave=puntoservicio+"_"+puesto;

  if(fechaini=="" || fechafi ==""){
    alert("Por favor introduzca una fecha correcta");
  }else if(turnosfactu=="" || !/^([0-9])*$/.test(turnosfactu)){
    alert("Por favor verifique Turnos facturados en la fila: " +(i+1)+ " Solo Numeros");
  }else if(monto==""|| !/^([0-9]+\.?[0-9]{0,2})$/.test(monto)){
    alert("Por favor  verifique Monto facturado en la fila: " +(i+1)+ " Solo Numeros");
  }else{
        $.ajax({
            type: "POST",
            url: "ajax_insertUpdateturnomoontosfacturacion.php",
            dataType: "json",
            data: {"fecha1": fechaini,"fecha2": fechafi,"monto":monto,"turnosfactu":turnosfactu,"llave":llave},
            success: function(response) {
               $("#montofacturado"+i).prop('readonly', true);
               $("#turnosfacturacion"+i).prop('readonly', true);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
  }//else
}

function obtenerDatosmontoturnosfacturados (puntoServicio,puesto,fecha1,fecha2,roloperativo){

  var key=puntoServicio+"_"+puesto;
  var lista= new Array();
  $.ajax({
        async: false,
        type: "POST",
        url: "ajax_traedatosmontoturnosbycliente.php",
        data : {"fecha1":fecha1, "fecha2":fecha2, "llave":key},
        dataType: "json",
        success: function(response){
          if(response.status == "success"){
            var valores = response.valores;
            lista=valores;
          }//termina if success
        },error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
        }
  });
 return lista;
}
</script>