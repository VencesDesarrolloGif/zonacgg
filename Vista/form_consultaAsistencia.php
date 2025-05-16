<?php
require_once ("../Negocio/Negocio.class.php");
$negocio = new Negocio ();
//$log = new KLogger ( "vistaConsultaAsistencia.log" , KLogger::DEBUG );
?>
 
<div class="container" align="center" >
<form class="form-horizontal" id="form_consultaAsistencia" name="form_consultaAsistencia" action="ficheroExportAsistenciaGeneralSupervisor.php" target="_blank" method="post">
 <div class="btn-group" >
  <label class="btn btn-secondary">
    <input type="radio" name="optionPeriodoConsulta" id="optionPeriodoConsultaQuincenal" value="QUINCENAL" checked onclick="generarTablaPeriodoConsulta();"> QUINCENAL
  </label>
  <label class="btn btn-secondary ">
    <input type="radio" name="optionPeriodoConsulta" id="optionPeriodoConsultaSemanal" value="SEMANAL" onclick="generarTablaPeriodoConsulta();"> SEMANAL
  </label>
  </div>
  <br>
  <br>
  <button id="btnGenerarConsulta" name="btnGenerarConsulta" class="btn btn-info" type="button" onclick='getEmpleadosPeriodoBySupervisor();'> <span class="glyphicon glyphicon-play"></span>Generar Consulta Periodo Actual</button>
  <button id="btnConsultaPersonalizada" name="btnConsultaPersonalizada" class="btn btn-link" type="button" onclick="personalizarConsulta();" > <span class="glyphicon glyphicon-wrench"></span> Consulta personalizada</button>
  <br>
  <br>
  <input type="hidden" id="datos_asistencia" name="datos_asistencia" />
  <div id="divTableConsultaAsistencia" name="divTableConsultaAsistencia" align="center" class='container'>
  </div>
 
  <button id="descargarAsistencia" name="descargarAsistencia" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>


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
            Punto de servicio<select id="selectPuntoConsultaAsis" name="selectPuntoConsultaAsis"><option>PUNTOS DE SERVICIOS</option></select>
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
</form>
</div> <!-- fin div container -->

<script type="text/javascript">
  <?php 
  if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor" || $usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"  || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Gerente Regional" || $usuario["rol"] =="Radio Operador"):
                
                ?>
                                
                jQuery("#optionPeriodoConsultaQuincenal").attr('checked', true);
                 //alert($('input:radio[name=optionPeriodo]:checked').val());
                 
                var fechasAsistenciaConsulta = [];
                
                var fechaConsulta1="";
                var fechaConsulta2="";
                var periodoConsultaId="1";


                generarTablaPeriodoConsulta();

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
  
   function generarTablaPeriodoConsulta(){

          var tipoPeriodo = $('input:radio[name=optionPeriodoConsulta]:checked').val();


          //alert(tipoPeriodo);

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
        
        <?php

         if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

        ?>
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th>";
        tableConsultaAsistencia +="<th width='160px'>Nombre Empleado</th><th width='80px'>Fecha Ingreso</th><th width='120px'>No. Cta</th><th width='135px'>Cta Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Linea Negocio</th>";
        tableConsultaAsistencia +=" <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";

        <?php
      }else {
      ?>
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th><th>Fecha Ingreso</th><th>No. Cta</th><th>Cta. Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Supervisor</th><th width='160px'>Linea Negocio</th> <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
      <?php
      }
      ?>

        $('#divTableConsultaAsistencia').html(tableConsultaAsistencia); 

        //getEmpleadosPeriodoBySupervisor();
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
        <?php

         if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

        ?>
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th>";
        tableConsultaAsistencia +="<th width='160px'>Nombre Empleado</th><th width='80px'>Fecha Ingreso</th><th width='120px'>No. Cta</th><th width='135px'>Cta Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Linea Negocio</th>";
        tableConsultaAsistencia +=" <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";

        <?php
      }else {
      ?>
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th><th width='160px'>Nombre Empleado</th><th>Fecha Ingreso</th><th>No. Cta</th><th>Cta. Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Supervisor</th><th width='160px'>Linea Negocio</th> <?php foreach ($diasAsistenciaConsulta as $dia): ?> <th width='40px'><?php echo $dia["dia"]; ?> <?php endforeach; ?></th><th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
      <?php
      }
      ?>

        $('#divTableConsultaAsistencia').html(tableConsultaAsistencia); 
        //getEmpleadosPeriodoBySupervisor();

          }

    }
 
    //funcionalidad para consultar empleados y asistencia del periodo en curso
    //segun el usuario logeado
    //supervisor: solo ve personal a su cargo del periodo en curso
    //analista: ve todo el personal del periodo en curso

    function getEmpleadosPeriodoBySupervisor()
    {
        
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Gerente Regional" || $usuario["rol"] =="Radio Operador"):
      ?>
      supervisorId=$("#selectSupervisor").val();
      <?php
      endif;
      ?>

        //alert(supervisorId);
        $("#tableConsultaAsistencia").find("tr:gt(0)").remove();
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
                      var plantillaserv=empleadoEncontrado[i].roloperativo;
                      var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
                   
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }

                    <?php

                    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

                    ?>
                    var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td>"+ numeroCta+"</td><td>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td><td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='80px'>"+descripcionLineaNegocio+"</td> " + crearCeldasConsultaAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId) + "";
                    dateTable += "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                    dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                    dateTable += "<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                    dateTable += "<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>"                                                                  
                    $('#tableConsultaAsistencia').append(dateTable);
 
                    <?php
                    }else{
                    ?>
                     var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td><td width='80px'>"+descripcionLineaNegocio+"</td>" + crearCeldasConsultaAsistencia(numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId) + "";
                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>" 
                     $('#tableConsultaAsistencia').append(dateTable);
 

                    <?php
                    }
                    ?>
                    var tQuicena=$("#td_tqc_"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    

                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tDiasFestivos);
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);

                    }
                    waitingDialog.hide();  
                    tooltipAjax2();
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                //console.log (response);

            }
        });

    }


    function getEmpleadosByPuntoServicioRangoFecha()
    {

      var rangoFecha1=$("#txtFechaRango1").val();
      var rangoFecha2=$("#txtFechaRango2").val();
      var puntoServicioConsulta=$("#selectPuntoConsultaAsis").val();
             
      
        $("#tableConsultaAsistencia").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosByPuntoServicioRangoFecha.php",
            data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "puntoServicioConsulta":puntoServicioConsulta},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
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
                      var entidadTrabajo=empleadoEncontrado[i].entidadTrabajo;
                      var plantillaserv=empleadoEncontrado[i].roloperativo;
                      var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
                   
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }

                    <?php

                    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

                    ?>
                    var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td>"+ numeroCta+"</td><td>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td><td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";
                    dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);
                    dateTable += "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                    dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                    dateTable += "<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                    dateTable += "<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>"                                                                  
                    $('#tableConsultaAsistencia').append(dateTable);
 
                    <?php
                    }else{
                    ?>
                     var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";
                     dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);
                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";                     
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>" 
                     $('#tableConsultaAsistencia').append(dateTable);
 

                    <?php
                    }
                    ?>
                    var tQuicena=$("#td_tqc_"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tdDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    
                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tdDiasFestivos);
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);

                    }
                    waitingDialog.hide();  
                    tooltipAjax2();
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                //console.log (response);

            }
        });

    }

    function getEmpleadoByIdRangoFecha()
    {
      alert("Consulta por empleado y fechas");
      var rangoFecha1=$("#txtFechaRango1").val();
      var rangoFecha2=$("#txtFechaRango2").val();
      var numeroEmpleado=$("#txtNumeroEmpleadoConsulta").val();
      var elementosNumeroEmpleado = numeroEmpleado.split ("-");

      var empleadoEntidadId = elementosNumeroEmpleado[0];
      var empleadoConsecutivoId = elementosNumeroEmpleado[1];
      var empleadoTipoId = elementosNumeroEmpleado[2];
        
      
        $("#tableConsultaAsistencia").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosByIdRangoFecha.php",
            data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "empleadoEntidadId":empleadoEntidadId, "empleadoConsecutivoId":empleadoConsecutivoId, "empleadoTipoId":empleadoTipoId},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
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
                      var entidadTrabajo=empleadoEncontrado[i].entidadTrabajo;
                      var plantillaserv=empleadoEncontrado[i].roloperativo;
                      var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }

                    <?php

                    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

                    ?>
                    var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td>"+ numeroCta+"</td><td>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td><td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";
                    dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);
                    dateTable += "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                    dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                    dateTable += "<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                    dateTable += "<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>"                                                                  
                    $('#tableConsultaAsistencia').append(dateTable);
 
                    <?php
                    }else{
                    ?>
                     var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";
                     dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);
                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+rangoFecha1+"' fechaConsulta2='"+rangoFecha2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>" 
                     $('#tableConsultaAsistencia').append(dateTable);
 
                    <?php
                    }
                    ?>
                    var tQuicena=$("#td_tqc_"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tdDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    
                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tdDiasFestivos);
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);

                    }
                    waitingDialog.hide();  
                    tooltipAjax2();
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                //console.log (response);

            }
        });

    }


    function crearCeldasConsultaAsistencia (numeroEmpleado, nombreEmpleado, asistencia, empleadoIdPuntoServicio, supervisorId)
{
    // Variables Globales
    // fechasAsistencia
    // turnosCubiertos

    var result = "";
    var sumaTurnosPeriodo=0;

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
            if(asistenciaText =="CAP"){
               style = "background-color:#FF8000";
              }

         result += "<td width='40px' align='center'  style='" + style + "'class='demo1' numeroEmpleado='" + numeroEmpleado + "' fechaAsistenciaConsulta='" + fechaAsistenciaConsulta + "' nombreEmpleado='" + nombreEmpleado + "' puntoServicioAsistenciaId='" + puntoServicioAsistenciaId + "' comentarioIncidencia='" + comentarioIncidencia + "' incidenciaAsistenciaId = '" +incidenciaAsistenciaId+ "' asistenciaText='" +asistenciaText+ "' supervisorId='"+supervisorId+"'>" + asistenciaText +"</td>";
    }
        result +="<td width='20px' id='td_tqc_"+numeroEmpleado+"' name='td_tqc_"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"'>"+sumaTurnosPeriodo+"</td>";

    return result;
}

 function tooltipAjax2(){
                  
                  $(".tooltipster_item").tooltipster ({

                      trigger: 'click',
                      contentAsHTML: true,

                      functionBefore: function(instance, helper) {
        
                        var $origin = $(helper.origin);
        
                        // we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
                        if ($origin.data('loaded') !== true) {

                          var fecha1=$origin.attr('fechaConsulta1')
                          var fecha2=$origin.attr('fechaConsulta2');
                          var numeroEmpleado=$origin.attr('numeroEmpleado');
                          var tdTipo=$origin.attr('tdTipo');
                          if(tdTipo=='turnosExtras'){

                          $.get('ajax_getTurnosExtras.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                          
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var incidenciaId = data.lista[i].incidenciaId;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                                var puntoServicio = data.lista[i].puntoServicio;
                              
                                html+= "TURNO EXTRA | fecha: "+incidenciaFecha+" | Punto:"+puntoServicio+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax
                        }else if(tdTipo=='descuentos'){

                          $.get('ajax_getDescuentos.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                          
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var incidenciaId = data.lista[i].incidenciaId;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                              
                                html+= "DESCUENTO | fecha: "+incidenciaFecha+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax

                        }else if(tdTipo=='incidenciasEspeciales'){

                          $.get('ajax_getIncidenciasEspeciales.php?fecha1='+fecha1+'&fecha2='+fecha2+'&numeroEmpleado='+numeroEmpleado+'', function(data) {
                          
                              var html = "<div>";

                              data = $.parseJSON (data);
                              
                              if (data.lista.length === 0)
                              {
                                html += "Sin datos";
                              }

                              for (var i=0; i < data.lista.length; i++)
                              {
                                var descripcionIncidenciaEspecial = data.lista[i].descripcionIncidenciaEspecial;
                                var incidenciaFecha= data.lista[i].incidenciaFecha;
                                var incidenciaComentario = data.lista[i].incidenciaComentario;
                              
                                html+= descripcionIncidenciaEspecial+" | fecha: "+incidenciaFecha+" | Comentario: "+ incidenciaComentario+"<br>";
                              }

                              html+= "</div>";

                              instance.content(html);

                              // to remember that the data has been loaded
                              $origin.data('loaded', true);
                          }); //Fin ajax

                        } // fin if tipo de consulta
                        
                        }
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

     function generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado)
     {
          var result = "";
          var sumaTurnosPeriodo=0;

          for (var i = 0; i < rangoFechas.length; i++)
          {
              var fecha = formatDateYYYYMMDD (rangoFechas [i]);
              var asistenciaText = "&nbsp;";

              if (asistencia [fecha] != null)
              {
                  asistenciaText = asistencia[fecha]["nomenclaturaIncidencia"];
                  valorAsistencia=asistencia [fecha]["valorAsistencia"];
                  
                  if(valorAsistencia== null)
                  {
                   valorAsistencia=0;
                  }

              sumaTurnosPeriodo = parseInt(sumaTurnosPeriodo) + parseInt(valorAsistencia);    
          
              }

              var style = stylesConsulta [asistenciaText];

              if(asistenciaText=="ING"){
                asistenciaText="";
              }else if(asistenciaText=="DT12"){
                asistenciaText="2";
              }
              if(asistenciaText =="CAP"){
               style = "background-color:#FF8000";
              }

              result += "<td style='"+style+"'>" + asistenciaText + "</td>";
          }
          result +="<td width='20px' id='td_tqc_"+numeroEmpleado+"' name='td_tqc_"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"'>"+sumaTurnosPeriodo+"</td>";

          return result;
     }

     function crearRangoFechas (fecha1, fecha2)
     {
          var result = [];

          var fechaInicial = parseDate (fecha1);
          var fechaFinal   = parseDate (fecha2);

          while (fechaInicial <= fechaFinal)
          {
              result.push (fechaInicial);

              var nuevaFecha = new Date(fechaInicial)

              fechaInicial = new Date(nuevaFecha.setDate (nuevaFecha.getDate() + 1));
          }
          //console.log(result);
          return result;
     }

     function generarTablaRangoFecha(){

          var rangoFecha1=$("#txtFechaRango1").val();
          var rangoFecha2=$("#txtFechaRango2").val();

        //alert(tipoPeriodo);
        <?php
        if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){
        ?>
        
        //generar encabezado con lista de dias de periodo de consulta
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th>";
        tableConsultaAsistencia +="<th width='160px'>Nombre Empleado</th><th width='80px'>Fecha Ingreso</th><th width='120px'>No. Cta</th><th width='135px'>Cta Clabe</th>";
        tableConsultaAsistencia+="<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th><th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='140px'>Linea Negocio</th>";

        tableConsultaAsistencia += generarColumnasRangoFechas (rangoFecha1, rangoFecha2);

        tableConsultaAsistencia +="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
        
        <?php
        }else{
        ?>
        var tableConsultaAsistencia="<table class='table table-bordered table-striped' id='tableConsultaAsistencia' name='tableConsultaAsistencia'><thead><tr><th  width='80px'>#Empleado</th>";
        tableConsultaAsistencia+="<th width='160px'>Nombre Empleado</th><th>Fecha Ingreso</th><th>No. Cta</th><th>Cta. Clabe</th><th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Plantilla Servicio</th>";
        tableConsultaAsistencia+="<th width='140px'>Entidad trabajo</th><th width='140px'>Punto Servicio</th><th width='160px'>Cliente</th><th width='160px'>Supervisor</th><th width='160px'>Linea Negocio</th>";

        tableConsultaAsistencia += generarColumnasRangoFechas (rangoFecha1, rangoFecha2);
        
        tableConsultaAsistencia+="<th>T.Q</th><th>T.E</th><th>D.F</th><th>Des.</th><th>I.E</th><th>TOTAL</th></tr></thead><tbody></tbody></table>";
        <?php
        }
        ?>

        $('#divTableConsultaAsistencia').html(tableConsultaAsistencia);      
    }
    function opcionConsulta(){
      var rangoFecha1=$("#txtFechaRango1").val();
      var rangoFecha2=$("#txtFechaRango2").val();
      var selectPuntoConsultaAsis=$("#selectPuntoConsultaAsis").val();
      var numeroEmpleadoConsulta=$("#txtNumeroEmpleadoConsulta").val();
      if(rangoFecha1=="" || rangoFecha2==""){
        var alertMsg="<div id='msgAlertR' class='alert alert-error'><strong>Firma</strong>Error: Proporcione fechas de consulta</div>";
        $("#divMsgConsulta").html(alertMsg);
        $('#msgAlertR').delay(3000).fadeOut('slow');
      }
      if(rangoFecha1!="" && rangoFecha2!="" && selectPuntoConsultaAsis=="PUNTOS DE SERVICIOS" && numeroEmpleadoConsulta=="")
      {
      $("#modalConsultaPersonalizada").modal('hide');
      generarTablaRangoFecha();
      getEmpleadosByRangoFecha();
      }
      if(rangoFecha1!="" && rangoFecha2!="" && selectPuntoConsultaAsis!="PUNTOS DE SERVICIOS"){ 
        $("#modalConsultaPersonalizada").modal('hide');
        generarTablaRangoFecha();
        getEmpleadosByPuntoServicioRangoFecha();
      }
      if(rangoFecha1!="" && rangoFecha2!="" && selectPuntoConsultaAsis=="PUNTOS DE SERVICIOS" && numeroEmpleadoConsulta!=""){
        $("#modalConsultaPersonalizada").modal('hide');
        generarTablaRangoFecha();
        getEmpleadoByIdRangoFecha();
      }
    }
    function personalizarConsulta(){
      $("#modalConsultaPersonalizada").modal();
      var a='';
        <?php
        if($usuario["rol"] =="Consulta Supervisor"):
        ?>
        a=1;
        <?php
        endif;
        ?>
          if(a==1){funcioncargaselector();}
    }
function funcioncargaselector(){
//aqui el ajax que llenara el selector solo en caso de que el rol de usuario sea "Consulta Supervisor" | -> talque rolid =25"
          $.ajax ({
            type: "POST"
            ,url: "ajax_getPuntosServRolConsultaSup.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {//console.log(response);
                $('#selectPuntoConsultaAsis').empty().append('<option>PUNTOS DE SERVICIOS</option>');   
                if (response.status == "success")
                {
                  for (var i = 0; i < response.datos.length; i++)
                  {
                    $('#selectPuntoConsultaAsis').append('<option id="'+'op_'+response.datos[i]["idPuntoServicio"]+'"value="'+response.datos[i]["idPuntoServicio"] +'"cobradescansos="'+response.datos[i]["cobraDescansos"]+'"cobradiafestivo="'+response.datos[i]["cobraDiaFestivo"]+'"valorcobra31="'+ response.datos[i]["cobra31"]+'"idcliente="'+response.datos[i]["idClientePunto"]+'">'+response.datos[i]["puntoServicio"]+'</option>');
                  }   
                }
            }
            ,error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
}
    function getEmpleadosByRangoFecha()
    {
      var fechaConsulta1=$("#txtFechaRango1").val();
      var fechaConsulta2=$("#txtFechaRango2").val();  
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"  || $usuario["rol"] =="Contrataciones" || $usuario["rol"] =="Gerente Regional" || $usuario["rol"] =="Radio Operador"):
      ?>
      supervisorId=$("#selectSupervisor").val();
      <?php
      endif;
      ?>
    
        $("#tableConsultaAsistencia").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosByRangoFecha.php",
            data : {"fecha1":fechaConsulta1, "fecha2":fechaConsulta2,"supervisorId":supervisorId },
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    
                    var rangoFechas = crearRangoFechas (fechaConsulta1, fechaConsulta2);
                                                                            
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
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
                      var entidadTrabajo=empleadoEncontrado[i].entidadTrabajo;
                      var plantillaserv=empleadoEncontrado[i].roloperativo;
                      var descripcionLineaNegocio=empleadoEncontrado[i].descripcionLineaNegocio;
                      if(incidenciasEspeciales==null){
                        incidenciasEspeciales=0;
                      }
                      
                      if(descuentos==null){
                        descuentos=0;
                      }
                      
                      if(sumaTurnosExtras==null){
                        sumaTurnosExtras=0;
                      }



                      var dateTable = "";
                    <?php

                    if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){

                    ?>

                    // traer asistencia del rando de fecha
                    dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td>"+ numeroCta+"</td><td>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td><td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";

                    dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);

                    dateTable += "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                    dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                    dateTable += "<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                    dateTable += "<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td><td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>"                                                                  
 
                    <?php
                    }else{
                    ?>
                     dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='80px'>"+fechaIngreso+"</td><td width='130px'>"+ numeroCta+"</td><td width='135px'>"+numeroCtaClabe+"</td><td width='100px'>"+descripcionPuesto+"</td><td width='80px'>"+descripcionTurno+"</td><td width='80px'>"+plantillaserv+"</td>";
                     dateTable+="<td width='140px'>"+entidadTrabajo+"</td><td width='140px'>"+puntoServicio+"</td><td width='160px'>"+cliente+"</td><td width='160px'>"+supervisorName+"</td><td width='160px'>"+descripcionLineaNegocio+"</td>";

                     dateTable += generarCeldasAsistencia (rangoFechas, asistencia, numeroEmpleado);

                     dateTable+= "<td width='20px' id='td_tec_"+numeroEmpleado+"' name='td_tec_"+numeroEmpleado+"' sumaTurnosExtras='"+sumaTurnosExtras+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='turnosExtras'>"+ sumaTurnosExtras +"</td>";
                     dateTable += "<td width='20px' id='td_dfc_"+numeroEmpleado+"' name='td_dfc_"+numeroEmpleado+"' sumaDiasFestivos='"+sumaDiasFestivos+"' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='sumaDiasFestivos'>"+ sumaDiasFestivos +"</td>";
                     dateTable+="<td width='30px' id='td_desc_"+numeroEmpleado+"' class='tooltipster_item' name='td_desc_"+numeroEmpleado+"' descuentos='"+descuentos+"' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='descuentos'>"+ descuentos+"</td>";
                     dateTable+="<td width='20px' class='tooltipster_item' numeroEmpleado='"+numeroEmpleado+"' fechaConsulta1='"+fechaConsulta1+"' fechaConsulta2='"+fechaConsulta2+"' tdTipo='incidenciasEspeciales'>"+ incidenciasEspeciales +"</td>";
                     dateTable+="<td name='td_ttc_"+ numeroEmpleado+"' id='td_ttc_"+numeroEmpleado+"'><div id='divTotalc_"+numeroEmpleado+"' id='divTotalc_"+numeroEmpleado+"'></div></td></tr>" 
 

                    <?php
                    }
                    ?>

                    $('#tableConsultaAsistencia').append(dateTable);

                    var tQuicena=$("#td_tqc_"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    var tExtras=$("#td_tec_"+numeroEmpleado).attr("sumaTurnosExtras");
                    var tDescuentos=$("#td_desc_"+numeroEmpleado).attr("descuentos");
                    var tDiasFestivos=$("#td_dfc_"+numeroEmpleado).attr("sumaDiasFestivos");
                    

                    var turnosTotales= parseInt(tQuicena) + parseInt(tExtras) - Math.abs(tDescuentos) + parseInt(tDiasFestivos) ;
                    $("#divTotalc_"+numeroEmpleado).html(turnosTotales);

                    }
                    waitingDialog.hide();  
                    tooltipAjax2();
                    
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                //console.log (response);

            }
        });

    }

  

    $("#selectPuntoConsultaAsis" ).focus(function() {
    $("#txtNumeroEmpleadoConsulta").val("");
    });

    $("#txtNumeroEmpleadoConsulta" ).focus(function() {
    $("#selectPuntoConsultaAsis").val("PUNTOS DE SERVICIOS");
    });

     $("#descargarAsistencia").click(function(event) {
     $("#datos_asistencia").val( $("<div>").append( $("#divTableConsultaAsistencia").eq(0).clone()).html());
     $("#form_consultaAsistencia").submit();
    });

  
  $('#txtFechaRango1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#txtFechaRango2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });
 
</script>
