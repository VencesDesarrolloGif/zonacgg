
<div class="container" align="center" >
<form class="form-horizontal" id="form_consultaFatigaconteo" name="form_consultaFatigaconteo" action="downloadexcelconteoincidenciaspordia.php" target="_blank" method="post">
  <div>
            DE:<input id="txtFechaFatiga1conteo" name="txtFechaFatiga1conteo" type="text" class="input-medium"> A: <input id="txtFechaFatiga2conteo" name="txtFechaFatiga2conteo" type="text" class="input-medium" onchange='cargarPuntosServiciosconteo();'>
            <br>
            <br>
              <?php
               if ($usuario["rol"] =="Facturacion" || $usuario["rol"] =="Analista Asistencia") {
              ?>
                <button id="descargarTodasconteo" name="descargarTodasconteo" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Todas</button>
                <br>
                <br>
                <select id="selectSupervisorFatigaconteo" name="selectSupervisorFatigaconteo" class="input-large" onchange="getPuntosServiciosBySupervisorFatigaconteo();" >
                <option>SUPERVISOR</option>
                <?php
                  for ($i=0; $i<count($catalogoSupervisoresOperativos); $i++)
                  {
                    echo "<option value='". $catalogoSupervisoresOperativos[$i]["supervisorId"]."'>". $catalogoSupervisoresOperativos[$i]["nombre"] ." </option>";
                  }                  
                ?>
                </select>
            <br>
            <br>
            <select id="selectEntidadFatigaconteo" name="selectEntidadFatigaconteo" class="input-large " onChange="obtenerPuntosServiciosPorEntidadFatigaconteo();" >
             <option>ENTIDAD FEDERATIVA</option>
              <?php
                for ($i=0; $i<count($catalogoEntidadesFederativas); $i++)
                {
                echo "<option value='". $catalogoEntidadesFederativas[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] ." </option>";
                }                 
              ?>
            </select>

            <?php
            }
            ?>
            <br>
            <br>
            <select id="selectPuntoServicioFatigaconteo" name="selectPuntoServicioFatigaconteo" onchange="getEmpleadosFatigaconteo();" ></select>

<br>
            <br>



 <select id="selectClienteConteo" name="selectClienteConteo" class="input-large ">
             <option value='0'>CLIENTE</option>
              <?php
                for ($i=0; $i<count($catatoloClientes); $i++)
                {
                echo "<option value='". $catatoloClientes[$i]["idCliente"]."'>". $catatoloClientes[$i]["razonSocial"] ." </option>";
                }                 
              ?>
            </select>
            <br>
            <div id="mostraropcionebyclinete" style="display: none">
              <a style="cursor: pointer" onclick="totalTotalesByCLiente();">Total</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <a style="cursor: pointer" onclick="reporteconteotodos(2);">Detalle</a>
            </div>
            
            <br>
            <!-- <select id="selectPuntoServicioFatiga2" name="selectPuntoServicioFatiga2" class="selectpicker" data-live-search="true" class="input-large" data-size="9">
              <option>Opcion 1</option>
              <option>Opcion 3</option>
              <option>Opcion 4</option>
              <option>Opcion 5</option>
              <option>Opcion 6</option>
            </select> -->
              <br>
            <br><!--cobraDescanso--> <input id="txtCobraDescansoFatigaconteo" name="txtCobraDescansoFatigaconteo" type="hidden" class="input-small" readonly>
            <br><!--cobraFestivo --><input id="txtCobraDiaFestivoconteo" name="txtCobraDiaFestivoconteo" type="hidden" class="input-small" readonly>
            <br><!--cobra31--> <input id="txtCobra31conteo" name="txtCobra31conteo" type="hidden" class="input-small" readonly>
    </div>

  <br>
  <br>
  <input type="hidden" id="datos_fatigaconteo" name="datos_fatigaconteo" />
  <div id="divFatigaconteo" name="divFatigaconteo" align="center" class='container'><br><br>
    <div id="divLogoconteo" name="divLogoconteo"></div>
    <div style="display: none;" id="divRequisicionFatigaconteo" name="divRequisicionFatigaconteo"> </div>
    <br>
    <br>
    <div id="divTableConsultaFatigaconteo" name="divTableConsultaFatigaconteo"></div><br><br>
    <div id="divTurnosExtrasconteo" name="divTurnosExtrasconteo"></div>
  </div>
 
  <button id="descargarFatigaconteo" name="descargarFatigaconteo" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
  <br>
  <br>
  
   <!--<button id="descargarFatigaPDF" name="descargarFatigaPDF" class="btn btn-danger" type="button" onclick="generadorFormatoFatigaconteo();"> <span class="glyphicon glyphicon-download-alt"></span>Descargar PDF</button> -->
  <br>
  <br>

  <?php 
  if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){
                
  ?>
  <!--<button id="enviarFatigaPDF" name="enviarFatigaPDF" class="btn btn-info" type="button" onclick="validacionEnvioFatigaconteo();"> <span class="glyphicon glyphicon-send"></span> Enviar Fatiga</button> --> 
  <?php
  }
  ?>
</form>


<div class="modal hide fade" tabindex="-1" name="modal_confirmacionEnvioFatiga" id="modal_confirmacionEnvioFatiga">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    
    <div name="dv_tituloMensaje" id="dv_tituloMensaje"></div>
  </div>
  <div class="modal-body">
    <div id="dv_mensaje" name="dv_mensaje"></div>
  </div>
  <div class="modal-footer" name="dv_botones" id="dv_botones">
    
  </div>
</div>
 


</div> <!-- fin div container -->



<script type="text/javascript">


var turnosPresupuestadosFatiga = 0;
var puntosTotales;
var turnosCubiertosFatiga = {};
var turnosExtra=0;

var stylesFatiga = [];

var turnosconteoincidencias = {};

                stylesFatiga ["DES"] = "background-color:#FEFF00";
                stylesFatiga ["PER"] = "background-color:#FFFFFF";
                stylesFatiga ["V/P"] = "background-color:#538136";
                stylesFatiga ["V/D"] = "background-color:#FFFFFF";
                stylesFatiga ["INC"] = "background-color:#FFFFFF";
                stylesFatiga ["F"] = "background-color:#FA5858";
                stylesFatiga ["B"] = "background-color:#FFFFFF";
                stylesFatiga ["ING"] = "background-color:#FFFFFF";
                stylesFatiga ["DT12"] = "background-color:#FEFF00";
                stylesFatiga ["1"] = "background-color:#FFFFFF";                
                stylesFatiga ["2"] = "background-color:#FFFFFF";
                stylesFatiga ["V/P2"] = "background-color:#538136";
                stylesFatiga ["V/D2"] = "background-color:#FFFFFF";


var stylesTurno = [];

                stylesTurno [2] = "background-image: url(\"img/triangulo_2.png\");background-position: center;";
                stylesTurno [3] = "background-image: url(\"img/triangulo_3.png\");background-position: center;";
                stylesTurno [4] = "background-image: url(\"img/triangulo_4.png\");background-position: center;";
                stylesTurno [5] = "background-image: url(\"img/triangulo_5.png\");background-position: center;";
                stylesTurno [1] = "background-image: url(\"img/triangulo_1.png\");background-position: center;";
                stylesTurno [6] = "background-image: url(\"img/triangulo_6.png\");background-position: center;";
                stylesTurno [7] = "background-image: url(\"img/completo_7.png\");background-position: center;";


             
  function generarTablaRangoFechaFatigaconteo(opcion){

          var rangoFecha1=$("#txtFechaFatiga1conteo").val();
          var rangoFecha2=$("#txtFechaFatiga2conteo").val();
          if(opcion==1){
              //generar encabezado con lista de dias de periodo de consulta
              var table="<table class='table table-bordered table-striped'  border='3px' id='tableConsultaFatigaconteo' name='tableConsultaFatigaconteo'><thead><tr><th  width='80px'>#Empleado</th>";
              table +="<th width='160px'>Nombre Empleado</th>";
              table+="<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>Rol Operativo</th><th width='80px'>Supervisor</th><th width='80px'>Punto Servicio</th><th width='80px'>Entidad Punto</th>";
          }else{
              var table="<table class='table table-bordered table-striped' style='display: none' border='3px' id='tableConsultaFatigaconteo' name='tableConsultaFatigaconteo'><thead><tr><th  width='160px'>Nombre Cliente</th>";
              table +="<th width='160px'>Punto de Servicio</th>";
              table +="<th width='80px'>Entidad</th>";
              table +="<th width='160px'>Supervisor</th>";
              table +="<th width='160px'>Numero Empleado</th>";
              table +="<th width='160px'>Nombre Empleado</th>";
              table+="<th width='100px'>Puesto</th><th width='80px'>Turno</th> <th width='80px'>Rol Operativo</th>";
          }
       table += generarColumnasRangoFechas(rangoFecha1, rangoFecha2);//esta funcion se encuentra en el formulariode consulta asistencia

        table +="<th>T.Q</th><th>D.F</th><th>TOTAL</th><th width='20px'>TOTAL + EXTRAS</th></tr></thead><tbody></tbody></table>";
        $('#divTableConsultaFatigaconteo').html(table);
                    
    }

    function getEmpleadosFatigaconteo()
    {



      generarTablaRangoFechaFatigaconteo(1);
      var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();
      var puntoServicio=$("#selectPuntoServicioFatigaconteo").val();      
      
      var valorCobraDescanso=$("#op_spsf"+puntoServicio).attr("cobradescansos");
      var valorCobraDiaFestivo=$("#op_spsf"+puntoServicio).attr("cobraDiaFestivo");
      var valorCobra31=$("#op_spsf"+puntoServicio).attr("valorCobra31conteo");

      $("#txtCobraDescansoFatigaconteo").val(valorCobraDescanso);
      $("#txtCobraDiaFestivoconteo").val(valorCobraDiaFestivo);
      $("#txtCobra31conteo").val(valorCobra31);

      elementosSolicitadosFatigaconteo(puntoServicio);
      getTurnosExtrasFatigaconteo(puntoServicio);
           
        $("#tableConsultaFatigaconteo").find("tr:gt(0)").remove();
        waitingDialog.show();

        $.ajax({
            
            type: "POST",
            url: "ajax_getEmpleadosFatiga.php",
            data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "puntoServicio":puntoServicio},
            dataType: "json",
             success: function(response) {
              console.log("ajax_getEmpleadosFatiga");
              //console.log(response);
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);//funcion que se encuentra en el formulario de consulta asistencias que genera las celdas de las fechas
                    var turnosACobrar=0;
                    var totalFestivos=0;

                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
                      var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                      var asistencia = empleadoEncontrado[i].asistencia;
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
                      var roloperativo=empleadoEncontrado[i].roloperativo;
                      var supervisor=empleadoEncontrado[i].nombresupervisor;
                      var puntoservicio=empleadoEncontrado[i].puntoServicio;
                      var entidadpunto=empleadoEncontrado[i].entidadpunto;

                    var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td>";
                    dateTable+="<td width='80px'>"+roloperativo+"</td>";
                    dateTable+="<td width='80px'>"+supervisor+"</td>";
                    dateTable+="<td width='80px'>"+puntoservicio+"</td>";
                    dateTable+="<td width='80px'>"+entidadpunto+"</td>";;


                    dateTable += generarCeldasFatigaconteo (rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos);
                    dateTable += "</tr>"  

                    $('#tableConsultaFatigaconteo').append(dateTable);

                    var turnos= $("#td_tqc_c"+numeroEmpleado).attr("sumaTurnosPeriodo");
                    turnosACobrar=parseInt(turnosACobrar) + parseInt(turnos);

                    totalFestivos=parseInt(totalFestivos)+parseInt(sumaDiasFestivos);

                    

                    //var diasFestivos= $("#td_tdff_"+numeroEmpleado).attr("sumaDiasFestivos");
                    //totalFestivos=parseInt(turnosFestivos) + parseInt(diasFestivos);
                    //alert(totalFestivos);
 
                    }
                   // alert(turnosACobrar);

                    waitingDialog.hide();  
                    tooltipAjax2();
                    obtenerTurnosCubiertosconteo(turnosACobrar,totalFestivos);
                    //elementosSolicitadosFatiga();
                    turnosExtra=0;
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }else if(response.status=="error"){

                  alert(response.error);
                  waitingDialog.hide();  


                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                 // alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });

    }

    function elementosSolicitadosFatigaconteo(idPuntoServicio){

    document.getElementById("divTurnosExtrasconteo").innerHTML="";

     var puntoServicio=$("#selectPuntoServicioFatigaconteo option:selected").html();
       $.ajax({
            
            type: "POST",
            url: "ajax_getDetalleRequisicionesByPuntoServicioId.php",
            data: {"puntoServicioId": idPuntoServicio},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                    
                    
                    var listaTable="<table border='3px' class='table table-bordered table-striped' ><thead><tr><th  colspan='3'>Elementos Solicitados "+puntoServicio+"</th></tr><tr><th>Elementos</th><th>Puesto</th><th>Turno</th></tr></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroElementos = lista[i].numeroElementos;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;
                           
                  listaTable += "<tr><td>"+numeroElementos+"</td><td> "+descripcionPuesto+"</td><td> "+descripcionTurno+"</td></tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  
                  $('#divRequisicionFatigaconteo').html(listaTable);  

                  //var img="<img src='"+imgLogo+"' width='100' height='100'>";

                  //$("#divLogo").html(img);    
                                     
                 }
            },           

            error: function(jqXHR, textStatus, errorThrown){
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }

    function getTurnosExtrasFatigaconteo(idPuntoServicio){

     //var puntoServicio=$("#selectPuntoServicioFatiga option:selected").html();
     var rangoFecha1=$("#txtFechaFatiga1conteo").val();
     var rangoFecha2=$("#txtFechaFatiga2conteo").val();
       $.ajax({
            
            type: "POST",
            url: "ajax_getTurnosExtrasFatiga.php",
            data: {"fecha1":rangoFecha1, "fecha2":rangoFecha2,"puntoServicioId": idPuntoServicio},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                    var totalExtras=0;
                    if (lista.length >=1){
                    //var imgLogo="https://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/logo.jpg";
                    
                    var listaTable="<table border='3px' class='table table-bordered table-striped'><thead><tr><th colspan='4'>EXTRAS</th></tr><tr><th>#Empleado</th><th>Nombre Empleado</th><th>Fecha</th><th>Comentario</th></tr></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombreEmpleado = lista[i].nombreEmpleado;
                        var incidenciaFecha = lista[i].incidenciaFecha;
                        var incidenciaComentario = lista[i].incidenciaComentario;
                        var valorIncidenciaEspecial= lista[i].valorIncidenciaEspecial;

                        totalExtras=parseInt(totalExtras)+ parseInt(valorIncidenciaEspecial);

                           
                      listaTable += "<tr><td>"+numeroEmpleado+"</td><td> "+nombreEmpleado+"</td><td> "+incidenciaFecha+"</td><td>"+incidenciaComentario+"</td></tr>";
 
                    }
                  turnosExtra=totalExtras;

                  listaTable += "<tr><td colspan='3'> Total Turnos Extras</td><td>"+totalExtras+"</td></tr></tbody></table>";
                  
                  $('#divTurnosExtrasconteo').html(listaTable);  

                  }

                  //var img="<img src='"+imgLogo+"' width='100' height='100'>";

                  //$("#divLogo").html(img);    
                                     
                }
            },           

            error: function(jqXHR, textStatus, errorThrown){
                //  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }

    function generarCeldasFatigaconteo(rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos)
    {
          var result = "";
          var sumaTurnosPeriodo=0;
          //console.log(asistencia);
          var descansos=0;
          var totalFestivos=0;
          var sumaTurnosDia31=0;
          var valor=0;
          var valorCobraDescanso=$("#txtCobraDescansoFatigaconteo").val();
          var valorCobraDiaFestivo=$("#txtCobraDiaFestivoconteo").val();
          var valorCobra31=$("#txtCobra31conteo").val();

          for (var i = 0; i < rangoFechas.length; i++)
          {
              var fecha = formatDateYYYYMMDD (rangoFechas [i]);
              var asistenciaText = "&nbsp;";
              //alert(fecha);

              if (asistencia [fecha] != null)
              {
                  asistenciaText = asistencia[fecha]["nomenclaturaIncidencia"];
                  //valorAsistencia=asistencia [fecha]["valorAsistencia"];
 
                  valorFatiga=asistencia[fecha]["valorCobertura"];

                  

                    if(asistenciaText=="DES"){

                      if(valorCobraDescanso==1){
                        valorFatiga=1;
                      }

                    }

                var dia=fecha.substring(8);

                sumaTurnosPeriodo = parseInt(sumaTurnosPeriodo) + parseInt(valorFatiga);   
                //alert(sumaTurnosPeriodo+"turnos al dia "+ dia); 

                if(dia==31){

                  sumaTurnosDia31=parseInt(sumaTurnosDia31)+parseInt(valorFatiga);
                         
                }

                  if(valorFatiga== null)
                  {
                   valorFatiga=0;
                  }

                valor= obtenerTurnoAsistenciaconteo(fecha,numeroEmpleado,asistencia[fecha]["puntoServicioAsistenciaId"]);

                //console.log("valor de valor"+i);  
                //console.log(valor); 
                
              }

              var style = stylesFatiga [asistenciaText];
              

              if(valor!=0)
                    style = stylesTurno[valor];


              if(asistenciaText=="ING"){
                asistenciaText="ING";
              }else if(asistenciaText=="F"){
                asistenciaText="F";
              }else if(asistenciaText=="PER"){
                asistenciaText="PER";
              }else if(asistenciaText=="V/P"){
                asistenciaText="V/P";
              }else if(asistenciaText=="V/D"){
                asistenciaText="V/D";
              }else if(asistenciaText=="INC"){
                asistenciaText="INC";
              }else if(asistenciaText=="B"){
                asistenciaText="B";
              }else if(asistenciaText=="DT12"){
                asistenciaText="DT12";
              }
              else if(asistenciaText=="V/P2"){
                asistenciaText="V/P2";
              }else if(asistenciaText=="V/D2"){
                asistenciaText="V/D2";
              }
              
              result += "<td style='" + style + "'>" + asistenciaText +"</td>";

              valor=0;
          }

          //if(valorCobraDescanso==1){

            //sumaTurnosPeriodo= parseInt(sumaTurnosPeriodo) + parseInt(descansos);

          //}

          if(valorCobra31==0){

            sumaTurnosPeriodo= parseInt(sumaTurnosPeriodo) - parseInt(sumaTurnosDia31);

          }

          if(valorCobraDiaFestivo==1){

            totalTurnos=parseInt(sumaTurnosPeriodo) + parseInt(sumaDiasFestivos);

          }else{
            totalTurnos=sumaTurnosPeriodo;
          }

          result +="<td width='20px' id='td_tqc_c"+numeroEmpleado+"' name='td_tqc_c"+numeroEmpleado+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"' descansos='"+descansos+"'>"+sumaTurnosPeriodo+"</td>";
          result +="<td width='20px' id='td_tdff_c"+numeroEmpleado+"' name='td_tdff_c"+numeroEmpleado+"' sumaDiasFestivos='"+ sumaDiasFestivos +"' >"+sumaDiasFestivos+"</td>";
          result +="<td width='20px' id='td_tqt_c"+numeroEmpleado+"' name='td_tqt_c"+numeroEmpleado+"' totalTurnos='"+totalTurnos+"'>"+totalTurnos+"</td>";

          return result;
     }

     function obtenerTurnosCubiertosconteo(turnosACobrar, totalFestivos){

        var idPuntoServicio=$("#selectPuntoServicioFatigaconteo").val();
        var rangoFecha1=$("#txtFechaFatiga1conteo").val();
        var rangoFecha2=$("#txtFechaFatiga2conteo").val();
      
         $.ajax({
              
              type: "POST",
              url: "ajax_generarResumenAsistenciaConteo.php",
              data: {"puntoServicioId": idPuntoServicio
                  , "fechaInicial": rangoFecha1
                  , "fechaFinal": rangoFecha2 },
              dataType: "json",
              async:false,
              success: function(response) {
                 console.log("resultadoajax");
                console.log(response);
                  if (response.status == "success")
                  {
                       
                      turnosPresupuestados = response.result;
                      turnosconteoincidencias = response.result;

                      var resumen = crearResumenDeTurnosFatigaconteo (turnosACobrar,totalFestivos,1);

                       //var resumen2 = crearResumenDeTurnosFatigaconteoincidencias(turnosACobrar,totalFestivos,1);
                      $('#tableConsultaFatigaconteo tr:last').after(resumen);
                      //$('#tableConsultaFatigaconteo tr:last').after(resumen2);
                       var totalincidencias=conteodeincidenciaspordia(turnosACobrar,totalFestivos,1);
                     $('#tableConsultaFatigaconteo tr:last').after(totalincidencias);
                  }
              },           

              error: function(jqXHR, textStatus, errorThrown){
                //  alert(jqXHR.responseText); 
            }
          });
    }

     function conteodeincidenciaspordia (turnosACobrar,totalFestivos,opcion)
  {
    // Variables globales
    // turnosPresupuestados
    // fechasAsistencia
    // turnosCubiertos
    //alert(turnosACobrar);
    var valorCobraDescanso=$("#txtCobraDescansoFatigaconteo").val();
    var valorCobraDiaFestivo=$("#txtCobraDiaFestivoconteo").val();

    var rangoFecha1=$("#txtFechaFatiga1conteo").val();
    var rangoFecha2=$("#txtFechaFatiga2conteo").val();

    var result = "";
    if(opcion==1){
      var columnades= "<td width='747px' align='right' colspan='8'>";
      var columnaT12x12= "<td width='747px' align='right' colspan='8'>";
      var columnaT24x24= "<td width='747px' align='right' colspan='8'>";
      var columnafalta= "<td width='747px' align='right' colspan='8'>";
        var columnavp = "<td width='747px' align='right' colspan='8'>";
        var columnavd = "<td width='747px' align='right' colspan='8'>";
         var columnapermisos = "<td width='747px' align='right' colspan='8'>";
         var columnaincapacidad = "<td width='747px' align='right' colspan='8'>";
         var columnadescansotrabajado12x12 = "<td width='747px' align='right' colspan='8'>";
         var columnabaja = "<td width='747px' align='right' colspan='8'>";
         var columnaingreso = "<td width='747px' align='right' colspan='8'>";
        var columnavp2 = "<td width='747px' align='right' colspan='8'>";
        var columnavacacionesdisfrutadas24x24 = "<td width='747px' align='right' colspan='8'>";
        var columnaturnosdedia = "<td width='747px' align='right' colspan='8'>";
        var columnaturnosdenoche = "<td width='747px' align='right' colspan='8'>";
    }else{
      var columnades = "<td width='747px' align='right' colspan='9'>";
       var columnaT12x12 = "<td width='747px' align='right' colspan='9'>";
       var columnaT24x24 = "<td width='747px' align='right' colspan='9'>";
        var columnafalta = "<td width='747px' align='right' colspan='9'>";
        var columnavp = "<td width='747px' align='right' colspan='9'>";
        var columnavd = "<td width='747px' align='right' colspan='9'>";
        var columnapermisos = "<td width='747px' align='right' colspan='9'>";
        var columnaincapacidad = "<td width='747px' align='right' colspan='9'>";
        var columnadescansotrabajado12x12 = "<td width='747px' align='right' colspan='9'>";
        var columnabaja = "<td width='747px' align='right' colspan='9'>";
        var columnaingreso = "<td width='747px' align='right' colspan='9'>";
        var columnavp2 = "<td width='747px' align='right' colspan='9'>";
         var columnavacacionesdisfrutadas24x24 = "<td width='747px' align='right' colspan='9'>";
         var columnaturnosdedia = "<td width='747px' align='right' colspan='9'>";
         var columnaturnosdenoche = "<td width='747px' align='right' colspan='9'>";
    }
    var rowTurnosCubiertosdescansos = "<tr >" + columnades + "Desacansos</td>";
    var rowTurnosCubiertos12x12 = "<tr >" + columnaT12x12 + "Turnos 12X12</td>";
    var rowTurnosCubiertos24x24 = "<tr >" + columnaT24x24 + "Turnos 24X24</td>";
    var rowTurnosCubiertosfalta = "<tr >" + columnafalta + "Faltas</td>";
    var rowTurnosCubiertosincidenciavp = "<tr >" + columnavp + "Vacaciones Pagadas</td>";
    var rowTurnosCubiertosincidenciavd = "<tr >" + columnavd + "Vacaciones Disfrutadas</td>";
     var rowTurnosCubiertospermisos = "<tr >" + columnapermisos + "Permisos</td>";
     var rowTurnosCubiertoincapacidad = "<tr >" + columnaincapacidad + "Incapacidades</td>";
     var rowTurnosCubiertodescansotrabajado12x12 = "<tr >" + columnadescansotrabajado12x12 + "Descanso Trabajado 12X12</td>";
     var rowTurnosCubiertobaja = "<tr >" + columnabaja + "Bajas</td>";
     var rowTurnosCubiertoingreso = "<tr >" + columnaingreso + "Ingresos</td>";
    var rowTurnosCubiertosincidenciavp2 = "<tr >" + columnavp2 + "Vacaciones Pagadas 24X24</td>";
    var rowTurnosCubiertosincidenciavacacionesdisfrutadas24x24 = "<tr>" + columnavacacionesdisfrutadas24x24 + "Vacaciones Disfrutadas 24X24</td>";
    var rowTurnosturnodedia = "<tr>" + columnaturnosdedia + "Turnos de día</td>";
    var rowTurnosturnodenoche = "<tr>" + columnaturnosdenoche + "Turnos de noche</td>";
    
  

    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
    var turnosPeriodo=0;
    //para la suma del total de totales
    var totaldetotalesdescansos=0;
    var totaldetotales12x12=0;
    var totaldetotales24x24=0;
    var totaldetotalesfaltas=0;
    var totaldetotalesvacacionespagadas=0;
    var totaldetotalesvacacionesdisfrutadas=0;
    var totaldetotalespermisos=0;
    var totaldetotalesincapacidades=0;
    var totaldetotalesdescansotrabajado12x12=0;
    var totaldetotalesbajas=0;
    var totaldetotalesingresos=0;
    var totaldetotalesvacacionespagadas24x24=0;
    var totaldetotalesvacacionesdisfrutadas24x24=0;
    var totaldetotalesturnosdedia=0;
    var totaldetotalesturnosnoche=0;
    //////////////////////////////////
    for (var i = 0; i < rangoFechas.length; i++)
    {      
        var fecha = formatDateYYYYMMDD (rangoFechas [i]);
    console.log("estoy contando incidencias");
   console.log(turnosPresupuestados);
        fechaAsistencia = fechasAsistencia [i];
        var cantidadTurnosdes=0;
       var cantidadTurnos12x12=0;
       var cantidadTurnos24x24=0;
       var cantidadTurnosfalta=0;
       var cantidadTurnostotalesvp=0;
       var cantidadTurnostotalesvd=0;
       var cantidadTurnospermisos=0;
       var cantidadTurnosincapacidad=0;
       var cantidadTurnosdt12=0;
       //var cantidadTurnosbaja=0;
       var cantidadTurnosingreso=0;
       var cantidadTurnostotalesvp2=0;
       var cantidadvacacionesdisfrutadas24x24=0;
       var cantidadTurnos24x24x=0;//variables extras
       var cantidadTurnostotalesvpx2=0;//variables extras
       var cantidadvacacionesdisfru24x24=0;//variables extras
       var turnosdedia=turnosPresupuestados [fecha].turnosdedia;
        turnosdedia=parseInt(turnosdedia); 
       var turnosdenoche=turnosPresupuestados [fecha].turnosdenoche;
       turnosdenoche=parseInt(turnosdenoche); 
        cantidadTurnosbaja=turnosPresupuestados [fecha].bajaspordia;
       cantidadTurnosbaja=parseInt(cantidadTurnosbaja); 
        ingresosPorDia=turnosPresupuestados [fecha].ingresospordia;
       ingresosPorDia=parseInt(ingresosPorDia); 
       faltasPorDia=turnosPresupuestados [fecha].faltaspordia;
       faltasPorDia=parseInt(faltasPorDia); 
      permisosPorDia=turnosPresupuestados [fecha].permisospordia;
       permisosPorDia=parseInt(permisosPorDia); 
       incapacidadesPorDia=turnosPresupuestados [fecha].incapacidadespordia;
       incapacidadesPorDia=parseInt(incapacidadesPorDia); 

       



        for(var j=0;j<turnosPresupuestados [fecha].incidencias.length;j++){
 //console.log( turnosPresupuestados [fecha].incidencias[j].nomenclaturaIncidencia);
 var neomenclaturaincidencia=turnosPresupuestados [fecha].incidencias[j].nomenclaturaIncidencia;
 var valorincidencia=turnosPresupuestados [fecha].incidencias[j].valorAsistencia;
 valorincidencia=parseInt(valorincidencia); 
 var cantidadTurnos=turnosPresupuestados [fecha].incidencias[j].cantidadTurnos; //cuando laincidencia vale por dos hacer la operacion siguiente->> cantidadTurnos/valorincidencia  para que solo sea la suma de las incidencias y no se vayan al doble
 cantidadTurnos=parseInt(cantidadTurnos); 
 //console.log( neomenclaturaincidencia);
 if(neomenclaturaincidencia=="DES"){
   cantidadTurnosdes=(cantidadTurnosdes+cantidadTurnos);  
 }
  if(neomenclaturaincidencia=="1" || neomenclaturaincidencia==1){//turno12x12
   //cantidadTurnos12x12=(cantidadTurnos12x12+valorincidencia);
   cantidadTurnos12x12=cantidadTurnos;
 }
 if(neomenclaturaincidencia=="2" || neomenclaturaincidencia==2){//turno24x24
   cantidadTurnos24x24x=(cantidadTurnos24x24x+cantidadTurnos);  
 }
/* if(neomenclaturaincidencia=="f" || neomenclaturaincidencia=="F"){
  valorincidencia=1;
   cantidadTurnosfalta=(cantidadTurnosfalta+valorincidencia);
   cantidadTurnospermisos=(cantidadTurnospermisos+valorincidencia);
 }
  if(neomenclaturaincidencia=="INC"){
 }*/
 if(neomenclaturaincidencia=="V/P"){
   cantidadTurnostotalesvp=(cantidadTurnostotalesvp+valorincidencia);
 }
 if(neomenclaturaincidencia=="V/D"){
   cantidadTurnostotalesvd=(cantidadTurnostotalesvd+valorincidencia);
 }
 /* if(neomenclaturaincidencia=="PER"){
   //valorincidencia=1; 
   cantidadTurnosincapacidad=(cantidadTurnosincapacidad+cantidadTurnos);
 }*/
 if(neomenclaturaincidencia=="DT12"){
  valorincidencia=valorincidencia;
   cantidadTurnosdt12=((cantidadTurnosdt12+cantidadTurnos)/valorincidencia);
 }
/* if(neomenclaturaincidencia=="b" || neomenclaturaincidencia=="B"){//turno24x24
  valorincidencia=1;
   cantidadTurnosbaja=(cantidadTurnosbaja+valorincidencia);  
 }
 */
/*  if(neomenclaturaincidencia=="ING" ){//turno24x24
  valorincidencia=1;
   cantidadTurnosingreso=(cantidadTurnosingreso+valorincidencia);   
 } */
  if(neomenclaturaincidencia=="V/P2"){
   cantidadTurnostotalesvpx2=(cantidadTurnostotalesvpx2+cantidadTurnos);
 }
 if(neomenclaturaincidencia=="V/D2" ){//turno24x24
   cantidadvacacionesdisfru24x24=(cantidadvacacionesdisfru24x24+valorincidencia);
 }
}
//para la suma del total de totales
 totaldetotalesdescansos=(totaldetotalesdescansos+cantidadTurnosdes);
 totaldetotales12x12=(totaldetotales12x12+cantidadTurnos12x12);
 totaldetotales24x24=(totaldetotales24x24+cantidadTurnos24x24x);
 totaldetotalesfaltas=(totaldetotalesfaltas+faltasPorDia);
 totaldetotalesvacacionespagadas=(totaldetotalesvacacionespagadas+cantidadTurnostotalesvp);
 totaldetotalesvacacionesdisfrutadas=(totaldetotalesvacacionesdisfrutadas+cantidadTurnostotalesvd);
 totaldetotalespermisos=(totaldetotalespermisos+permisosPorDia);
 totaldetotalesincapacidades=(totaldetotalesincapacidades+incapacidadesPorDia);
 totaldetotalesdescansotrabajado12x12=(totaldetotalesdescansotrabajado12x12+cantidadTurnosdt12);
 totaldetotalesingresos=(totaldetotalesingresos+ingresosPorDia);
 totaldetotalesvacacionespagadas24x24=(totaldetotalesvacacionespagadas24x24+cantidadTurnostotalesvpx2);
 totaldetotalesvacacionesdisfrutadas24x24=(totaldetotalesvacacionesdisfrutadas24x24+cantidadvacacionesdisfru24x24); 
totaldetotalesbajas=(totaldetotalesbajas+cantidadTurnosbaja);
totaldetotalesturnosdedia=(totaldetotalesturnosdedia+turnosdedia);
 totaldetotalesturnosnoche=(totaldetotalesturnosnoche+turnosdenoche);
 ///////////////////////////////////////
  rowTurnosCubiertosdescansos += "<td width='40px' >" + cantidadTurnosdes + "</td>";
  rowTurnosCubiertos12x12 += "<td width='40px' >" + cantidadTurnos12x12 + "</td>";
  rowTurnosCubiertos24x24 += "<td width='40px' >" + cantidadTurnos24x24x + "</td>";
   rowTurnosCubiertosfalta += "<td width='40px' >" + faltasPorDia + "</td>";
  rowTurnosCubiertosincidenciavp += "<td width='40px' >" + cantidadTurnostotalesvp + "</td>";
  rowTurnosCubiertosincidenciavd += "<td width='40px' >" + cantidadTurnostotalesvd + "</td>";
  rowTurnosCubiertospermisos += "<td width='40px' >" + permisosPorDia + "</td>";
  rowTurnosCubiertoincapacidad += "<td width='40px' >" + incapacidadesPorDia + "</td>";
  rowTurnosCubiertodescansotrabajado12x12 += "<td width='40px' >" + cantidadTurnosdt12 + "</td>";
  rowTurnosCubiertobaja += "<td width='40px' >" + cantidadTurnosbaja + "</td>";
  rowTurnosCubiertoingreso += "<td width='40px' >" + ingresosPorDia + "</td>";
  rowTurnosCubiertosincidenciavp2 += "<td width='40px' >" + cantidadTurnostotalesvpx2 + "</td>";
  rowTurnosCubiertosincidenciavacacionesdisfrutadas24x24 += "<td width='40px' >" + cantidadvacacionesdisfru24x24 + "</td>";
  rowTurnosturnodedia += "<td width='40px' >" + turnosdedia + "</td>";
  rowTurnosturnodenoche += "<td width='40px' >" + turnosdenoche + "</td>";

    }

      rowTurnosCubiertosdescansos +="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesdescansos + "</td>";//para la suma del total de totales
      rowTurnosCubiertos12x12 +="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotales12x12 + "</td>";//para la suma del total de totales
      rowTurnosCubiertos24x24+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotales24x24 + "</td>";//para la suma del total de totales
      rowTurnosCubiertosfalta+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesfaltas + "</td>";//para la suma del total de totales
      rowTurnosCubiertosincidenciavp+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesvacacionespagadas + "</td>";//para la suma del total de totales
      rowTurnosCubiertosincidenciavd+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesvacacionesdisfrutadas + "</td>";//para la suma del total de 
      rowTurnosCubiertospermisos+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalespermisos + "</td>";//para la suma del total de 
      rowTurnosCubiertoincapacidad+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesincapacidades + "</td>";//para la suma del total de 
      rowTurnosCubiertodescansotrabajado12x12+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesdescansotrabajado12x12 + "</td>";//para la suma del total de totales
      rowTurnosCubiertobaja+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesbajas + "</td>";//para la suma del total de totales
      rowTurnosCubiertoingreso+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesingresos + "</td>";//para la suma del total de totales
      rowTurnosCubiertosincidenciavp2+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesvacacionespagadas24x24 + "</td>";//para la suma del total de totales 
      rowTurnosCubiertosincidenciavacacionesdisfrutadas24x24+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesvacacionesdisfrutadas24x24 + "</td>";//para la suma del total de totales
      rowTurnosturnodedia+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesturnosdedia + "</td>";//para la suma del total de totales
      rowTurnosturnodenoche+="<td width='40px' >0</td>"+"<td width='40px' >0</td>"+"<td width='40px' >" + totaldetotalesturnosnoche + "</td>";//para la suma del total de totales
      result += rowTurnosCubiertosdescansos;
      result += rowTurnosCubiertos12x12;
      result += rowTurnosCubiertos24x24;
      result += rowTurnosCubiertosfalta;
      result += rowTurnosCubiertosincidenciavp;
      result += rowTurnosCubiertosincidenciavd;
      result += rowTurnosCubiertospermisos;
      result += rowTurnosCubiertoincapacidad;
      result += rowTurnosCubiertodescansotrabajado12x12;
      result += rowTurnosCubiertobaja;
      result += rowTurnosCubiertoingreso;
      result += rowTurnosCubiertosincidenciavp2;
      result += rowTurnosCubiertosincidenciavacacionesdisfrutadas24x24;
      result += rowTurnosturnodedia;
      result += rowTurnosturnodenoche;
       return result;
  }
     function crearResumenDeTurnosFatigaconteo (turnosACobrar,totalFestivos,opcion)
  {
    // Variables globales
    // turnosPresupuestados
    // fechasAsistencia
    // turnosCubiertos
    //alert(turnosACobrar);
    var valorCobraDescanso=$("#txtCobraDescansoFatigaconteo").val();
    var valorCobraDiaFestivo=$("#txtCobraDiaFestivoconteo").val();

    var rangoFecha1=$("#txtFechaFatiga1conteo").val();
    var rangoFecha2=$("#txtFechaFatiga2conteo").val();

    var result = "";
    if(opcion==1)
        var primerColumna = "<td width='747px' align='right' colspan='8'>";
    else
        var primerColumna = "<td width='747px' align='right' colspan='9'>";

    //var rowTurnosPresupuestados = "<tr>" + primerColumna + "Turnos Presupuestados</td>";
    var rowTurnosCubiertos = "<tr >" + primerColumna + "Total</td>";
    //var rowDiferenciaTurnos = "<tr>" + primerColumna + "Diferencia</td>";
 // console.log ("turnosPresupuestados en conteo");
   // console.log (turnosconteoincidencias);

    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
    var turnosPeriodo=0;

    for (var i = 0; i < rangoFechas.length; i++)
    {
        
        var fecha = formatDateYYYYMMDD (rangoFechas [i]);
    
     console.log(fecha);
        

        fechaAsistencia = fechasAsistencia [i];

        //turnoCubierto = turnosPresupuestados [fecha].turnosCubiertos;
    
    if (turnosconteoincidencias[fecha] != null)
        {
            turnoCubierto = turnosconteoincidencias [fecha].turnosCubiertos;
        }
        else
        {
            turnoCubierto = "NO DEFINIDO";
        }

        rowTurnosCubiertos += "<td width='40px' >" + turnoCubierto + "</td>";

        turnosPeriodo=parseInt(turnosPeriodo)+parseInt(turnoCubierto);

    }

    //rowTurnosPresupuestados += "</tr>";



      rowTurnosCubiertos += "<td>"+turnosACobrar+"</td>";
      rowTurnosCubiertos += "<td>"+totalFestivos+"</td>";

      var totalEx=0;
      if(valorCobraDiaFestivo==0){
        var totalEx=turnosACobrar+turnosExtra;
        rowTurnosCubiertos += "<td>"+turnosACobrar+"</td><td>"+totalEx+"</td>";


      }else{

        var total=parseInt(turnosACobrar) + parseInt(totalFestivos);
         var totalEx=total+turnosExtra;        
        rowTurnosCubiertos += "<td>"+total+"</td><td>"+totalEx+"</td></tr>";
      }
  
    
    result += rowTurnosCubiertos;
    //result += rowTurnosPresupuestados;
    //result += rowDiferenciaTurnos;


    return result;
  }

  function getPuntosServiciosBySupervisorFatigaconteo()
    {
      
      var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" || $usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"):
      ?>
      supervisorId=$("#selectSupervisorFatigaconteo").val();
      <?php
      endif;
      ?>

       $.ajax({
            type: "POST",
            url: "ajax_getPuntosForFatigaBySupervisor.php",
            data: {"supervisorId":supervisorId, rangoFecha1:rangoFecha1, rangoFecha2:rangoFecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;
                    
                    puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";

                    //$("#selectPuntoServicioFatiga2").empty ();
                    
                    for (var i = 0; i < puntos.length; i++)
                    {

                      var valorCobraDescanso=puntos[i].cobraDescansos;
                      var valorCobraDiaFestivo=puntos[i].cobraDiaFestivo;
                      var valorCobra31=puntos[i].cobra31;
                      var idCliente=puntos[i].idClientePunto;
                      var razonSocial=puntos[i].razonSocial;
                      //alert(razonSocial);
                        
                        puntosOptions += "<option id='op_spsf"+puntos[i].puntoServicioId+"' name='op_spsf"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31conteo='"+valorCobra31+"' idCliente='"+idCliente+"' razonSocial='"+razonSocial+"'>" + puntos[i].puntoServicio + "</option>";
                        
                        //var option = "<option id='op_spsf"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntos[i].puntoServicio + "</option>";
                    
                        //$("#selectPuntoServicioFatiga2").append (option);
                        //$('.selectpicker').selectpicker('refresh');
                        
                    }
                    puntosOptions+="<option>TODOS</option>";
                    //if($("#selectSupervisorFatiga").val() != "todosSup"){
                    $("#selectEntidadFatigaconteo").prop('selectedIndex', 0);
                    //}
                    $("#selectPuntoServicioFatigaconteo").html (puntosOptions);
                    <?php
                    if($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"):
                    ?>
                    $("#selectEntidadFatigaconteo").prop('selectedIndex', -1);
                    $("#selectPuntoServicioFatigaconteo").html (puntosOptions);
                    <?php
                    endif;
                    ?>



                    
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                 // alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }

     function obtenerPuntosServiciosPorEntidadFatigaconteo()
    {
       
       //var mitexto = $("#tipoPuesto option:selected").text();
       var idEntidad  = $("#selectEntidadFatigaconteo").val();
       var fecha1=$("#txtFechaFatiga1conteo").val();
       var fecha2=$("#txtFechaFatiga2conteo").val();
           
       $.ajax({
            type: "POST",
            url: "ajax_getPuntosForFatigaByEntidad.php",
            data: {"idEntidad": idEntidad, fecha1:fecha1, fecha2:fecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntosServicios = response.puntoServicio;
                    
                    var puntosServiciosOptions = "<option>PUNTOS SERVICIOS</option>";
                    for (var i = 0; i < puntosServicios.length; i++)
                    {
                        
                      valorCobraDescanso=puntosServicios[i].cobraDescansos;
                      valorCobraDiaFestivo=puntosServicios[i].cobraDiaFestivo;
                      valorCobra31=puntosServicios[i].cobra31;
                      idCliente=puntosServicios[i].idClientePunto;
                        //puntosServiciosOptions += "<option value='" + puntosServicios[i].idPuntoServicio + "'>" + puntosServicios[i].puntoServicio + "</option>";
                        puntosServiciosOptions += "<option id='op_spsf"+puntosServicios[i].idPuntoServicio+"' value='" + puntosServicios[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31conteo='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntosServicios[i].puntoServicio + "</option>";
                    }

                    //alert(puntosServiciosOptions);
                    puntosServiciosOptions+="<option>TODOS</option>";
                    $("#selectSupervisorFatigaconteo").prop('selectedIndex', 0);
                    $("#selectPuntoServicioFatigaconteo").html (puntosServiciosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                //  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }



  function generadorFormatoFatigaconteo()
    {
      var idPuntoServicio=$("#selectPuntoServicioFatigaconteo").val();
      var idSupervisor=$("#selectSupervisorFatigaconteo").val();
      var fecha1=$("#txtFechaFatiga1conteo").val();
      var fecha2=$("#txtFechaFatiga2conteo").val();
      var entidadId=$("#selectEntidadFatigaconteo").val();
      

      if(idPuntoServicio=="PUNTOS DE SERVICIOS" || idPuntoServicio==""){
        
        alert("Seleccione punto de servicio");
        
      }else if(fecha1=="" || fecha2==""){
        
        alert("Seleccione rango de fecha");

      }else if(idPuntoServicio=="PUNTOS SERVICIOS" && idSupervisor=="SUPERVISOR" && entidadId!="ENTIDAD FEDERATIVA"){

        alert("Seleccione un punto de servicio o todos los puntos de servicios");

      }else if(idPuntoServicio=="TODOS"){

        window.open("generadorFatiga.php?idPuntoServicio="+idPuntoServicio+"&fecha1="+fecha1+"&fecha2="+fecha2+"&idSupervisor="+idSupervisor+"&entidadId="+entidadId+"" ,'_blank','fullscreen=no');

      }else{

        window.open("generadorFatiga.php?idPuntoServicio="+idPuntoServicio+"&fecha1="+fecha1+"&fecha2="+fecha2+"&idSupervisor="+idSupervisor+"&entidadId="+entidadId+"" ,'_blank','fullscreen=no');
      }
     
      //parent.opener=top;
      //opener.close();
    }


    function getPuntosServiciosForFatigaByAnalistaconteo()
    {

            
      var fecha1=$("#txtFechaFatiga1conteo").val();
      var fecha2=$("#txtFechaFatiga2conteo").val();    

       $.ajax({
            type: "POST",
            url: "ajax_getPuntosForFatigaByAnalista.php",
            data: {"fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
              console.log(response);
                if (response.status == "success")
                {
                    var puntos = response.puntos;

                    var puntosOptions = "<option>PUNTOS DE SERVICIOS</option>";
                                        
                    for (var i = 0; i < puntos.length; i++)
                    {

                      valorCobraDescanso=puntos[i].cobraDescansos;
                      valorCobraDiaFestivo=puntos[i].cobraDiaFestivo;
                      valorCobra31=puntos[i].cobra31;
                      idCliente=puntos[i].idClientePunto;
                      
                        puntosOptions += "<option id='op_spsf"+puntos[i].idPuntoServicio+"' value='" + puntos[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31conteo='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntos[i].puntoServicio + "</option>";
                        
                    }

                     <?php
                    if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" || $usuario["rol"] =="Analista Asistencia" ){                       
                    ?>
                    puntosOptions+="<option>TODOS</option>";
                    puntosTotales=puntos;
                    $("#selectPuntoServicioFatigaconteo").html(puntosOptions);
                    
                    <?php
                    }
                    ?>

                  
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }


    function validacionEnvioFatigaconteo(){

      //alert("hola");
      $("#modal_confirmacionEnvioFatiga").modal();

      var fecha1=$("#txtFechaFatiga1conteo").val();
      var fecha2=$("#txtFechaFatiga2conteo").val();  
      var puntoServicio=$("#selectPuntoServicioFatigaconteo").val();

      var dia1=fecha1.substring(8);
      var dia2=fecha2.substring(8);
      
      var mes1=fecha1.substring(5,7);
      var mes2=fecha2.substring(5,7);

      
      if(fecha1!="" && fecha2!="" && puntoServicio!="" && puntoServicio!="PUNTOS DE SERVICIOS"  ){
        //alert(mes1+"*"+ mes2);

        if( (dia1=="01" &&dia2=="15") || (dia1=="16" &&dia2=="30") || (dia1=="16" &&dia2=="31") || (dia1=="16" &&dia2=="28") || (dia1=="16" &&dia2=="31")){

          if(mes1!=mes2){
            
            var mensaje="<h3><p>Verifique la fecha de consulta para envío de fatiga (seleccione periodos quincenales)<p></h3>";
            var mensajeTitulo="<img src='img/rechazarImss.png'>";
            var botones="<button type='button' data-dismiss='modal' class='btn'>Cerrar</button>";

            $("#dv_mensaje").html(mensaje);
            $("#dv_tituloMensaje").html(mensajeTitulo);
            $("#dv_botones").html(botones);

          }else{

            var mensaje="<h3><p>La fatiga sera envida para proceso de facturación ¿Desea continuar con el envío?<p></h3>";
            var mensajeTitulo="<img src='img/alert.png'>";
            var botones="<button type='button' data-dismiss='modal' class='btn'>Cancelar envio</button><button type='button' class='btn btn-primary' onclick='sendFatiga();'>Enviar</button>";

            $("#dv_mensaje").html(mensaje);
            $("#dv_tituloMensaje").html(mensajeTitulo);
            $("#dv_botones").html(botones);

          }
                  

        }else{

        var mensaje="<h3><p>Verifique la fecha de consulta para envío de fatiga (seleccione periodos quincenales)<p></h3>";
        var mensajeTitulo="<img src='img/rechazarImss.png'>";
        var botones="<button type='button' data-dismiss='modal' class='btn'>Cerrar</button>";

        $("#dv_mensaje").html(mensaje);
        $("#dv_tituloMensaje").html(mensajeTitulo);
        $("#dv_botones").html(botones);
        }

           
      }else{

        var mensaje="<h3><p>Proporcione datos para generación de fatiga<p></h3>";
        var mensajeTitulo="<img src='img/rechazarImss.png'>";
        var botones="<button type='button' data-dismiss='modal' class='btn'>Cerrar</button>";

        $("#dv_mensaje").html(mensaje);
        $("#dv_tituloMensaje").html(mensajeTitulo);
        $("#dv_botones").html(botones);

        
      }



    }



     $("#descargarFatigaconteo").click(function(event) {
     $("#datos_fatigaconteo").val( $("<div>").append( $("#divFatigaconteo").eq(0).clone()).html());
     $("#form_consultaFatigaconteo").submit();
      });


  /* $("#descargarTodas").click(function(event) {
   $("#datos_fatiga").val( $("<div>").append( $("#divFatiga").eq(0).clone()).html());
   $("#form_consultaFatiga").submit();
   });*/

  $('#txtFechaFatiga1conteo').datetimepicker({   
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#txtFechaFatiga2conteo').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

  function cargarPuntosServiciosconteo(){


      $("#selectSupervisorFatigaconteo").val("SUPERVISOR");
      $("#selectEntidadFatigaconteo").val("ENTIDAD FEDERATIVA");

      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion" || $usuario["rol"] =="Analista Asistencia"){
      ?>

      getPuntosServiciosForFatigaByAnalistaconteo();
                    
      <?php
      }elseif($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){
      ?>

      getPuntosServiciosBySupervisorFatigaconteo();

      <?php
      }
      ?>
   

  }


  function sendFatiga ()
    {

      waitingDialog.show();

      var fecha1=$("#txtFechaFatiga1conteo").val();
      var fecha2=$("#txtFechaFatiga2conteo").val();  
      var puntoServicio=$("#selectPuntoServicioFatigaconteo").val();

      var fecha1=$("#txtFechaFatiga1conteo").val();
      var fecha2=$("#txtFechaFatiga2conteo").val();  
      var puntoServicio=$("#selectPuntoServicioFatigaconteo").val();
      var namePuntoServicio=$("#selectPuntoServicioFatigaconteo option:selected").text();
      var quincenaFatigaId="";

      var razonSocial=$("#op_spsf"+puntoServicio).attr("razonSocial");

            
      var dia1=fecha1.substring(8);
      var dia2=fecha2.substring(8);

      if(dia1=="01" && dia2=="15"){
        quincenaFatigaId=1;

      }else{
        quincenaFatigaId=2;
      }

        $.ajax({
            type: "POST",
            url: "sendFatiga.php",
            data: {fecha1:fecha1, fecha2:fecha2, puntoServicio:puntoServicio, quincenaFatigaId:quincenaFatigaId, namePuntoServicio:namePuntoServicio, razonSocial:razonSocial},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
                  $('#modal_confirmacionEnvioFatiga').modal('hide');
                  waitingDialog.hide();
                  alert("La fatiga fue enviada para proceso de facturación");
                            
                } else if (response.status=="error")
                {
                  $('#modal_confirmacionEnvioFatiga').modal('hide');
                  waitingDialog.hide();
                  alert(response.message);
                }
              },
            error: function(jqXHR, textStatus, errorThrown){
               waitingDialog.hide();
                 // alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }


  $("#descargarTodasconteo").click(function(event){  
  reporteconteotodos(1);   

     
    });
function reporteconteotodos(opcion){


 var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();
      var idcliente="";
      if(opcion==2){
        idcliente=$("#selectClienteConteo").val();
      }
      
      if(rangoFecha1 != "" && rangoFecha2!= ""){     
        waitingDialog.show('Cargando Archivo..');
        var listaClientes=null;        
        $.ajax({
              async: false,
              type: "POST",
              url: "ajax_obtenerListaClientesConteo.php",
              data:{"opcion":opcion,"idcliente":idcliente},
              
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {                      
                      listaClientes = response.listaClientes;   

                      
                  }
                  else if (response.status == "error")
                  {
                      //window.location = "login.php";
                      alert("error inesperado");
                  }
              },
             error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
          });
          var listaEntidades=obtenerEntidadesFederativasconteo();
          var listaSupervisoresOperativos=obtenerSupervisoresOperativosconteo();
          var idCliente="";
          var razonSocial="";
          var supervisorId="";
          var puntos=null;
          var puntoServicioId="";
          var idEntidad="";
          var nombreEntidad="";
          var listaPuntosEntidadCliente=null;
          var generaTabla=true;
          var nombreSupersor="";
         // console.log("supervisores");
          //console.log(listaSupervisoresOperativos);
         //%%
          //alert("Clientes: "+listaClientes.length+" Entidades: "+listaEntidades.length);          
          for ( var i = 0; i < listaClientes.length; i++ ){            
              idClientePunto = listaClientes[i].idCliente;
              razonSocial = listaClientes[i].razonSocial;
              for ( var j = 0; j < listaEntidades.length; j++ ){
                  idEntidad=listaEntidades[j].idEntidadFederativa;                  
                  nombreEntidad=listaEntidades[j].nombreEntidadFederativa;
                  //alert("cliente:  "+idClientePunto+" Entidad: "+idEntidad);               
                  listaPuntosEntidadCliente=encontrarPuntoClienteEntidadconteo(idClientePunto,idEntidad,rangoFecha1,rangoFecha2);
                  //alert(listaPuntosEntidadCliente.length);               
                 if(listaPuntosEntidadCliente.length >0 ){

                    /*   if(idClientePunto==13){                        
                          for(var m = 0; m < listaPuntosEntidadCliente.length; m++){                          
                              getEmpleadosFatigaTotalesconteo(listaPuntosEntidadCliente[m],razonSocial,nombreEntidad,"CORPORATIVO",generaTabla,supervisorId);                                  
                              generaTabla=false;
                          }

                      }else{*/
                                
                          for ( var k = 0; k < listaSupervisoresOperativos.length; k++ ){                    
                              supervisorId=listaSupervisoresOperativos[k].supervisorId;
                              nombreSupersor=listaSupervisoresOperativos[k].nombre;
                              puntos=getPuntosServiciosBySupervisorTotalconteo(supervisorId);                                                
                              for ( var l = 0; l < puntos.length; l++ ){                            
                                  
                                  puntoServicioId=puntos[l].puntoServicioId;
                                  
                                  if(encontrarPuntoconteo(listaPuntosEntidadCliente,puntoServicioId)){  
                                      //alert(razonSocial+" "+nombreEntidad+" "+nombreSupersor);
                                    getEmpleadosFatigaTotalesconteo(puntos[l],razonSocial,nombreEntidad,nombreSupersor,generaTabla,supervisorId); 
                                      turnosExtra=0;                                 
                                      generaTabla=false;
                                  }
                              }
                          }
                      //}
                  }

              }


          }    
                        
        waitingDialog.hide();

        tooltipAjax2();
       $("#datos_fatigaconteo").val( $("<div>").append( $("#divFatigaconteo").eq(0).clone()).html());
        $("#form_consultaFatigaconteo").submit();
        location.reload();
        }else{alert("SELECCIONE RANGO DE FECHAS"); $("#selectClienteConteo").val(0);  $("#mostraropcionebyclinete").hide();}

}
   function obtenerEntidadesFederativasconteo(){
      var listaEntidades=null;
      $.ajax({
              async: false,
              type: "POST",
              url: "ajax_getEntidadesFederativas.php",
              
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {                      
                      listaEntidades = response.listaEntidades;   

                      
                  }
                  else if (response.status == "error")
                  {
                      //window.location = "login.php";
                      alert("error inesperado");
                  }
              },
              error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
          });

      return listaEntidades;
   }

   function obtenerSupervisoresOperativosconteo(){

      $.ajax({
              async: false,
              type: "POST",
              url: "ajax_obtenerListaSupervisoresOperativosXNoEmp.php",
              
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {                      
                      listaSupervisores = response.listaSupervisoresOperativos;   

                      
                  }
                  else if (response.status == "error")
                  {
                      //window.location = "login.php";
                      alert("error inesperado");
                  }
              },
              error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
          });

      return listaSupervisores;
   }

   function getPuntosServiciosBySupervisorTotalconteo(supervisorId)
    {
      
      var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();
      var puntosZ=null;
       $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getPuntosForFatigaBySupervisor.php",
            data: {"supervisorId":supervisorId, "rangoFecha1":rangoFecha1, "rangoFecha2":rangoFecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    puntosZ = response.puntos;
                    //alert(puntosZ[0].cobraDescansos);                  

                  //$("#selectPuntoServicioFatiga2").empty ();                                     
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              
                 // alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
       return puntosZ;
    }

    function getEmpleadosFatigaTotalesconteo(punto,idClientePunto,idEntidad,supervisorId,generarTabla,numeroempleadosupervisor)
    {      
      if(generarTabla){
          
          generarTablaRangoFechaFatigaconteo(2);
          //alert("se genero");
      }            
      //alert(idClientePunto);          
      var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();          
      
      var valorCobraDescanso=punto.cobraDescansos;
      var valorCobraDiaFestivo=punto.cobraDiaFestivo;
      var valorCobra31=punto.cobra31;      

      $("#txtCobraDescansoFatigaconteo").val(valorCobraDescanso);
      $("#txtCobraDiaFestivoconteo").val(valorCobraDiaFestivo);
      $("#txtCobra31conteo").val(valorCobra31);

      var puntoServicio=punto.puntoServicioId;    
      
      elementosSolicitadosFatigaconteo(puntoServicio);
      getTurnosExtrasFatigaconteo(puntoServicio);      

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getEmpleadosFatiga.php",
            data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "puntoServicio":puntoServicio,},//"numeroempleadosupervisor":numeroempleadosupervisor},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var empleadoEncontrado = response.listaEmpleados;
                    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
                    var turnosACobrar=0;
                    var totalFestivos=0;

                                     
                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){

                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
                      var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
                      var asistencia = empleadoEncontrado[i].asistencia;
                      var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;

                       var roloperativo=empleadoEncontrado[i].roloperativo;
                       var nombresupervisordeasistencia=empleadoEncontrado[i].nombresupervisor; 


                      var dateTable="<tr><td width='160px'>"+idClientePunto+"</td><td width='160px'>"+punto.puntoServicio+"</td><td width='800px'>"+idEntidad+"</td>";
                      dateTable+="<td width='160px'>"+nombresupervisordeasistencia+"</td>"; ///%%//se cambio esta variable para ver si cambia el nombre de supervisor originalmente venia esta variable supervisorId
                    dateTable+="<td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td>";

                    dateTable+="<td width='80px'>"+roloperativo+"</td>";

                    //&
                    dateTable += generarCeldasFatigaTotalconteo(rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,puntoServicio);
                    dateTable += "</tr>";  

                    $('#tableConsultaFatigaconteo').append(dateTable);

                    var turnos= $("#td_tqc_c"+numeroEmpleado+"_"+puntoServicio).attr("sumaTurnosPeriodo");                    
                    turnosACobrar=parseInt(turnosACobrar) + parseInt(turnos);

                    totalFestivos=parseInt(totalFestivos)+parseInt(sumaDiasFestivos);

                    

                    //var diasFestivos= $("#td_tdff_"+numeroEmpleado).attr("sumaDiasFestivos");
                    //totalFestivos=parseInt(turnosFestivos) + parseInt(diasFestivos);
                    //alert(totalFestivos);
 
                    }
                   // alert(turnosACobrar);
                  //if(puntoServicio == 1141)
                    //    alert("TURNOS COBRAR: " + turnosACobrar);
                   obtenerTurnosCubiertosTotalconteo(puntoServicio,turnosACobrar,totalFestivos);
                    //elementosSolicitadosFatiga();
                    
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }else if(response.status=="error"){

                  alert("Eerror");
                  waitingDialog.hide();  


                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });

    }
  

    function encontrarPuntoClienteEntidadconteo(idCliente,idEntidad,fecha1,fecha2){        
        var puntosE=null;        
        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getPuntosByClienteEntidad.php",
            data: {"idCliente":idCliente, "idEntidad":idEntidad, "fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {                    
                    puntosE = response.puntos;                    

                  //$("#selectPuntoServicioFatiga2").empty ();                                     
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              
                //  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
        return puntosE;
    }


    function encontrarPuntoconteo(listaPuntos,idPuntoServicio){
        for(var i=0; i<listaPuntos.length ; i++){
            if(listaPuntos[i].puntoServicioId == idPuntoServicio ){
                return true;
            }
        }

        return false;
    }


    function obtenerTurnosCubiertosTotalconteo(idPuntoServicio,turnosACobrar, totalFestivos){

     
      
      var rangoFecha1=$("#txtFechaFatiga1conteo").val();
      var rangoFecha2=$("#txtFechaFatiga2conteo").val();
    
       $.ajax({
            
            type: "POST",
            url: "ajax_generarResumenAsistenciaConteo.php",
            data: {"puntoServicioId": idPuntoServicio
                , "fechaInicial": rangoFecha1
                , "fechaFinal": rangoFecha2 },
            dataType: "json",
            async:false,
            success: function(response) {
              //console.log(response);
                if (response.status == "success")
                {
                     
                    turnosPresupuestados = response.result;
                    //if(idPuntoServicio == 1141)
                      //  alert("TURNOS COBRAR: " + turnosACobrar);
                    var resumen = crearResumenDeTurnosFatigaconteo (turnosACobrar,totalFestivos,2);
                    $('#tableConsultaFatigaconteo tr:last').after(resumen);
                     var totalincidencias=conteodeincidenciaspordia(turnosACobrar,totalFestivos,2);
                     $('#tableConsultaFatigaconteo tr:last').after(totalincidencias);

                   
                }else{
                  alert("error en turnos total suces");
                }
            },           

            error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
    }
    function generarCeldasFatigaTotalconteo (rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,puntoServicioId)
    {
          var result = "";
          var sumaTurnosPeriodo=0;
          console.log(asistencia);
          var descansos=0;
          var totalFestivos=0;
          var sumaTurnosDia31=0;

          var valorCobraDescanso=$("#txtCobraDescansoFatigaconteo").val();
          var valorCobraDiaFestivo=$("#txtCobraDiaFestivoconteo").val();
          var valorCobra31=$("#txtCobra31conteo").val();

          for (var i = 0; i < rangoFechas.length; i++)
          {
              var fecha = formatDateYYYYMMDD (rangoFechas [i]);
              var asistenciaText = "&nbsp;";
              //alert(fecha);

              if (asistencia [fecha] != null)
              {
                  asistenciaText = asistencia[fecha]["nomenclaturaIncidencia"];
                  //valorAsistencia=asistencia [fecha]["valorAsistencia"];
 
                  valorFatiga=asistencia[fecha]["valorCobertura"];

                  

                    if(asistenciaText=="DES"){

                      if(valorCobraDescanso==1){
                        valorFatiga=1;
                      }

                    }

                var dia=fecha.substring(8);

                sumaTurnosPeriodo = parseInt(sumaTurnosPeriodo) + parseInt(valorFatiga);   
                //alert(sumaTurnosPeriodo+"turnos al dia "+ dia); 

                if(dia==31){

                  sumaTurnosDia31=parseInt(sumaTurnosDia31)+parseInt(valorFatiga);
                         
                }

                  if(valorFatiga== null)
                  {
                   valorFatiga=0;
                  }
             
          
              }

              var style = stylesFatiga [asistenciaText];

              if(asistenciaText=="ING"){
                asistenciaText="ING";
              }else if(asistenciaText=="F"){
                asistenciaText="F";
              }else if(asistenciaText=="PER"){
                asistenciaText="PER";
              }else if(asistenciaText=="V/P"){
                asistenciaText="V/P";
              }else if(asistenciaText=="V/D"){
                asistenciaText="V/D";
              }else if(asistenciaText=="INC"){
                asistenciaText="INC";
              }else if(asistenciaText=="B"){
                asistenciaText="B";
              }else if(asistenciaText=="DT12"){
                asistenciaText="DT12";
              }
              else if(asistenciaText=="V/P2"){
                asistenciaText="V/P2";
              }else if(asistenciaText=="V/D2"){
                asistenciaText="V/D2";
              }
              
              result += "<td style='" + style + "'>" + asistenciaText +"</td>";

            
          }

          //if(valorCobraDescanso==1){

            //sumaTurnosPeriodo= parseInt(sumaTurnosPeriodo) + parseInt(descansos);

          //}

          if(valorCobra31==0){

            sumaTurnosPeriodo= parseInt(sumaTurnosPeriodo) - parseInt(sumaTurnosDia31);

          }

          if(valorCobraDiaFestivo==1){

            totalTurnos=parseInt(sumaTurnosPeriodo) + parseInt(sumaDiasFestivos);

          }else{
            totalTurnos=sumaTurnosPeriodo;
          }

          result +="<td width='20px' id='td_tqc_c"+numeroEmpleado+"_"+puntoServicioId+"' name='td_tqc_c"+numeroEmpleado+"_"+puntoServicioId+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"' descansos='"+descansos+"'>"+sumaTurnosPeriodo+"</td>";
          result +="<td width='20px' id='td_tdff_c"+numeroEmpleado+"' name='td_tdff_c"+numeroEmpleado+"' sumaDiasFestivos='"+ sumaDiasFestivos +"' >"+sumaDiasFestivos+"</td>";
          result +="<td width='20px' id='td_tqt_c"+numeroEmpleado+"' name='td_tqt_c"+numeroEmpleado+"' totalTurnos='"+totalTurnos+"'>"+totalTurnos+"</td>";

          return result;
     }


     function obtenerTurnoAsistenciaconteo(fechaAsistencia,numeroEmpleado,puntoServicio){
        var turno=0;
        $.ajax({
            
            type: "POST",
            url: "ajax_consultaTurnoAsistenciaByFecha.php",
            data: {"fechaAsistencia": fechaAsistencia
                , "numeroEmpleado": numeroEmpleado, "puntoServicio": puntoServicio},
            dataType: "json",
            async:false,
            success: function(response) {
                if (response.status == "success")
                {
                     
                    turno = response.turno;
                    //if(idPuntoServicio == 1141)
                      //  alert("TURNOS COBRAR: " + turnosACobrar);
                                                            
                }
            },           
error: function(jqXHR, textStatus, errorThrown){
              
                  //alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });

        return turno;

     }
     $("#selectClienteConteo").change(function(){
     // onchange="reporteconteotodos(2); "
     if($("#selectClienteConteo").val()!=0){
      $("#mostraropcionebyclinete").show();
     }else{
      $("#mostraropcionebyclinete").hide();
     }

     });

function totalTotalesByCLiente(){
 
var rangoFecha1=$("#txtFechaFatiga1conteo").val();
  var rangoFecha2=$("#txtFechaFatiga2conteo").val();
  var idcliente=$("#selectClienteConteo").val();
  var razonsocialcliebte =$('select[id="selectClienteConteo"] option:selected').text();
  if(rangoFecha1=="" || rangoFecha2==""){
    alert("Proporcione Rango de Fecha correcto");

  }else{
     
              //generar encabezado con lista de dias de periodo de consulta
              var table="<table class='table table-bordered table-striped'  border='3px' id='tableConsultaFatigaconteo' name='tableConsultaFatigaconteo'><thead><tr>";
               //table +="<tr width='160px' colspan='100'><th width='160px' colspan='100'>"+razonsocialcliebte+"</th></tr>";
              table +="<th width='60px'>"+razonsocialcliebte+"</th>";
          
          
       table += generarColumnasRangoFechas(rangoFecha1, rangoFecha2);//esta funcion se encuentra en el formulariode consulta asistencia

        table +="<th width='60px'>"+"Total"+"</th>";

        table +="</thead><tbody></tbody></table>";
        $('#divTableConsultaFatigaconteo').html(table);



var rowTurnosCubiertosdescansos= "<tr><td width='747px' align='right' colspan='1'> Descansos</td>";
var rowTurnosCubiertos12X12= " <tr><td width='747px' align='right' colspan='1'>Turnos 12X12</td>";
var rowTurnosCubiertos24X24= " <tr><td width='747px' align='right' colspan='1'>Turnos 24X24</td>";
var rowFaltas= " <tr><td width='747px' align='right' colspan='1'>Faltas</td>";
var rowVacacionesPagadas= " <tr><td width='747px' align='right' colspan='1'>Vacaciones Pagadas</td>";
var rowVacacionesDisfrutadas= " <tr><td width='747px' align='right' colspan='1'>Vacaciones Disfrutadas</td>";
var rowPermisos= " <tr><td width='747px' align='right' colspan='1'>Permisos</td>";
var rowIncapacidad= " <tr><td width='747px' align='right' colspan='1'>Incapacidades</td>";
var rowDescansoTrabajado12X12= " <tr><td width='747px' align='right' colspan='1'>Descanso Trabajado 12X12</td>";
var rowBajas= " <tr><td width='747px' align='right' colspan='1'>Bajas</td>";
var rowIngresos= " <tr><td width='747px' align='right' colspan='1'>Ingresos</td>";
var rowVacacionesPagadas24X24= " <tr><td width='747px' align='right' colspan='1'>Vacaciones Pagadas 24X24</td>";
var rowVacacionesDisfrutadas24X24=" <tr><td width='747px' align='right' colspan='1'>Vacaciones Disfrutadas 24X24</td>";

var rowTurnostotalesDia=" <tr><td width='747px' align='right' colspan='1'>Turnos de dia</td>";
var rowTurnostotalesNoche=" <tr><td width='747px' align='right' colspan='1'>Turnos de noche</td>";


 var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
waitingDialog.show();


var totaldescansos=0;
var totalturnos12x12=0;
var totalturnos24x24=0;
var totalTotalesfaltas=0;
var totalvacacionespagadas=0;
var totalvacacionesdisfrutadas=0;
var totalpermisos=0;
var totalincapacidades=0;
var totaldescansostrabajados12x12=0;
var totalbajas=0;
var totalingresos=0;
var totalvacacionespagadas24x24=0;
var totalvacacionesdisfrutadas24x24=0;
var turnostotalesdia=0;
var turnostotalesnoche=0;
for(var i=0;i<rangoFechas.length;i++){
                           var fecha = formatDateYYYYMMDD (rangoFechas [i]);
                             //console.log(fecha);
                        var descansos=0;
                        var turnos12x12=0;
                        var turnos24X24=0;
                        var totalfaltas=0;
                        var vacacionespagadas=0;
                        var vacacionesdisfrutadas=0;
                        var permisos=0;
                        var incapacidad=0;
                        var descansotrabajado12X12=0;
                        var bajas=0;
                        var ingresos=0;
                        var vacacionespagadas24X24=0;
                        var vacacionesdisfrutadas24X24=0;
                        var incidenciasbycliente=traerincidenciastotalesbyclientedia(fecha,idcliente);
                          for(var j=0;j<incidenciasbycliente.length;j++){
                            var neomenclaturaincidencia= incidenciasbycliente[j].nomenclaturaIncidencia
                            var valorasistencia=incidenciasbycliente[j].valorAsistencia;
                             valorasistencia=parseInt(valorasistencia);
                             var conteoprimerdiabaja=incidenciasbycliente[j].conteoPrimerDiaBaja; 
                             conteoprimerdiabaja=parseInt(conteoprimerdiabaja);
                        if(neomenclaturaincidencia=="DES"){
                          descansos=(descansos+valorasistencia);

                        }

                        if(neomenclaturaincidencia=="1" || neomenclaturaincidencia==1){
                          turnos12x12=(turnos12x12+valorasistencia);

                        }
                        if(neomenclaturaincidencia=="2" || neomenclaturaincidencia==2){
                          turnos24X24=(turnos24X24+valorasistencia);

                        }

                        if(neomenclaturaincidencia=="f" || neomenclaturaincidencia=="F"){
                          valorasistencia=1;
                          totalfaltas=(totalfaltas+valorasistencia);

                        }
                        if(neomenclaturaincidencia=="V/P" ){
                          vacacionespagadas=(vacacionespagadas+valorasistencia);

                        }
                        if(neomenclaturaincidencia=="V/D" ){
                          vacacionesdisfrutadas=(vacacionesdisfrutadas+valorasistencia);

                        }
                        if(neomenclaturaincidencia=="PER" ){
                          valorasistencia=1;
                          permisos=(permisos+valorasistencia);

                        }

                        if(neomenclaturaincidencia=="INC" ){
                          valorasistencia=1;
                          incapacidad=(incapacidad+valorasistencia);

                        }



                        if(neomenclaturaincidencia=="DT12" ){
                          valorasistencia=1;
                          descansotrabajado12X12=(descansotrabajado12X12+valorasistencia);

                        }


                        // falta incapacidades
                        if(neomenclaturaincidencia=="B" && conteoprimerdiabaja==1){
                            valorasistencia=1;
                          bajas=(bajas+valorasistencia);

                        }

                        if(neomenclaturaincidencia=="ING" && conteoprimerdiabaja==1){
                            valorasistencia=1;
                          ingresos=(ingresos+valorasistencia);

                        }
                        if(neomenclaturaincidencia=="V/P2" ){  
                          vacacionespagadas24X24=(vacacionespagadas24X24+valorasistencia);

                        }

                        if(neomenclaturaincidencia=="V/D2" ){  
                          vacacionesdisfrutadas24X24=(vacacionesdisfrutadas24X24+valorasistencia);

                        }



        }
                            var turnosdia=traerincidenciastotalesbyclienteturnosdiaoneche(fecha,idcliente,2);
                            turnosdia=parseInt(turnosdia);
                            var turnosnoche=traerincidenciastotalesbyclienteturnosdiaoneche(fecha,idcliente,3);
                            turnosnoche=parseInt(turnosnoche);

                            rowTurnosCubiertosdescansos += "<td width='65px' >" + descansos+ "</td>";
                            rowTurnosCubiertos12X12 += "<td width='65px' >" + turnos12x12+ "</td>";
                            rowTurnosCubiertos24X24 += "<td width='65px' >" + turnos24X24+ "</td>";
                            rowFaltas+= "<td width='65px' >" + totalfaltas+ "</td>";
                            rowVacacionesPagadas+= "<td width='65px' >" + vacacionespagadas+ "</td>";
                            rowVacacionesDisfrutadas+= "<td width='65px' >" + vacacionesdisfrutadas+ "</td>";
                            rowPermisos+= "<td width='65px' >" + permisos+ "</td>";
                            rowIncapacidad+= "<td width='65px' >" + incapacidad+ "</td>";
                            rowDescansoTrabajado12X12+= "<td width='65px' >" + descansotrabajado12X12+ "</td>";
                            rowBajas+= "<td width='65px' >" + bajas+ "</td>";
                            rowIngresos+= "<td width='65px' >" + ingresos+ "</td>";
                            rowVacacionesPagadas24X24+= "<td width='65px' >" + vacacionespagadas24X24+ "</td>";
                            rowVacacionesDisfrutadas24X24+= "<td width='65px' >" + vacacionesdisfrutadas24X24+ "</td>";
                            rowTurnostotalesDia+= "<td width='65px' >" + turnosdia+ "</td>";
                            rowTurnostotalesNoche+= "<td width='65px' >" + turnosnoche+ "</td>";
                            ///////////////PARA LA SUMA DE TOTAL DE TOTALES//////////////
                            totaldescansos=(totaldescansos+descansos);
                            totalturnos12x12=(totalturnos12x12+turnos12x12);
                            totalturnos24x24=(totalturnos24x24+turnos24X24);
                            totalTotalesfaltas=(totalTotalesfaltas+totalfaltas);
                            totalvacacionespagadas=(totalvacacionespagadas+vacacionespagadas);
                            totalvacacionesdisfrutadas=(totalvacacionesdisfrutadas+vacacionesdisfrutadas);
                            totalpermisos=(totalpermisos+permisos);
                            totalincapacidades=(totalincapacidades+incapacidad);
                            totaldescansostrabajados12x12=(totaldescansostrabajados12x12+descansotrabajado12X12);
                            totalbajas=(totalbajas+bajas);
                            totalingresos=(totalingresos+ingresos);
                            totalvacacionespagadas24x24=(totalvacacionespagadas24x24+vacacionespagadas24X24);
                            totalvacacionesdisfrutadas24x24=(totalvacacionesdisfrutadas24x24+vacacionesdisfrutadas24X24);
                            turnostotalesdia=(turnostotalesdia+turnosdia);
                            turnostotalesnoche=(turnostotalesnoche+turnosnoche);
                            ///////////////////////////+/////////////////////////////////
                            }
                            rowTurnosCubiertosdescansos += "<td width='60px' >" + totaldescansos+ "</td>";
                            rowTurnosCubiertos12X12 += "<td width='65px' >" + totalturnos12x12+ "</td>";
                            rowTurnosCubiertos24X24 += "<td width='65px' >" + totalturnos24x24+ "</td>";
                            rowFaltas+= "<td width='65px' >" + totalTotalesfaltas+ "</td>";
                            rowVacacionesPagadas+= "<td width='65px' >" + totalvacacionespagadas+ "</td>";
                            rowVacacionesDisfrutadas+= "<td width='65px' >" + totalvacacionesdisfrutadas+ "</td>";
                            rowPermisos+= "<td width='65px' >" + totalpermisos+ "</td>";
                            rowIncapacidad+= "<td width='65px' >" + totalincapacidades+ "</td>";
                            rowDescansoTrabajado12X12+= "<td width='65px' >" + totaldescansostrabajados12x12+ "</td>";
                            rowBajas+= "<td width='65px' >" + totalbajas+ "</td>";
                            rowIngresos+= "<td width='65px' >" + totalingresos+ "</td>";
                            rowVacacionesPagadas24X24+= "<td width='65px' >" + totalvacacionespagadas24x24+ "</td>";
                            rowVacacionesDisfrutadas24X24+= "<td width='65px' >" + totalvacacionesdisfrutadas24x24+ "</td>";
                            rowTurnostotalesDia+= "<td width='65px' >" + turnostotalesdia+ "</td>";
                            rowTurnostotalesNoche+= "<td width='65px' >" + turnostotalesnoche+ "</td>";
                              //var totalincidencias=conteodeincidenciaspordia(turnosACobrar,totalFestivos,2);                 
}
                      $('#tableConsultaFatigaconteo tr:last').after(rowTurnosCubiertosdescansos);
                      $('#tableConsultaFatigaconteo tr:last').after(rowTurnosCubiertos12X12);
                      $('#tableConsultaFatigaconteo tr:last').after(rowTurnosCubiertos24X24);
                      $('#tableConsultaFatigaconteo tr:last').after(rowFaltas);
                      $('#tableConsultaFatigaconteo tr:last').after(rowVacacionesPagadas);
                      $('#tableConsultaFatigaconteo tr:last').after(rowVacacionesDisfrutadas);
                      $('#tableConsultaFatigaconteo tr:last').after(rowPermisos);
                      $('#tableConsultaFatigaconteo tr:last').after(rowIncapacidad);
                      $('#tableConsultaFatigaconteo tr:last').after(rowDescansoTrabajado12X12);
                      $('#tableConsultaFatigaconteo tr:last').after(rowBajas);
                      $('#tableConsultaFatigaconteo tr:last').after(rowIngresos);
                      $('#tableConsultaFatigaconteo tr:last').after(rowVacacionesPagadas24X24);
                      $('#tableConsultaFatigaconteo tr:last').after(rowVacacionesDisfrutadas24X24);
                      $('#tableConsultaFatigaconteo tr:last').after(rowTurnostotalesDia);
                      $('#tableConsultaFatigaconteo tr:last').after(rowTurnostotalesNoche);
                       
                  
}

function traerincidenciastotalesbyclientedia(fechadia,idcliente){
var turnosporclientebydia =Array();
//waitingDialog.show();
   $.ajax({
            
            type: "POST",
            url: "ajax_generarResumentotaltotalesbycliente.php",
            data: {"idcliente": idcliente
                , "fechadia": fechadia,"accion":1},
            dataType: "json",
            async:false,
            success: function(response) {
              //console.log(response);
                if (response.status == "success")
                {
                     
                    turnosporclientebydia = response.datos;
                   
                }else{
                  alert("error en turnos total suces");
                }
                
            },           

            error: function(jqXHR, textStatus, errorThrown){
              
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
   waitingDialog.hide();
return turnosporclientebydia;


}



function traerincidenciastotalesbyclienteturnosdiaoneche(fechadia,idcliente,accion){
var turnosdianoche =Array();
//waitingDialog.show();
   $.ajax({
            
            type: "POST",
            url: "ajax_generarResumentotaltotalesbycliente.php",
            data: {"idcliente": idcliente
                , "fechadia": fechadia,"accion":accion},
            dataType: "json",
            async:false,
            success: function(response) {
              console.log("turnosdiaonoche "+accion);
              
                if (response.status == "success")
                {
                     
                    turnosdianoche = response.turnosdianoche[0].turnosdiaonoche;
                    console.log(turnosdianoche);
                   
                }else{
                  alert("error en turnos total suces");
                }
                
            },           

            error: function(jqXHR, textStatus, errorThrown){
              
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
   waitingDialog.hide();
return turnosdianoche;


}

 

</script>