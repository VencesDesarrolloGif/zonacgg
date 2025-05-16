<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
//$log = new KLogger ( "vistaConsultaAsistencia.log" , KLogger::DEBUG );
?>

<div class="container" align="center" >
<form class="form-horizontal" id="form_prosesoNomina" name="form_prosesoNomina" action="ficheroExportNomina.php" target="_blank" method="post">
 <div class="btn-group" >
  <label class="btn btn-secondary">
    <input type="radio" name="optionPeriodoProcesoNomina" id="optionPeriodoProcesoNominaQuincenal" value="QUINCENAL" checked onclick="generarTablaProcesoNomina();"> QUINCENAL
  </label>
  <label class="btn btn-secondary ">
    <input type="radio" name="optionPeriodoProcesoNomina" id="optionPeriodoProcesoNominaSemanal" value="SEMANAL" onclick="generarTablaProcesoNomina();"> SEMANAL
  </label>
  </div>
  <br>
  <br>
  <button id="btnGenerarConsulta" name="btnGenerarConsulta" class="btn btn-info" type="button" onclick='getEmpleadosForNomina();'> <span class="glyphicon glyphicon-play"></span>Calcular Prenómina Periodo Actual</button>
  <button id="descargarNomina" name="descargarNomina" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
  <img src="img/lock-nomina.png" onclick="consultaPeticionesAsistenciaMermaParaCerrar();" class='cursorImg'> Cerrar nómina

    <br>
  <br>
  <input type="hidden" id="datos_nomina" name="datos_nomina" />
  <div id="divTableProcesoNomina" name="divTableProcesoNomina" align="center" class='container'>
  </div>
 
  <!-- <button id="descargarAsistencia" name="descargarAsistencia" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button> -->


    <div class="modal hide fade" id="modalConsultaPersonalizada" name="modalConsultaPersonalizada"> <!-- div consulta personalizada -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Consulta Asistencia</h3>
        <div id="divMsgConsulta" name="divMsgConsulta"></div>
      </div>
      <div class="modal-body">
        
            <div>
            DE:<input id="txtFechaRango1" name="txtFechaRango1" type="text" class="input-medium"> A: <input id="txtFechaRango2" name="txtFechaRango2" type="text" class="input-medium">
            </div>
            <br>
            <div>
            Punto de servicio<select id="selectPuntoConsulta" name="selectPuntoConsulta"><option>Punto de servicio</option></select>
            </div>
            <br>
            <div>
            #Empleado<input type="text" id="txtNumeroEmpleadoConsulta" name="txtNumeroEmpleadoConsulta" placeholder="00-0000-00" class="input-medium">
            </div>
            <br>
        </div>
        <div class="modal-footer">
          <a href="javascript:opcionConsulta();" class="btn btn-primary">Consultar</a>
        </div>
      </div> <!-- fin modal consulta personalizada -->

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="myModalCerrarNomina" name="myModalCerrarNomina">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-header">

          <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA CERRAR NÓMINA?</h4>
        </div>

        <div class="modal-content">

            <div id="msgCierreNomina" name="msgCierreNomina">
            </div>

        </div>

        <div class="modal-footer" id="footerBajaEmpleado">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="btncerrarnomina" type="button" class="btn btn-primary" onclick='procesarNomina();' data-dismiss="modal">Cerrar Nómina</button>
        </div>
      </div>
    </div>
</form>
</div> <!-- fin div container -->

<script type="text/javascript">
	<?php 
  if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" || $usuario["rol"] =="Prenomina Administrativa"):
                
                ?>
                                
                jQuery("#optionPeriodoProcesoNominaQuincenal").attr('checked', true);
                 //alert($('input:radio[name=optionPeriodo]:checked').val());
                 
                var fechasAsistenciaConsulta = [];
                
                var fechaConsulta1="";
                var fechaConsulta2="";
                var periodoConsultaId="1";


                generarTablaProcesoNomina();
                verificaCierrePeriodo(fechaConsulta1,fechaConsulta2,1);
                verificaCierrePeriodo(fechaConsulta1,fechaConsulta2,2);


                 setInterval("verificaCierrePeriodo(fechaConsulta1,fechaConsulta2,1)",120000);
                 setInterval("verificaCierrePeriodo(fechaConsulta1,fechaConsulta2,2)",120000);


                var stylesConsulta = [];

                stylesConsulta ["DES"] = "background-color:#FEFF00";
                stylesConsulta ["F"] = "background-color:#FA5858";
                stylesConsulta ["PER"] = "background-color:#01AFF5";
                stylesConsulta ["V/P"] = "background-color:#538136";
                stylesConsulta ["V/D"] = "background-color:#538136";
                stylesConsulta ["INC"] = "background-color:#90D24B";
                stylesConsulta ["F"] = "background-color:#FF0000";
                stylesConsulta ["B"] = "background-color:#FF0000";
                stylesConsulta ["ING"] = "background-color:#BDBDBD;";
                stylesConsulta ["DT12"] = "background-color:#FEFF00";
                stylesConsulta ["1"] = "background-color:#FFFFFF";
                stylesConsulta ["2"] = "background-color:#FFFFFF";
                stylesConsulta ["V/P2"] = "background-color:#538136";
                stylesConsulta ["V/D2"] = "background-color:#538136";
                stylesConsulta ["CAP"] = "background-color:#FF8000";

                <?php
            endif;
            ?>
	
		function generarTablaProcesoNomina(){

          var tipoPeriodo = $('input:radio[name=optionPeriodoProcesoNomina]:checked').val();


          if (tipoPeriodo=="QUINCENAL"){

		        periodoConsultaId="1";
		        
		        <?php
		        $diasAsistenciaConsulta= $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
		        //$log->LogInfo("Valor de diasAsistenciaConsulta en vista consulta asistencia: " . var_export ($diasAsistenciaConsulta, true));
		        ?>
		        fechasAsistenciaConsulta = [];

		        <?php
		        foreach ($diasAsistenciaConsulta as $dia):
		        ?>
		        
		        <?php echo "fechasAsistenciaConsulta.push ('" . $dia["fecha"] . "');\n" ?>
		        <?php
		        endforeach;
		        ?>

		        fechaConsulta1 = fechasAsistenciaConsulta [0];
		        fechaConsulta2 = fechasAsistenciaConsulta [fechasAsistenciaConsulta.length - 1];

		        var tableProcesoNomina="<table class='table table-bordered table-striped' id='tableProcesoNomina' name='tableProcesoNomina'><thead><tr>";
		        tableProcesoNomina+="<th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th><th>Fecha Ingreso</th><th>No. Cta</th><th>Cta. Clabe</th>";
		        tableProcesoNomina+="<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th>";
		        tableProcesoNomina+="<th width='160px'>Cliente</th><th width='160px'>Supervisor</th> <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th>";
		        tableProcesoNomina+="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th>";
		        tableProcesoNomina+="<th>Cuota Diaria</th><th>Bono Asistencia</th><th>Bono Puntualidad</th><th>Sueldo</th><th>Faltas</th><th>Permisos</th><th>V.P</th><th>V/D</th><th>Monto V/P</th><th>Prima Vac</th>";
		        tableProcesoNomina+="<th>Bono Aplicado</th><th>Sueldo Bruto</th><th>Fonacot</th><th>Infonavit</th><th>Pensión</th><th>Prestamo</th><th>Alimentos</th><th>Neto al Pago</th></thead><tbody></tbody></table>";


        		$('#divTableProcesoNomina').html(tableProcesoNomina); 

        		//getEmpleadosForNomina();
          }else{
          
		        periodoConsultaId="2";
		        <?php
		        $diasAsistenciaConsulta= $negocio -> obtenerListaDiasParaAsistencia ("SEMANAL");
		        //$log->LogInfo("Valor de diasAsistenciaConsulta en vista consulta asistencia: " . var_export ($diasAsistenciaConsulta, true));
		        ?>
		        fechasAsistenciaConsulta = [];

		        <?php
		        foreach ($diasAsistenciaConsulta as $dia):
		        ?>
		        
		        <?php echo "fechasAsistenciaConsulta.push ('" . $dia["fecha"] . "');\n" ?>
		        <?php
		        endforeach;
		        ?>

		        fechaConsulta1 = fechasAsistenciaConsulta [0];
		        fechaConsulta2 = fechasAsistenciaConsulta [fechasAsistenciaConsulta.length - 1];


        		var tableProcesoNomina="<table class='table table-bordered table-striped' id='tableProcesoNomina' name='tableProcesoNomina'><thead><tr><th  width='80px'>#Empleado</th>";
        		tableProcesoNomina+="<th width='160px'>Nombre Empleado</th><th>Fecha Ingreso</th><th>No. Cta</th><th>Cta. Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th>";
        		tableProcesoNomina+="<th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Supervisor</th> <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th>";
        		tableProcesoNomina+="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th>";
        		tableProcesoNomina+="<th>Cuota Diaria</th><th>Bono Asistencia</th><th>Bono Puntualidad</th><th>Sueldo</th><th>Faltas</th><th>Permisos</th><th>V.P</th><th>V/D</th><th>Monto V/P</th><th>Prima Vac</th>";
        		tableProcesoNomina+="<th>Bono Aplicado</th><th>Sueldo Bruto</th><th>Fonacot</th><th>Infonavit</th><th>Pensión</th><th>Prestamo</th><th>Alimentos</th><th>Neto al Pago</th></tr></thead><tbody></tbody></table>";


        		$('#divTableProcesoNomina').html(tableProcesoNomina); 
               }

                verificaCierrePeriodo(fechaConsulta1, fechaConsulta2, periodoConsultaId);
    	}

    //funcionalidad para consultar empleados y asistencia del periodo en curso
    //segun el usuario logeado
    //supervisor: solo ve personal a su cargo del periodo en curso
    //analista: ve todo el personal del periodo en curso

    function getEmpleadosForNomina()
    {
        
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" ):
      ?>
      supervisorId=$("#selectSupervisor").val();
      <?php
      endif;
      ?>

        
        $("#tableProcesoNomina").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosBySupervisorPeriodo.php",
            data : {"fecha1":fechaConsulta1, "fecha2":fechaConsulta2, "periodoId":periodoConsultaId,"supervisorId":supervisorId },
            dataType: "json",
             success: function(response) {
             // console.log(response);
                if (response.status == "success")
                {
                    var empleadoEncontrado = response.listaEmpleados;               
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
                      var entidadTrabajo=empleadoEncontrado[i].entidadTrabajo;
                      var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                      var puntoServicio=empleadoEncontrado[i].puntoServicio;
                      var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
                      var asistencia = empleadoEncontrado[i].asistencia;
                      var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
                      var descuentos=empleadoEncontrado[i].descuentos.descuentos;
                      var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
                      var cliente=empleadoEncontrado[i].razonSocial;
                      var supervisorId = empleadoEncontrado[i].supervisorId;
                      var supervisorName = empleadoEncontrado[i].supervisor;
                      var numeroCta="'" + empleadoEncontrado[i].numeroCta;
                      var numeroCtaClabe= "'"+empleadoEncontrado[i].numeroCtaClabe;
                      var fechaIngreso=empleadoEncontrado[i].fechaIngresoEmpleado;
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
                      var cuotaDiariaEmpleado=parseFloat(empleadoEncontrado[i].cuotaDiariaEmpleado).toFixed(2);
                      var bonoAsistenciaEmpleado=parseFloat(empleadoEncontrado[i].bonoAsistenciaEmpleado).toFixed(2);
                      var bonoPuntualidadEmpleado=parseFloat(empleadoEncontrado[i].bonoPuntualidadEmpleado).toFixed(2);
                      var bonoAplicado=parseInt(bonoAsistenciaEmpleado)+parseInt(bonoPuntualidadEmpleado);
                      var montofonacot=parseFloat(empleadoEncontrado[i].fonacot).toFixed(2);
                      var montoinfonavit=parseFloat(empleadoEncontrado[i].infonavit).toFixed(2);
                      var montopension=parseFloat(empleadoEncontrado[i].pension).toFixed(2);
                      var montoprestamo=parseFloat(empleadoEncontrado[i].prestamo).toFixed(2);
                      var montoalimentos=parseFloat(empleadoEncontrado[i].alimentos).toFixed(2);
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }

                     var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td>" + crearCeldasConsultaAsistenciaForNomina(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId) + "";
                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"'  name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td><td>"+cuotaDiariaEmpleado+"</td>";
                     
                     dateTable+="<td>"+bonoAsistenciaEmpleado+"</td>";
                     dateTable+="<td>"+bonoPuntualidadEmpleado+"</td>";  
                     dateTable+="<td id='td_sueldo_"+numeroEmpleado+"' name='td_sueldo_"+numeroEmpleado+"'></td>";                 
                     dateTable+="<td id='tdt_faltas_"+numeroEmpleado+"' name='tdt_faltas_"+numeroEmpleado+"'></td><td id='tdt_permisos_"+numeroEmpleado+"' name='tdt_permisos_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='tdt_vpagadas_"+numeroEmpleado+"' name='tdt_vpagadas_"+numeroEmpleado+"'><td id='tdt_vDisfrutadas_"+numeroEmpleado+"' name='tdt_vDisfrutadas_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='td_montoVacacionesPagadas_"+numeroEmpleado+"' name='td_montoVacacionesPagadas_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='td_primaVacacional_"+numeroEmpleado+"' name='td_primaVacacional_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='tdt_bonos_"+numeroEmpleado+"' name='tdt_bonos_"+numeroEmpleado+"'></td><td id='td_sueldoBruto_"+numeroEmpleado+"' name='td_sueldoBruto_"+numeroEmpleado+"'></td><td id='td_fonacot_"+numeroEmpleado+"' name='td_fonacot_"+numeroEmpleado+"'></td><td id='td_infonavit_"+numeroEmpleado+"' name='td_infonavit_"+numeroEmpleado+"'></td><td id='td_pension_"+numeroEmpleado+"' name='td_pension_"+numeroEmpleado+"'></td><td id='td_prestamo_"+numeroEmpleado+"' name='td_prestamo_"+numeroEmpleado+"'> <td id='td_alimentos_"+numeroEmpleado+"' name='td_alimentos_"+numeroEmpleado+"'></td><td id='td_netoalpago_"+numeroEmpleado+"' name='td_netoalpago_"+numeroEmpleado+"'></td></tr>" 
                     $('#tableProcesoNomina').append(dateTable);


                    var tQuicena=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    var faltas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("faltas");
                    var permisos=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("permisos");
                    var incapacidades=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("incapacidades");
                    var baja=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("baja");
                    var vpagadas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("vpagadas");
                    var vdisfrutadas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("vdisfrutadas");
                    var montoVacacionesPagadas=0;
                    var primaVacacional=0;
                    var extra=0;
                    var diasVacaciones=parseInt(vpagadas)+parseInt(vdisfrutadas);
                    var primaVacacional=(diasVacaciones*cuotaDiariaEmpleado)*0.25;
                    $("#tdt_faltas_"+numeroEmpleado).html(faltas);
                    $("#tdt_permisos_"+numeroEmpleado).html(permisos);
                    $("#tdt_vpagadas_"+numeroEmpleado).html(vpagadas);
                    $("#tdt_vDisfrutadas_"+numeroEmpleado).html(vdisfrutadas);
                    $("#td_primaVacacional_"+numeroEmpleado).html(primaVacacional);

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
                    
                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tDiasFestivos);

                    var diasfestipospordos=parseInt(tDiasFestivos);

                    var sueldo=((turnosTotales)*cuotaDiariaEmpleado);
                    var sueldoBruto=   parseFloat(sueldo)+parseFloat(bonoAplicado)+parseFloat(montoVacacionesPagadas)+parseFloat(primaVacacional);
                    var netoalpago=(sueldoBruto-montofonacot-montoinfonavit-montopension-montoprestamo-montoalimentos);
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);
                    $("#tdt_bonos_"+numeroEmpleado).html(bonoAplicado);
                    $("#td_montoVacacionesPagadas_"+numeroEmpleado).html(montoVacacionesPagadas);
                    $("#td_sueldo_"+numeroEmpleado).html(parseFloat(sueldo).toFixed(2));
                    $("#td_sueldoBruto_"+numeroEmpleado).html(parseFloat(sueldoBruto).toFixed(2));
                    $("#td_fonacot_"+numeroEmpleado).html(montofonacot);
                    $("#td_infonavit_"+numeroEmpleado).html(montoinfonavit);
                    $("#td_pension_"+numeroEmpleado).html(montopension);
                    $("#td_prestamo_"+numeroEmpleado).html(montoprestamo);
                    $("#td_alimentos_"+numeroEmpleado).html(parseFloat(montoalimentos).toFixed(2) );  
                    $("#td_netoalpago_"+numeroEmpleado).html(parseFloat(netoalpago).toFixed(2) );  


                              
                    }
                    waitingDialog.hide();  
                    //tooltipAjax2();
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                } 
            },
             error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });

    }

   
    
function crearCeldasConsultaAsistenciaForNomina (numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId)
{
    // Variables Globales
    // fechasAsistencia
    // turnosCubiertos

        var result = "";
        var sumaTurnosPeriodo=0;
        var faltas=0;
        var incapacidades=0;
        var permisos=0;
        var dt=0;

        var vpagadas=0;
        var vdisfrutadas=0;
        var baja=0;
        

    for (var i = 0; i < fechasAsistenciaConsulta.length; i++)
    {
     
      fechaAsistenciaConsulta = fechasAsistenciaConsulta [i];
        //alert(fechaAsistenciaConsulta);

        var asistenciaText = "";
        var puntoServiciosIncidencia="";
        var puntoServicioAsistenciaId=empleadoIdPuntoServicio;
        var comentarioIncidencia="";
        var incidenciaAsistenciaId="";
        
        if (asistencia [fechaAsistenciaConsulta] != null)
        {
            asistenciaText = asistencia [fechaAsistenciaConsulta]["nomenclaturaIncidencia"];
            puntoServiciosIncidencia= asistencia [fechaAsistenciaConsulta]["puntoServicio"];
            puntoServicioAsistenciaId= asistencia [fechaAsistenciaConsulta]["puntoServicioAsistenciaId"];
            comentarioIncidencia=asistencia [fechaAsistenciaConsulta]["comentarioIncidencia"];
            incidenciaAsistenciaId=asistencia [fechaAsistenciaConsulta]["incidenciaAsistenciaId"];
            valorAsistencia=asistencia [fechaAsistenciaConsulta]["valorAsistencia"];
            
//            //console.log (puntoServicioAsistenciaId);

        if(valorAsistencia== null)
        {
          valorAsistencia=0;
        }
        sumaTurnosPeriodo = parseInt(sumaTurnosPeriodo) + parseInt(valorAsistencia);
        }

        var id = numeroEmpleado + puntoServicioAsistenciaId + fechaAsistenciaConsulta ;

        var style = stylesConsulta [asistenciaText];

              if(asistenciaText=="ING"){
                asistenciaText="";
              }else if(asistenciaText=="DT12"){
                asistenciaText="2";
              }

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
              	vpagadas=parseInt(vpagadas)+parseInt(valorAsistencia);
              }
              if(asistenciaText=="V/D" || asistenciaText=="V/D2"){
              	vdisfrutadas=parseInt(vdisfrutadas)+parseInt(valorAsistencia);
              }

         result += "<td width='40px' align='center'  style='" + style + "'class='demo1' numeroEmpleado='" + numeroEmpleado + "' fechaAsistenciaConsulta='" + fechaAsistenciaConsulta + "' nombreEmpleado='" + nombreEmpleado + "' puntoServicioAsistenciaId='" + puntoServicioAsistenciaId + "' comentarioIncidencia='" + comentarioIncidencia + "' incidenciaAsistenciaId = '" +incidenciaAsistenciaId+ "' asistenciaText='" +asistenciaText+ "' supervisorId='"+supervisorId+"'>" + asistenciaText +"</td>";
    }


        result +="<td width='20px' id='td_TotalTurnosPeriodo"+numeroEmpleado+"' name='td_TotalTurnosPeriodo"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"' faltas='"+faltas+"' permisos='"+permisos+"' incapacidades='"+incapacidades+"' baja='"+baja+"' vpagadas='"+vpagadas+"' vdisfrutadas='"+vdisfrutadas+"'>"+sumaTurnosPeriodo+"</td>";

    return result;
}

function procesarNomina()
    {
        
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" ):
      ?>
      supervisorId=$("#selectSupervisor").val();
      <?php
      endif;
      ?>

        
        $("#tableProcesoNomina").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosBySupervisorPeriodo.php",
            data : {"fecha1":fechaConsulta1, "fecha2":fechaConsulta2, "periodoId":periodoConsultaId,"supervisorId":supervisorId },
            dataType: "json",
             success: function(response) {
             //console.log(response);
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                     
                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var empleadoIdPuesto=empleadoEncontrado[i].empleadoIdPuesto;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
                      var tipoPeriodo=empleadoEncontrado[i].tipoPeriodo;
                      var entidadTrabajo=empleadoEncontrado[i].entidadTrabajo;
                      var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                      var puntoServicio=empleadoEncontrado[i].puntoServicio;
                      var empleadoIdPuntoServicio=empleadoEncontrado[i].empleadoIdPuntoServicio;
                      var asistencia = empleadoEncontrado[i].asistencia;
                      var sumaTurnosExtras=empleadoEncontrado[i].turnosExtras.sumaTurnosExtras;
                      var descuentos=empleadoEncontrado[i].descuentos.descuentos;
                      var incidenciasEspeciales=empleadoEncontrado[i].incidenciasEspeciales.incidenciasEspeciales;
                      var cliente=empleadoEncontrado[i].razonSocial;
                      var supervisorId = empleadoEncontrado[i].supervisorId;
                      var supervisorName = empleadoEncontrado[i].supervisor;
                      var numeroCta="'" + empleadoEncontrado[i].numeroCta;
                      var numeroCtaClabe= "'"+empleadoEncontrado[i].numeroCtaClabe;
                      var fechaIngreso=empleadoEncontrado[i].fechaIngresoEmpleado;
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
                      var cuotaDiariaEmpleado=parseFloat(empleadoEncontrado[i].cuotaDiariaEmpleado).toFixed(2);
                      var bonoAsistenciaEmpleado=parseFloat(empleadoEncontrado[i].bonoAsistenciaEmpleado).toFixed(2);
                      var bonoPuntualidadEmpleado=parseFloat(empleadoEncontrado[i].bonoPuntualidadEmpleado).toFixed(2);
                      var bonoAplicado=parseInt(bonoAsistenciaEmpleado)+parseInt(bonoPuntualidadEmpleado);

                      var montofonacot=parseFloat(empleadoEncontrado[i].fonacot).toFixed(2);
                      var montoinfonavit=parseFloat(empleadoEncontrado[i].infonavit).toFixed(2);
                      var montopension=parseFloat(empleadoEncontrado[i].pension).toFixed(2);
                      var montoprestamo=parseFloat(empleadoEncontrado[i].prestamo).toFixed(2);
                      var montoalimentos=parseFloat(empleadoEncontrado[i].alimentos).toFixed(2);
                   
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }

                     var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td>" + crearCeldasConsultaAsistenciaForNomina(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId) + "";
                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable+= "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"'  name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px'  numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td><td>"+cuotaDiariaEmpleado+"</td>";
                     
                     dateTable+="<td>"+bonoAsistenciaEmpleado+"</td>";
                     dateTable+="<td>"+bonoPuntualidadEmpleado+"</td>";  
                     dateTable+="<td id='td_sueldo_"+numeroEmpleado+"' name='td_sueldo_"+numeroEmpleado+"'></td>";                 
                     dateTable+="<td id='tdt_faltas_"+numeroEmpleado+"' name='tdt_faltas_"+numeroEmpleado+"'></td><td id='tdt_permisos_"+numeroEmpleado+"' name='tdt_permisos_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='tdt_vpagadas_"+numeroEmpleado+"' name='tdt_vpagadas_"+numeroEmpleado+"'><td id='tdt_vDisfrutadas_"+numeroEmpleado+"' name='tdt_vDisfrutadas_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='td_montoVacacionesPagadas_"+numeroEmpleado+"' name='td_montoVacacionesPagadas_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='td_primaVacacional_"+numeroEmpleado+"' name='td_primaVacacional_"+numeroEmpleado+"'></td>";
                     dateTable+="<td id='tdt_bonos_"+numeroEmpleado+"' name='tdt_bonos_"+numeroEmpleado+"'></td><td id='td_sueldoBruto_"+numeroEmpleado+"' name='td_sueldoBruto_"+numeroEmpleado+"'></td></td><td id='td_fonacot_"+numeroEmpleado+"' name='td_fonacot_"+numeroEmpleado+"'></td><td id='td_infonavit_"+numeroEmpleado+"' name='td_infonavit_"+numeroEmpleado+"'></td><td id='td_pension_"+numeroEmpleado+"' name='td_pension_"+numeroEmpleado+"'></td><td id='td_prestamo_"+numeroEmpleado+"' name='td_prestamo_"+numeroEmpleado+"'> <td id='td_alimentos_"+numeroEmpleado+"' name='td_alimentos_"+numeroEmpleado+"'><td id='td_netoalpago_"+numeroEmpleado+"' name='td_netoalpago_"+numeroEmpleado+"'></td></tr>" 
                     $('#tableProcesoNomina').append(dateTable);


                    var tQuicena=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    var faltas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("faltas");
                    var permisos=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("permisos");
                    var incapacidades=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("incapacidades");
                    var baja=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("baja");
                    var vpagadas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("vpagadas");
                    var vdisfrutadas=$("#td_TotalTurnosPeriodo"+numeroEmpleado).attr("vdisfrutadas");

                    var montoVacacionesPagadas=0;
                    var primaVacacional=0;
                    var extra=0;
                    var diasVacaciones=parseInt(vpagadas)+parseInt(vdisfrutadas);
                    var primaVacacional=(diasVacaciones*cuotaDiariaEmpleado)*0.25;



                    $("#tdt_faltas_"+numeroEmpleado).html(faltas);
                    $("#tdt_permisos_"+numeroEmpleado).html(permisos);
                    $("#tdt_vpagadas_"+numeroEmpleado).html(vpagadas);
                    $("#tdt_vDisfrutadas_"+numeroEmpleado).html(vdisfrutadas);
                    $("#td_primaVacacional_"+numeroEmpleado).html(primaVacacional);

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

                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tDiasFestivos);
                    var diasfestipospordos=parseInt(tDiasFestivos);
                    var sueldo=((turnosTotales+diasfestipospordos)*cuotaDiariaEmpleado);
                    var sueldoBruto=parseFloat(sueldo)+parseFloat(bonoAplicado)+parseFloat(montoVacacionesPagadas)+parseFloat(primaVacacional);
                    var netoalpago=parseFloat((sueldoBruto-montofonacot-montoinfonavit-montopension-montoprestamo-montoalimentos));
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);
                    $("#tdt_bonos_"+numeroEmpleado).html(bonoAplicado);
                    $("#td_montoVacacionesPagadas_"+numeroEmpleado).html(montoVacacionesPagadas);
                    $("#td_sueldo_"+numeroEmpleado).html(parseFloat(sueldo).toFixed(2));
                    $("#td_sueldoBruto_"+numeroEmpleado).html(parseFloat(sueldoBruto).toFixed(2));
                    $("#td_fonacot_"+numeroEmpleado).html(montofonacot);
                    $("#td_infonavit_"+numeroEmpleado).html(montoinfonavit);
                    $("#td_pension_"+numeroEmpleado).html(montopension);
                    $("#td_prestamo_"+numeroEmpleado).html(montoprestamo);
                    $("#td_alimentos_"+numeroEmpleado).html(parseFloat(montoalimentos).toFixed(2) );  
                    $("#td_netoalpago_"+numeroEmpleado).html(parseFloat(netoalpago).toFixed(2) ); 

                    if(turnosTotales>0){

                      registrarNomina(numeroEmpleado, empleadoIdPuesto,empleadoIdPuntoServicio,fechaConsulta1,fechaConsulta2, tipoPeriodo,turnosTotales,cuotaDiariaEmpleado,bonoAsistenciaEmpleado, bonoPuntualidadEmpleado,bonoAplicado,montoVacacionesPagadas, primaVacacional,sueldoBruto,montofonacot,montoinfonavit,montopension,montoprestamo,montoalimentos,netoalpago);

                    }                  
                                
                  }
                    
                    registrarFechaCierre(fechaConsulta1, fechaConsulta2,periodoConsultaId);


                    waitingDialog.hide();  
                  
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                } 
            },
           error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });

    }


    function registrarNomina(numeroEmpleado, empleadoIdPuesto,empleadoIdPuntoServicio,fechaConsulta1,fechaConsulta2, tipoPeriodo,turnosTotales,cuotaDiariaEmpleado,bonoAsistenciaEmpleado, bonoPuntualidadEmpleado,bonoAplicado,montoVacacionesPagadas, primaVacacional,sueldoBruto,montofonacot,montoinfonavit,montopension,montoprestamo,montoalimentos,netoalpago)
  {

          waitingDialog.show();
        $.ajax({
            type: "POST",
            url: "ajax_registroNomina.php",
            data: {numeroEmpleado:numeroEmpleado,empleadoIdPuesto:empleadoIdPuesto, empleadoIdPuntoServicio:empleadoIdPuntoServicio, fechaConsulta1:fechaConsulta1,fechaConsulta2:fechaConsulta2,
              tipoPeriodo:tipoPeriodo, turnosTotales:turnosTotales, cuotaDiariaEmpleado:cuotaDiariaEmpleado, bonoAsistenciaEmpleado:bonoAsistenciaEmpleado, bonoPuntualidadEmpleado:bonoPuntualidadEmpleado,
              bonoAplicado:bonoAplicado, montoVacacionesPagadas:montoVacacionesPagadas, primaVacacional:primaVacacional,  sueldoBruto:sueldoBruto,montofonacot:montofonacot,montoinfonavit:montoinfonavit,
              montopension:montopension,montoprestamo:montoprestamo,montoalimentos:montoalimentos,netoalpago:netoalpago},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  
  
                } else if (response.status=="error")
                {
                  waitingDialog.hide();
                  alert("error");
                }
              },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
        });
    
  }


     function parseDate (fecha)
     {
         var elementos = fecha.split ("-");

         return new Date (elementos[0], elementos[1] - 1, elementos[2]);
     }

     function generarColumnasRangoFechas (fecha1, fecha2)
     {
         var result = "";
         var rangoFechas = crearRangoFechas (fecha1, fecha2);

         for (var i = 0; i < rangoFechas.length; i++)
         {
             var fecha = rangoFechas [i];
             result += "<th>" + fecha.getFullYear () + "-" + (fecha.getMonth () + 1) + "-" + fecha.getDate() + "</th>";
         }

         return result;
     }

  function consultaPeticionesAsistenciaMermaParaCerrar() { 
    var fechaInicioPeriodo = "";
    var fechaTerminoPeriodo = "";
    var caso = "0";
    $.ajax({
        type: "POST",
        url: "ajax_consultaPeticionesAsistenciaMermaParaCerrar.php",
        data: {"fechaInicioPeriodo":fechaInicioPeriodo,"fechaTerminoPeriodo":fechaTerminoPeriodo,"caso":caso},
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                var dato = response.datos;
                if(dato == "0"){
                  consultaPeticionesCapacitacionParaCerrar();
                }else{
                  alert("Tienes Peticiones De Merma Pendientes, Dirigete Al Modulo De 'Peticiones Merma' Para Aceptar/Declinar Y Poder Continuar Con El Cierre De Nomina");
                }
             } else {
                 var mensaje = response.message; 
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
 }

 function consultaPeticionesCapacitacionParaCerrar() { 
    $.ajax({
        type: "POST",
        url: "ajax_consultaPeticionesCapacitacionParaCerrar.php",
        dataType: "json", 
        async: false,
        success: function(response) {
            if (response.status == "success") {
                var dato = response.datos;
                if(dato == "0"){
                  modalConfirmacionNomina();
                }else{
                  alert("Tienes Peticiones De Capacitación Pendientes, Dirigete Al Modulo De 'Peticiones turno Capacitación' Para Aceptar/Rechazar Y Poder Continuar Con El Cierre De Nomina");
                }
             } else {
                 var mensaje = response.message;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
 }

     function modalConfirmacionNomina(){

      var fechaInicioPeriodo = fechaConsulta1;
      var fechaTerminoPeriodo = fechaConsulta2;
      var idTipoPeriodo=1;
      var nombreperiodo=$('input:radio[name=optionPeriodoProcesoNomina]:checked').val();//nombre del periodo
      if(nombreperiodo=="SEMANAL"){
        idTipoPeriodo=0;
      }
     // alert(idTipoPeriodo);
      var mensajeNomina="";
      $.ajax({
        type: "POST",
        url: "ajax_consultaCierrePeriodo.php",
        data: {"fechaInicioPeriodo":fechaInicioPeriodo,"fechaTerminoPeriodo":fechaTerminoPeriodo,"idTipoPeriodo":idTipoPeriodo},
        dataType: "json",
        success: function(response) {
          if (response.status == "success")
          {

       // console.log(response.datosCierrePeriodo.length);

            //procesarNomina();
            if(response.datosCierrePeriodo.length==1){
             // alert("el periodo actual ha sido cerrado");

               mensajeNomina="<h3>EL PERIODO ACTUAL HA SIDO CERRADO </h3>";
               // btncerrarnomina
               $("#btncerrarnomina").hide();
            }else{
                 mensajeNomina="<h3>PERIODO: "+nombreperiodo+"<br> DEL:  "+ fechaConsulta1+ " AL: "+fechaConsulta2+"</h3>";
            $("#btncerrarnomina").show();
            }
             $("#msgCierreNomina").html(mensajeNomina);

      $('#myModalCerrarNomina').modal();
       
        
            
          }else if (response.status == "error" && response.message == "No autorizado")
          {
            window.location = "index.php";
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });




      
    }


     function formatDateYYYYMMDD (date)
     {
          var mm = date.getMonth() + 1; // getMonth() is zero-based
          if (mm < 10)
          {
              mm = "0"+mm;
          }

          var dd = date.getDate();
          if (dd < 10)
          {
              dd = "0" + dd;
          }

          return [date.getFullYear(), mm, dd].join('-'); // padding
     }

    function registrarFechaCierre(fechaConsulta1, fechaConsulta2,periodoConsultaId){
      $.ajax({
        type: "POST",
        url: "ajax_registroFechaCierre.php",
        data: {"fechaInicio":fechaConsulta1,"fechaTermino":fechaConsulta2, "periodoId":periodoConsultaId},
        dataType: "json",
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="error") {
            waitingDialog.hide();
            alert("error");
          }else{
            alert("EL PERIODO HA SIDO CERRADO CORRECTAMENTE!");
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
        });
    }

    function verificaCierrePeriodo(fechaInicioPeriodo, fechaTerminoPeriodo, idTipoPeriodo){
   

   $.ajax({
              
    type: "POST",
    url: "ajax_consultaCierrePeriodo.php",
    data:{fechaInicioPeriodo:fechaInicioPeriodo,fechaTerminoPeriodo:fechaTerminoPeriodo,idTipoPeriodo:idTipoPeriodo },
    dataType: "json",
     success: function(response) {
        if (response.status == "success")
        {
     
           var datos = response.datosCierrePeriodo;
           var fechaCierre="";
           var fechaCambioPeriodo="";

            for ( var i = 0; i < datos.length; i++ ){

              fechaCierre=datos[i].fechaCierrePeriodo;
              fechaCambioPeriodo=datos[i].fechaCambioPeriodo;

            }

            //$("#txtFechaCierre").val(fechaCierre);
            //$("#txtCambioPeriodo").val(fechaCambioPeriodo);

            if(fechaCierre!=""){
              //consultaDiferencias(fechaInicioPeriodo, fechaTerminoPeriodo, fechaCierre,fechaCambioPeriodo, idTipoPeriodo);
              //alert("Periodo cerrado");
            }else{
              //$("#divDiferencias").html("");
              if(idTipoPeriodo==1){
                
                $.notify("No se cerró periodo Quincenal", {autoHideDelay: 60000, className: 'error'});

              }else{
                
                $.notify("No se cerró periodo Semanal", {autoHideDelay: 60000, className: 'error'});

              }
               
              //alert("No se ha cerrado periodo");
            }


        }else if (response.status == "error" && response.message == "No autorizado")
        {
            window.location = "index.php";
        }
    },
    error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
    });

  }

 

     $("#descargarNomina").click(function(event) {
     $("#datos_nomina").val( $("<div>").append( $("#divTableProcesoNomina").eq(0).clone()).html());
     $("#form_prosesoNomina").submit();
    });

  
</script>
