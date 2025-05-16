
<div class="container" align="center" >
<form class="form-horizontal" id="form_consultaFatiga" name="form_consultaFatiga" action="ficheroExportFatiga.php" target="_blank" method="post">
  <div>
            DE:<input id="txtFechaFatiga1" name="txtFechaFatiga1" type="text" class="input-medium"> A: <input id="txtFechaFatiga2" name="txtFechaFatiga2" type="text" class="input-medium" onchange='cargarPuntosServicios();'>
            <br>
            <br>
              <?php
               if ($usuario["rol"] =="Facturacion" || $usuario["rol"] =="Analista Asistencia") {
              ?>
                <button id="descargarTodas" name="descargarTodas" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Todas</button>
                <br>
                <br>
                <select id="selectSupervisorFatiga" name="selectSupervisorFatiga" class="input-large" onchange="getPuntosServiciosBySupervisorFatiga();" >
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
            <select id="selectEntidadFatiga" name="selectEntidadFatiga" class="input-large " onChange="obtenerPuntosServiciosPorEntidadFatiga();" >
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
            <select id="selectPuntoServicioFatiga" name="selectPuntoServicioFatiga" onchange="obtenerPlantillasPorPuento();" ></select>
            <br>
            <!-- <select id="selectPuntoServicioFatiga2" name="selectPuntoServicioFatiga2" class="selectpicker" data-live-search="true" class="input-large" data-size="9">  getEmpleadosFatiga
              <option>Opcion 1</option>
              <option>Opcion 3</option>
              <option>Opcion 4</option>
              <option>Opcion 5</option>
              <option>Opcion 6</option>
            </select> -->
              <br>
            <br>cobraDescanso <input id="txtCobraDescansoFatiga" name="txtCobraDescansoFatiga" type="text" class="input-small" readonly>
            <br>cobraFestivo <input id="txtCobraDiaFestivo" name="txtCobraDiaFestivo" type="text" class="input-small" readonly>
            <br>cobra31 <input id="txtCobra31" name="txtCobra31" type="text" class="input-small" readonly>
    </div>

  <br>
  <br>
  <input type="hidden" id="datos_fatiga" name="datos_fatiga" />
  <div id="divFatiga" name="divFatiga" align="center" class='container'><br><br>
    <div id="divLogo" name="divLogo"></div>
  
          <div id="divRequisicionFatiga" name="divRequisicionFatiga"> </div>
        
          <div id="divPorcentajeCoberturaF" name="divPorcentajeCoberturaF"> </div>

          <div id="divDescansosFatiga" name="divDescansosFatiga"> </div>
    
    <!--<div>
      <div id="divRequisicionFatiga" name="divRequisicionFatiga"> </div>
      <div id="divPrueba" name="divPrueba"> </div>
    </div> -->
    <br>
    <br>
    <div id="divTableConsultaFatiga" name="divTableConsultaFatiga"></div><br><br>
    <div id="divTurnosExtras" name="divTurnosExtras"></div>
  </div>
 
  <button id="descargarFatiga" name="descargarFatiga" class="btn btn-success" type="button"> <span class="glyphicon glyphicon-download-alt"></span>Descargar Excel</button>
  <br>
  <br>
  
  <button id="descargarFatigaPDF" name="descargarFatigaPDF" class="btn btn-danger" type="button" onclick="generadorFormatoFatiga();"> <span class="glyphicon glyphicon-download-alt"></span>Descargar PDF</button>

  <button id="descargarFatigaPDFExcel" name="descargarFatigaPDFExcel" class="btn btn-danger" type="button" onclick="generadorPdfExcel();"> <span class="glyphicon glyphicon-download-alt"></span>Descargar PDF Excel</button>
  <br>
  <br>

  <?php 
  if ($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){
                
  ?>
  <button id="enviarFatigaPDF" name="enviarFatigaPDF" class="btn btn-info" type="button" onclick="validacionEnvioFatiga();"> <span class="glyphicon glyphicon-send"></span> Enviar Fatiga</button>  
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
var turnosExtrasTemporal=0;
var PlantillasPorPunto = {};
var LargoPlantillas=0;

var stylesFatiga = [];

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
                stylesFatiga ["CAP"] = "background-color:#fbbf34";


var stylesTurno = [];

                stylesTurno [1] = "background-image: url(\"img/triangulo_1.png\");background-position: center;";
                stylesTurno [2] = "background-image: url(\"img/triangulo_2.png\");background-position: center;";
                stylesTurno [3] = "background-image: url(\"img/triangulo_3.png\");background-position: center;";
                stylesTurno [4] = "background-image: url(\"img/triangulo_4.png\");background-position: center;";
                stylesTurno [5] = "background-image: url(\"img/triangulo_5.png\");background-position: center;";
                stylesTurno [6] = "background-image: url(\"img/triangulo_6.png\");background-position: center;";
                stylesTurno [7] = "background-image: url(\"img/completo_7.png\");background-position: center;";
             
  function generarTablaRangoFechaFatiga(opcion,j){
    var rangoFecha1=$("#txtFechaFatiga1").val();
    var rangoFecha2=$("#txtFechaFatiga2").val();         
    if(opcion==1){
        
      var table="<table class='table table-bordered table-striped'  border='3px' id='tableConsultaFatiga"+j+"' name='tableConsultaFatiga"+j+"'><thead><tr><th  width='80px'>#Empleado</th>";
      table +="<th width='160px'>Nombre Empleado</th>";
      table+="<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='100px'>Rol Operativo</th><th width='100px'>Id Plantilla</th>";
      table += generarColumnasRangoFechasFatiga(rangoFecha1, rangoFecha2);
      table +="<th>T.Q</th><th>D.F</th><th>TOTAL</th><th width='20px'>TOTAL + EXTRAS</th></tr></thead><tbody></tbody></table>";
      $('#divTableConsultaFatiga').append(table);

    }else{
      var table="<table class='table table-bordered table-striped' style='display: none' border='3px' id='tableConsultaFatiga' name='tableConsultaFatiga'><thead><tr><th  width='160px'>Nombre Cliente</th>";
      table +="<th width='160px'>Punto de Servicio</th>";
      table +="<th width='80px'>Entidad</th>";
      table +="<th width='160px'>Supervisor</th>";
      table +="<th width='160px'>Numero Empleado</th>";
      table +="<th width='160px'>Nombre Empleado</th>";
      table+="<th width='100px'>Puesto</th><th width='80px'>Turno</th><th width='80px'>RolOperativo</th>";
      table += generarColumnasRangoFechasFatiga(rangoFecha1, rangoFecha2);
      table +="<th>T.Q</th><th>D.F</th><th>TOTAL</th><th width='20px'>TOTAL + EXTRAS</th></tr></thead><tbody></tbody></table>";
      $('#divTableConsultaFatiga').html(table);
    }
    
  }

    function generarColumnasRangoFechasFatiga (fecha1, fecha2)
     {
         var result = "";
         var rangoFechas = crearRangoFechasFatiga (fecha1, fecha2);

         for (var i = 0; i < rangoFechas.length; i++)
         {
             var fecha = rangoFechas [i];
             result += "<th>" + fecha.getFullYear () + "-" + (fecha.getMonth () + 1) + "-" + fecha.getDate() + "</th>";
         }

         return result;
     }

     function crearRangoFechasFatiga (fecha1, fecha2)
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
          return result;
     }

    function obtenerPlantillasPorPuento(){
      var rangoFecha1=$("#txtFechaFatiga1").val();
      var rangoFecha2=$("#txtFechaFatiga2").val();
      var puntoServicio=$("#selectPuntoServicioFatiga").val();  
      if(rangoFecha1 =="" || rangoFecha2==""){
        swal("ALTO","Ninguna de las fechas puede ir vacia","error");
      }else if(rangoFecha1 > rangoFecha2){
        swal("ALTO","La fecha inicial no puede ser mayor a la fecha final","error");
      }else{
        $.ajax({
          type: "POST",
          url: "ajax_getPlantillaPorPuntoFatiga.php",
          data : {"puntoServicio":puntoServicio,"rangoFecha1":rangoFecha1,"rangoFecha2":rangoFecha2},
          dataType: "json",
          success: function(response) {
            if (response.status == "success"){
              $('#divTableConsultaFatiga').html("");
              $('#divTurnosExtras').html(""); 
              turnosExtrasTemporal=0;
              LargoPlantillas = response.datos.length; 
              PlantillasPorPunto = response.datos;
              getEmpleadosFatiga(LargoPlantillas,PlantillasPorPunto);     
            }else{

            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText); 
          }
        });
      }
    }

function getEmpleadosFatiga(LargoPlantillas,plantillasPorPunto) 
{ 
  waitingDialog.show();
  var plantillasid= [];
  var aa =0;
  for (var h = 0; h < LargoPlantillas; h++) {
    var idplantillaPunto = plantillasPorPunto[h].servicioPlantillaId;
    var IdRolOperativoPlantilla = plantillasPorPunto[h].IdRolOperativoPlantilla;
    var puestoPlantillaId = plantillasPorPunto[h].puestoPlantillaId;
    if(h == 0){ 
      plantillasid[aa] = [];
      plantillasid[aa]["idplantillaPunto"] = [];
      // plantillasid[aa]["idplantillaPunto"][aa] = []
      plantillasid[aa]["idplantillaPunto"][aa] = idplantillaPunto;
      plantillasid[aa]["IdRolOperativoPlantilla"] = IdRolOperativoPlantilla;
      plantillasid[aa]["puestoPlantillaId"] = puestoPlantillaId;
    }else{
      var bandera = 0;
      var largopl = plantillasid.length;
      for (var hh = 0; hh < largopl; hh++) {
        var IdRolOperativoPlantillaAnt = plantillasid[hh].IdRolOperativoPlantilla;
        var puestoPlantillaIdAnt = plantillasid[hh].puestoPlantillaId;
        if(IdRolOperativoPlantillaAnt == IdRolOperativoPlantilla && puestoPlantillaIdAnt == puestoPlantillaId){
          var largo123 = plantillasid[hh]["idplantillaPunto"].length;
          plantillasid[hh]["idplantillaPunto"][largo123] = idplantillaPunto;  
          bandera = 1;
        }
      }
      if(bandera == "0"){
        aa = aa+1;
        plantillasid[aa] = [];
        plantillasid[aa]["idplantillaPunto"] = [];
        plantillasid[aa]["idplantillaPunto"][0] = idplantillaPunto;
        plantillasid[aa]["IdRolOperativoPlantilla"] = IdRolOperativoPlantilla;
        plantillasid[aa]["puestoPlantillaId"] = puestoPlantillaId;
      }
    }
    
  }
  var NuevoLargoPlantilla = plantillasid.length;

  for (var j = 0; j < NuevoLargoPlantilla; j++) {
 
    var rangoFecha1=$("#txtFechaFatiga1").val();
    var rangoFecha2=$("#txtFechaFatiga2").val();
    var idplantillaPunto = plantillasid[j].idplantillaPunto;
    
    generarTablaRangoFechaFatiga(1,j);    
    var puntoServicio=$("#selectPuntoServicioFatiga").val();  
    var valorCobraDescanso=$("#op_spsf"+puntoServicio).attr("cobradescansos");
    var valorCobraDiaFestivo=$("#op_spsf"+puntoServicio).attr("cobraDiaFestivo");
    var valorCobra31=$("#op_spsf"+puntoServicio).attr("valorCobra31");
    $("#txtCobraDescansoFatiga").val(valorCobraDescanso);
    $("#txtCobraDiaFestivo").val(valorCobraDiaFestivo);
    $("#txtCobra31").val(valorCobra31);
    elementosSolicitadosFatiga(puntoServicio,rangoFecha1,rangoFecha2,2);
    porcentajeCoberturaPorPuntoDeServicio(puntoServicio,rangoFecha1,rangoFecha2);
    getTurnosExtrasFatiga(puntoServicio,idplantillaPunto,j);     
    $("#tableConsultaFatiga"+j).find("tr:gt(0)").remove();
    $.ajax({
      type: "POST",
      url: "ajax_getEmpleadosFatigaPorPlantillas.php",
      data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "puntoServicio":puntoServicio,"idplantillaPunto":idplantillaPunto},
      dataType: "json",
      async:false,
      success: function(response) {
        if (response.status == "success")
        {
          var empleadoEncontrado = response.listaEmpleados;
          var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);

          var turnosACobrar=0;
          var totalFestivos=0;
          for ( var i = 0; i < empleadoEncontrado.length; i++ ){
            var IdPlantilla = empleadoEncontrado[i].IdPlantilla;
            var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
            var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
            var descripcionPuesto = empleadoEncontrado[i].descripcionPuesto;
            var descripcionTurno=empleadoEncontrado[i].descripcionTurno;
            var asistencia = empleadoEncontrado[i].asistencia;  
            var roloperativo = empleadoEncontrado[i].roloperativo;  
            var sumaDiasFestivos=empleadoEncontrado[i].diasFestivos.diasFestivos;
            var dateTable="<tr><td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td>";
            dateTable+="<td width='80px'>"+descripcionTurno+"</td>";
            dateTable+="<td width='100px'>"+roloperativo+"</td>";
            dateTable+="<td width='100px'>"+IdPlantilla+"</td>";
            dateTable += generarCeldasFatiga (rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,IdPlantilla); 
            dateTable += "</tr>"  ;
            $("#tableConsultaFatiga"+j).append(dateTable);
                        
            var turnos= $("#td_tqc_"+numeroEmpleado+"_"+IdPlantilla).attr("sumaTurnosPeriodo");
            turnosACobrar=parseInt(turnosACobrar) + parseInt(turnos);
            totalFestivos=parseInt(totalFestivos)+parseInt(sumaDiasFestivos);
          }
          
          tooltipAjax2();
          obtenerTurnosCubiertos(turnosACobrar,totalFestivos,idplantillaPunto,j);
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
    });    
  }
  waitingDialog.hide();   
}

    function elementosSolicitadosFatiga(idPuntoServicio,rangoFecha1,rangoFecha2,option){

      if(option==1){
        document.getElementById("divTurnosExtras").innerHTML="";
      }
     var puntoServicio=$("#selectPuntoServicioFatiga option:selected").html();
       $.ajax({
            type: "POST",
            url: "ajax_getDetalleRequisicionesByPuntoServicioIdFatiga.php",
            data: {"idPuntoServicio": idPuntoServicio,"rangoFecha1": rangoFecha1,"rangoFecha2": rangoFecha2},
            dataType: "json",
            async:false,
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                    //var imgLogo="https://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/logo.jpg";
                    
                    var listaTable="<table border='3px' class='table table-bordered table-striped' ><thead><tr><th  colspan='3'>Elementos Solicitados "+puntoServicio+"</th></tr><tr><th>Elementos</th><th>Puesto</th><th>Turno</th><th>Rol Operativo</th><th>Fecha Alta</th><th>Fecha Baja</th><th>estatus Plantilla</th><th>IdPlantilla</th></tr></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroElementos = lista[i].numeroElementos;
                        var descripcionPuesto = lista[i].descripcionPuesto;
                        var descripcionTurno = lista[i].descripcionTurno;
                        var rolOperativoPlantilla = lista[i].rolOperativoPlantilla;
                        var fechaInicio = lista[i].fechaInicio;
                        var fechaTerminoPlantilla = lista[i].fechaTerminoPlantilla;
                        var estatusPlantilla1 = lista[i].estatusPlantilla;
                        var servicioPlantillaId = lista[i].servicioPlantillaId;
                        if(estatusPlantilla1 =="1"){
                          var estatusPlantilla = "ACTIVA";
                        }else{
                          var estatusPlantilla = "BAJA";
                        }
                           
                  listaTable += "<tr><td>"+numeroElementos+"</td><td> "+descripcionPuesto+"</td><td> "+descripcionTurno+"</td><td> "+rolOperativoPlantilla+"</td><td> "+fechaInicio+"</td><td> "+fechaTerminoPlantilla+"</td><td> "+estatusPlantilla+"</td><td> "+servicioPlantillaId+"</td></tr>";
 
                }
                     
                  listaTable += "</tbody></table>";
                  
                  $('#divRequisicionFatiga').html(listaTable);
                 }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
            }
        });
    }
    function porcentajeCoberturaPorPuntoDeServicio(idPuntoServicio,rangoFecha1,rangoFecha2){

   // document.getElementById("divTurnosExtras").innerHTML="";

     var puntoServicio=$("#selectPuntoServicioFatiga option:selected").html();
       $.ajax({
            
            type: "POST",
            url: "ajax_getPorcentajeCoberturaPorPuntoFatiga.php",
            data: {"idPuntoServicio": idPuntoServicio,"rangoFecha1": rangoFecha1,"rangoFecha2": rangoFecha2},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                  var lista = response.result;
                  var diaInicio = new Date(rangoFecha1);
                  var diaFin = new Date(rangoFecha2);
                  var difference= Math.abs(diaFin-diaInicio);
                  var LargoFecha = difference/86400000;
                  var TSD1 =0;
                  var TSN1 =0;
                  var TST1 =0;
                  var TCD1 =0;
                  var TCN1 =0;
                  var TE1 =0;
                  var TCT1 =0;
                  var PorcentajeDia1 =0;
                  var listaTable="<table border='3px' class='table table-bordered table-striped' ><thead><tr><th  colspan='9'>Porcentaje De Cobertura Del Punto De Servicio : "+puntoServicio+"</th></tr><tr><th>Fecha</th><th>T.SolicitadoDia</th><th>T.SolicitadoNoche</th><th>T.SolicitadoTotal</th><th>T.CubiertoDia</th><th>T.CubiertoNoche</th><th>T.Extras</th><th>T.CubiertoTotal</th><th>PorcentajeCobertura</th></thead><tbody>";

                  for(var i = 0; i< LargoFecha+1; i++){
                    var Fecha = response.fechas[i].fechas1; 
                    var TSD = lista[Fecha].turnoDeDia;
                    var TSN = lista[Fecha].turnosDeNoche;
                    var TST = lista[Fecha].turnosPorDia;
                    var TCD = lista[Fecha].turnosCubiertosDia;
                    var TCN = lista[Fecha].turnosCubiertosNoche;
                    var TE = lista[Fecha].Extras;
                    var TCT = lista[Fecha].turnosCubiertos;
                    var PorcentajeDia = lista[Fecha].PrcentajeTotalTunos;

                    TSD1 = TSD1 + TSD;
                    TSN1 = TSN1 + TSN;
                    TST1 = TST1 + TST;
                    TCD1 = TCD1 + TCD;
                    TCN1 = TCN1 + TCN;
                    TE1 = TE1 + TE;
                    TCT1 = TCT1 + TCT;
                    PorcentajeDia1 = PorcentajeDia1 + PorcentajeDia;
                    PorcentajeDia1 = Math.round(PorcentajeDia1);
                    listaTable += "<tr><td>"+Fecha+"</td><td> "+TSD+"</td><td> "+TSN+"</td><td> "+TST+"</td><td> "+TCD+"</td><td> "+TCN+"</td><td> "+TE+"</td><td> "+TCT+"</td>";
                    if(PorcentajeDia == "100"){
                      listaTable += "<td style = 'color: green;'> "+PorcentajeDia+"%</td></tr>";
                    }else if(PorcentajeDia == "80" || (PorcentajeDia > "80" && PorcentajeDia < "100")){
                      listaTable += "<td style = 'color: orange;'> "+PorcentajeDia+"%</td></tr>";
                    }else {
                      listaTable += "<td style = 'color: red;'> "+PorcentajeDia+"%</td></tr>";
                    }
                  }
                  var totalDescanso =response.totalDescanso;
                  var PorcentajeDia2 = (PorcentajeDia1/(LargoFecha+1));
                  PorcentajeDia2 = Math.round(PorcentajeDia2);
                  
                  listaTable += "<tr><td>Totales</td><td> "+TSD1+"</td><td> "+TSN1+"</td><td> "+TST1+"</td><td> "+TCD1+"</td><td> "+TCN1+"</td><td> "+TE1+"</td><td> "+TCT1+"</td>"; 
                  if(PorcentajeDia2 == "100"){
                    listaTable += "<td style = 'color: green;'> "+PorcentajeDia2+"%</td></tr>";
                  }else if(PorcentajeDia2 == "80" || (PorcentajeDia2 > "80" && PorcentajeDia2 < "100")){
                    listaTable += "<td style = 'color: orange;'> "+PorcentajeDia2+"%</td></tr>";
                  }else {
                    listaTable += "<td style = 'color: red;'> "+PorcentajeDia2+"%</td></tr>";
                  }                                       
                  listaTable += "</tbody></table>";
                  $('#divPorcentajeCoberturaF').html(listaTable);


                  var listaTable1="<table border='3px' class='table table-bordered table-striped' ><thead><tr><th  colspan='1'>Total Descansos Del Punto De Servicio : "+puntoServicio+"</th></tr></thead><tbody>";
                  listaTable1 += "<tr><td> Descansos Totales -> "+totalDescanso+"</td></tr></tbody></table>"; 
                  $('#divDescansosFatiga').html(listaTable1);


                 // $('#divPrueba').html(listaTable);


                  //var img="<img src='"+imgLogo+"' width='100' height='100'>";

                  //$("#divLogo").html(img);    
                                   
                 }
            },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
        });
    }

    function getTurnosExtrasFatiga(idPuntoServicio,idplantillaPunto,j){ 
     //var puntoServicio=$("#selectPuntoServicioFatiga option:selected").html();
     var rangoFecha1=$("#txtFechaFatiga1").val();
     var rangoFecha2=$("#txtFechaFatiga2").val();
     turnosExtra=0;
       $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getTurnosExtrasFatigaPorPlantilla.php",
            data: {"fecha1":rangoFecha1, "fecha2":rangoFecha2,"puntoServicioId": idPuntoServicio,"idplantillaPunto": idplantillaPunto},
            dataType: "json",
            
            success: function(response) {
                if (response.status == "success")
                {
                     
                    var lista = response.lista;
                    var totalExtras=0;
                    if (lista.length >=1){
                    //var imgLogo="https://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/logo.jpg";
                    var listaTable="<table border='3px' class='table table-bordered table-striped' id='tableTExstrasFatiga"+j+"' name='tableTExstrasFatiga"+j+"'><thead><tr><th colspan='8'>EXTRAS PLANTILLA </th></tr><tr><th>#Empleado</th><th>Nombre Empleado</th><th>Fecha</th><th>Id Plantilla</th><th>Rol Operativo</th><th>Puesto Plantilla</th><th>Comentario</th><th>TURNO</th></tr></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var descripcionIncidenciaEspecial = lista[i].descripcionIncidenciaEspecial;
                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombreEmpleado = lista[i].nombreEmpleado;
                        var incidenciaFecha = lista[i].incidenciaFecha;
                        var incidenciaComentario = lista[i].incidenciaComentario;
                        var valorIncidenciaEspecial= lista[i].valorIncidenciaEspecial;
                        var RolPlantilla= lista[i].RolPlantilla;
                        var PuestoPlantilla= lista[i].PuestoPlantilla;                        
                        var incidenciaIdPlantilla= lista[i].incidenciaIdPlantilla;                        

                        totalExtras=parseInt(totalExtras)+ parseInt(valorIncidenciaEspecial);

                           
                      listaTable += "<tr><td>"+numeroEmpleado+"</td><td> "+nombreEmpleado+"</td><td> "+incidenciaFecha+"</td><td>"+incidenciaIdPlantilla+"</td><td>"+RolPlantilla+"</td><td>"+PuestoPlantilla+"</td><td>"+incidenciaComentario+"</td><td>"+descripcionIncidenciaEspecial+"</td></tr>";
 
                    }
                  turnosExtra=totalExtras;
                  listaTable += "<tr><td colspan='7'> Total Turnos Extras</td><td>"+turnosExtra+"</td></tr></tbody></table>";
                    
                      $('#divTurnosExtras').append(listaTable);
                    

                  

                  }

                  //var img="<img src='"+imgLogo+"' width='100' height='100'>";

                  //$("#divLogo").html(img);    
                                     
                }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            }
        });
    }

    function getTurnosExtrasFatigaExcel(idPuntoServicio){

     //var puntoServicio=$("#selectPuntoServicioFatiga option:selected").html();
     var rangoFecha1=$("#txtFechaFatiga1").val();
     var rangoFecha2=$("#txtFechaFatiga2").val();
       $.ajax({
            async: false,
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
                    
                    var listaTable="<table border='3px' class='table table-bordered table-striped'><thead><tr><th colspan='7'>EXTRAS</th></tr><tr><th>#Empleado</th><th>Nombre Empleado</th><th>Fecha</th><th>Id Plantilla</th><th>Rol Operativo</th><th>Puesto Plantilla</th><th>Comentario</th></tr></thead><tbody>";

                    for ( var i = 0; i < lista.length; i++ ){
                        
                        var numeroEmpleado = lista[i].numeroEmpleado;
                        var nombreEmpleado = lista[i].nombreEmpleado;
                        var incidenciaFecha = lista[i].incidenciaFecha;
                        var incidenciaComentario = lista[i].incidenciaComentario;
                        var valorIncidenciaEspecial= lista[i].valorIncidenciaEspecial;
                        var RolPlantilla= lista[i].RolPlantilla;
                        var PuestoPlantilla= lista[i].PuestoPlantilla;                        
                        var incidenciaIdPlantilla= lista[i].incidenciaIdPlantilla;                        

                        totalExtras=parseInt(totalExtras)+ parseInt(valorIncidenciaEspecial);

                           
                      listaTable += "<tr><td>"+numeroEmpleado+"</td><td> "+nombreEmpleado+"</td><td> "+incidenciaFecha+"</td><td>"+incidenciaIdPlantilla+"</td><td>"+RolPlantilla+"</td><td>"+PuestoPlantilla+"</td><td>"+incidenciaComentario+"</td></tr>";
 
                    }
                  turnosExtra=totalExtras;

                  listaTable += "<tr><td colspan='6'> Total Turnos Extras</td><td>"+totalExtras+"</td></tr></tbody></table>";
                  
                  $('#divTurnosExtras').html(listaTable);  

                  }

                  //var img="<img src='"+imgLogo+"' width='100' height='100'>";

                  //$("#divLogo").html(img);    
                                     
                }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            }
        });
    }

    function generarCeldasFatiga (rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,idplantillaPunto)
    {
          var result = "";
          var sumaTurnosPeriodo=0;
          //console.log(asistencia);
          var descansos=0;
          var totalFestivos=0;
          var sumaTurnosDia31=0;
          var valor=0;
          var valorCobraDescanso=$("#txtCobraDescansoFatiga").val();
          var valorCobraDiaFestivo=$("#txtCobraDiaFestivo").val();
          var valorCobra31=$("#txtCobra31").val();
          for (var i = 0; i < rangoFechas.length; i++)
          {
              var fecha = formatDateYYYYMMDD (rangoFechas [i]);
              var asistenciaText = "&nbsp;";
              //console.log(numeroEmpleado);
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

                //console.log(asistencia[fecha]);  
                valor= obtenerTurnoAsistencia(fecha,numeroEmpleado,asistencia[fecha]["puntoServicioAsistenciaId"],idplantillaPunto);
              }

              var style = stylesFatiga [asistenciaText];
              if(valor!=0){
                if(valor=="8" || valor=="9" || valor=="10" || valor=="11" || valor=="12" || valor=="13" || valor=="14" || valor=="15" || valor=="16" || valor=="17" || valor=="18" ){
                  style = stylesFatiga [asistenciaText];
                }else{
                  style = stylesTurno[valor];
                }
                    
  

              if(asistenciaText=="ING"){
                asistenciaText="";
              }else if(asistenciaText=="F"){
                asistenciaText="F";
              }else if(asistenciaText=="PER"){
                asistenciaText="";
              }else if(asistenciaText=="V/P"){
                asistenciaText="1";
              }else if(asistenciaText=="V/D"){
                asistenciaText="";
              }else if(asistenciaText=="INC"){
                asistenciaText="";
              }else if(asistenciaText=="B"){
                asistenciaText="";
              }else if(asistenciaText=="DT12"){
                asistenciaText="1";
              }
              else if(asistenciaText=="V/P2"){
                asistenciaText="2";
              }else if(asistenciaText=="V/D2"){
                asistenciaText="";
              }
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



          result +="<td width='20px' id='td_tqc_"+numeroEmpleado+"_"+idplantillaPunto+"' name='td_tqc_"+numeroEmpleado+"_"+idplantillaPunto+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"' descansos='"+descansos+"'>"+sumaTurnosPeriodo+"</td>";
          result +="<td width='20px' id='td_tdff_"+numeroEmpleado+"' name='td_tdff_"+numeroEmpleado+"' sumaDiasFestivos='"+ sumaDiasFestivos +"' >"+sumaDiasFestivos+"</td>";
          result +="<td width='20px' id='td_tqt_"+numeroEmpleado+"' name='td_tqt_"+numeroEmpleado+"' totalTurnos='"+totalTurnos+"'>"+totalTurnos+"</td>";
          return result;
     }

     function obtenerTurnosCubiertos(turnosACobrar, totalFestivos,IdPlantillaServ,j){

        var idPuntoServicio=$("#selectPuntoServicioFatiga").val();
        var rangoFecha1=$("#txtFechaFatiga1").val();
        var rangoFecha2=$("#txtFechaFatiga2").val();              
         $.ajax({
              
              type: "POST",
              url: "ajax_GenerarResumenAsistenciaParaFatiga.php",
              data: {"puntoServicioId": idPuntoServicio,"fechaInicial": rangoFecha1,"fechaFinal": rangoFecha2,"IdPlantillaServ": IdPlantillaServ},
              dataType: "json",
              async:false,
              success: function(response) {
                  if (response.status == "success")
                  {
                       
                      turnosPresupuestados = response.result;
                      // console.log(turnosPresupuestados);

                      var resumen = crearResumenDeTurnosFatiga (turnosACobrar,totalFestivos,1);
                      $('#tableConsultaFatiga'+j+' tr:last').after(resumen);
                  }
              },           

              error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
          });
    }

    function crearResumenDeTurnosFatiga (turnosACobrar,totalFestivos,opcion)
  {
    // console.log(turnosACobrar);
    // console.log(totalFestivos);
    // console.log(opcion);
    // Variables globales
    // turnosPresupuestados
    // fechasAsistencia
    // turnosCubiertos
    //alert(turnosACobrar);
    var valorCobraDescanso=$("#txtCobraDescansoFatiga").val();
    var valorCobraDiaFestivo=$("#txtCobraDiaFestivo").val();

    var rangoFecha1=$("#txtFechaFatiga1").val();
    var rangoFecha2=$("#txtFechaFatiga2").val();

    var result = "";
    if(opcion==1)
        var primerColumna = "<td width='747px' align='right' colspan='6'>";
    else
        var primerColumna = "<td width='747px' align='right' colspan='9'>";

    //var rowTurnosPresupuestados = "<tr>" + primerColumna + "Turnos Presupuestados</td>";
    var rowTurnosCubiertos = "<tr >" + primerColumna + "Turnos Totales</td>";
    //var rowDiferenciaTurnos = "<tr>" + primerColumna + "Diferencia</td>";

    //console.log (turnosPresupuestados);

    var rangoFechas = crearRangoFechas (rangoFecha1, rangoFecha2);
    var turnosPeriodo=0;

    for (var i = 0; i < rangoFechas.length; i++)
    {
        
        var fecha = formatDateYYYYMMDD (rangoFechas [i]);
    
      // fechaAsistencia = fechasAsistencia [i];

        //turnoCubierto = turnosPresupuestados [fecha].turnosCubiertos;
    
    if (turnosPresupuestados[fecha] != null)
        {
            turnoCubierto = turnosPresupuestados [fecha].turnosCubiertos;
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



/*
FUNCION QUE OBTIENE LOS PUNTOS DE SERVICIOS POR CADA SUPERVISOR




*/

  function getPuntosServiciosBySupervisorFatiga()
    {
      
      var rangoFecha1=$("#txtFechaFatiga1").val();
      var rangoFecha2=$("#txtFechaFatiga2").val();
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
      ?>
      supervisorId=$("#selectSupervisorFatiga").val();
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
                        
                        puntosOptions += "<option id='op_spsf"+puntos[i].puntoServicioId+"' name='op_spsf"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"' razonSocial='"+razonSocial+"'>" + puntos[i].puntoServicio + "</option>";
                        
                        //var option = "<option id='op_spsf"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntos[i].puntoServicio + "</option>";
                    
                        //$("#selectPuntoServicioFatiga2").append (option);
                        //$('.selectpicker').selectpicker('refresh');
                        
                    }
                    puntosOptions+="<option>TODOS</option>";
                    //if($("#selectSupervisorFatiga").val() != "todosSup"){
                    $("#selectEntidadFatiga").prop('selectedIndex', 0);
                    //}
                    $("#selectPuntoServicioFatiga").html (puntosOptions);
                    <?php
                    if($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"):
                    ?>
                    $("#selectEntidadFatiga").prop('selectedIndex', -1);
                    $("#selectPuntoServicioFatiga").html (puntosOptions);
                    <?php
                    endif;
                    ?>



                    
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }

     function obtenerPuntosServiciosPorEntidadFatiga()
    {
       
       //var mitexto = $("#tipoPuesto option:selected").text();
       var idEntidad  = $("#selectEntidadFatiga").val();
       var fecha1=$("#txtFechaFatiga1").val();
       var fecha2=$("#txtFechaFatiga2").val();
           
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
                        puntosServiciosOptions += "<option id='op_spsf"+puntosServicios[i].idPuntoServicio+"' value='" + puntosServicios[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntosServicios[i].puntoServicio + "</option>";
                    }

                    //alert(puntosServiciosOptions);
                    puntosServiciosOptions+="<option>TODOS</option>";
                    $("#selectSupervisorFatiga").prop('selectedIndex', 0);
                    $("#selectPuntoServicioFatiga").html (puntosServiciosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }



  function generadorFormatoFatiga()
    {
      var idPuntoServicio=$("#selectPuntoServicioFatiga").val();
      var idSupervisor=$("#selectSupervisorFatiga").val();
      var fecha1=$("#txtFechaFatiga1").val();
      var fecha2=$("#txtFechaFatiga2").val();
      var entidadId=$("#selectEntidadFatiga").val();
      

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

    function generadorPdfExcel(){
      swal("Alto", "Función no disponible para tu usuario","error");
    }

    function getPuntosServiciosForFatigaByAnalista()
    {

            
      var fecha1=$("#txtFechaFatiga1").val();
      var fecha2=$("#txtFechaFatiga2").val();    

       $.ajax({
            type: "POST",
            url: "ajax_getPuntosForFatigaByAnalista.php",
            data: {"fecha1":fecha1, "fecha2":fecha2},
            dataType: "json",
            success: function(response) {
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
                      
                        puntosOptions += "<option id='op_spsf"+puntos[i].idPuntoServicio+"' value='" + puntos[i].idPuntoServicio + "'  cobraDescansos='"+ valorCobraDescanso +"' cobraDiaFestivo='"+valorCobraDiaFestivo+"' valorCobra31='"+valorCobra31+"' idCliente='"+idCliente+"'>" + puntos[i].puntoServicio + "</option>";
                        
                    }

                     <?php
                    if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"){                       
                    ?>
                    puntosOptions+="<option>TODOS</option>";
                    puntosTotales=puntos;
                    $("#selectPuntoServicioFatiga").html(puntosOptions);
                    
                    <?php
                    }
                    ?>

                  
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }


    function validacionEnvioFatiga(){

      //alert("hola");
      $("#modal_confirmacionEnvioFatiga").modal();

      var fecha1=$("#txtFechaFatiga1").val();
      var fecha2=$("#txtFechaFatiga2").val();  
      var puntoServicio=$("#selectPuntoServicioFatiga").val();

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



     $("#descargarFatiga").click(function(event) {
     $("#datos_fatiga").val( $("<div>").append( $("#divFatiga").eq(0).clone()).html());
     $("#form_consultaFatiga").submit();
      });


  /* $("#descargarTodas").click(function(event) {
   $("#datos_fatiga").val( $("<div>").append( $("#divFatiga").eq(0).clone()).html());
   $("#form_consultaFatiga").submit();
   });*/

  $('#txtFechaFatiga1').datetimepicker({   
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#txtFechaFatiga2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

  function cargarPuntosServicios(){


      $("#selectSupervisorFatiga").val("SUPERVISOR");
      $("#selectEntidadFatiga").val("ENTIDAD FEDERATIVA");

      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"){
      ?>

      getPuntosServiciosForFatigaByAnalista();
                    
      <?php
      }elseif($usuario["rol"] =="Supervisor" || $usuario["rol"] =="Consulta Supervisor"){
      ?>

      getPuntosServiciosBySupervisorFatiga();

      <?php
      }
      ?>
   

  }


  function sendFatiga ()
    {

      waitingDialog.show();

      var fecha1=$("#txtFechaFatiga1").val();
      var fecha2=$("#txtFechaFatiga2").val();  
      var puntoServicio=$("#selectPuntoServicioFatiga").val();

      var fecha1=$("#txtFechaFatiga1").val();
      var fecha2=$("#txtFechaFatiga2").val();  
      var puntoServicio=$("#selectPuntoServicioFatiga").val();
      var namePuntoServicio=$("#selectPuntoServicioFatiga option:selected").text();
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
            error: function(jqXHR, textStatus, errorThrown) {
              waitingDialog.hide();
              alert(jqXHR.responseText);
            }
        });
    }
$("#descargarTodas").click(function(event){ 
  waitingDialog.show('Generando Fatiga ...');
  setTimeout(DesxcargarTotas,1000);
    
    // DesxcargarTotas();
  }); 
 function DesxcargarTotas(){
    var rangoFecha1=$("#txtFechaFatiga1").val();
    var rangoFecha2=$("#txtFechaFatiga2").val();
    if(rangoFecha1 != "" && rangoFecha2!= ""){   
      // $('#divTableConsultaFatiga').html("");
      // $('#divTurnosExtras').html("");   
      var listaClientes=null;        
      $.ajax({
        async: false,
        type: "POST",
        url: "ajax_obtenerListaClientes.php",
        dataType: "json",
        success: function(response) {
          if (response.status == "success")
          {                       
            listaClientes = response.listaClientes;     
          }
          else if (response.status == "error")
          {
            alert("error inesperado");
          } 
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
      });
      //var listaEntidades=obtenerEntidadesFederativas();
      //var listaSupervisoresOperativos=obtenerSupervisoresOperativos();
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
      for ( var i = 0; i < listaClientes.length; i++ ){    
          idClientePunto = listaClientes[i].idCliente;
          razonSocial = listaClientes[i].razonSocial;
          var listaEntidades=ObtenerPuntosYEntidadesXCLiente(idClientePunto,rangoFecha1,rangoFecha2); 
          if(listaEntidades.length > 0){
            for ( var j = 0; j < listaEntidades.length; j++ ){
              idEntidad=listaEntidades[j].idEntidadFederativa;                  
              nombreEntidad=listaEntidades[j].nombreEntidadFederativa;
              if(idClientePunto==13){                         
                getEmpleadosFatigaTotales(listaEntidades[j],razonSocial,nombreEntidad,"CORPORATIVO",generaTabla);                                  
                generaTabla=false;
              }else{
                nombreSupersor = listaEntidades[j].nombreEmpleado + " " + listaEntidades[j].apellidoPaterno + " " + listaEntidades[j].apellidoMaterno;
                getEmpleadosFatigaTotales(listaEntidades[j],razonSocial,nombreEntidad,nombreSupersor,generaTabla); 
                turnosExtra=0;                                 
                generaTabla=false;
              }
            }
          }
      }
    }else
    { 
       waitingDialog.hide();
      alert("ingresa Fechas");
    }
    tooltipAjax2();
    $("#datos_fatiga").val( $("<div>").append( $("#divFatiga").eq(0).clone()).html()); 
    $("#form_consultaFatiga").submit();
    waitingDialog.hide();
  }

function ObtenerPuntosYEntidadesXCLiente(idClientePunto,rangoFecha1,rangoFecha2){
      var PuntosxSupFat=null;
      $.ajax({
              async: false,
              type: "POST",
              url: "ajax_ObtenerPuntosXSupFatiga.php",
              data: {"idClientePunto":idClientePunto,"rangoFecha1":rangoFecha1,"rangoFecha2":rangoFecha2},
              dataType: "json",
               success: function(response) {
                  if (response.status == "success")
                  {                      
                      PuntosxSupFat = response.PuntosxSupFat;   
                  }
                  else if (response.status == "error")
                  {
                    alert("error inesperado");
                  }
              },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
          });

      return PuntosxSupFat;
   }


   function obtenerEntidadesFederativas(){
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
              error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
          });

      return listaEntidades;
   }

   function obtenerSupervisoresOperativos(){

      $.ajax({
              async: false,
              type: "POST",
              url: "ajax_obtenerListaSupervisoresOperativos.php",
              
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
              error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
          });

      return listaSupervisores;
   }

   function getPuntosServiciosBySupervisorTotal(supervisorId)
    {
      
      var rangoFecha1=$("#txtFechaFatiga1").val();
      var rangoFecha2=$("#txtFechaFatiga2").val();
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
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
       return puntosZ;
    }

    function getEmpleadosFatigaTotales(punto,idClientePunto,idEntidad,supervisorId,generarTabla) 
    {      
      if(generarTabla){ 
          generarTablaRangoFechaFatiga(2,0); 
          //alert("se genero");
      }            
      //alert(idClientePunto);          
      var rangoFecha1=$("#txtFechaFatiga1").val();
      var rangoFecha2=$("#txtFechaFatiga2").val();          
      
      var valorCobraDescanso=punto.cobraDescansos;
      var valorCobraDiaFestivo=punto.cobraDiaFestivo;
      var valorCobra31=punto.cobra31;      

      $("#txtCobraDescansoFatiga").val(valorCobraDescanso);
      $("#txtCobraDiaFestivo").val(valorCobraDiaFestivo);
      $("#txtCobra31").val(valorCobra31);

      var puntoServicio=punto.puntoServicioId;    
      elementosSolicitadosFatiga(puntoServicio,rangoFecha1,rangoFecha2,1); 
      porcentajeCoberturaPorPuntoDeServicio(puntoServicio,rangoFecha1,rangoFecha2);
      getTurnosExtrasFatigaExcel(puntoServicio);       

        $.ajax({
            async: false,
            type: "POST",
            url: "ajax_getEmpleadosFatiga.php",
            data : {"fecha1":rangoFecha1, "fecha2":rangoFecha2, "puntoServicio":puntoServicio},
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
                      var roloperativo = empleadoEncontrado[i].roloperativo; 
                      var dateTable="<tr><td width='160px'>"+idClientePunto+"</td><td width='160px'>"+punto.puntoServicio+"</td><td width='800px'>"+idEntidad+"</td>";
                      dateTable+="<td width='160px'>"+supervisorId+"</td>";
                    dateTable+="<td width='80px'>"+numeroEmpleado+"</td><td width='160px'>"+nombreEmpleado+"</td><td width='100px'>"+descripcionPuesto+"</td>";
                    dateTable+="<td width='80px'>"+descripcionTurno+"</td>";
                    dateTable+="<td width='100px'>"+roloperativo+"</td>";
                    dateTable += generarCeldasFatigaTotal(rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,puntoServicio);
                    dateTable += "</tr>";  

                    $('#tableConsultaFatiga').append(dateTable);

                    var turnos= $("#td_tqc_"+numeroEmpleado+"_"+puntoServicio).attr("sumaTurnosPeriodo");                    
                    turnosACobrar=parseInt(turnosACobrar) + parseInt(turnos);

                    totalFestivos=parseInt(totalFestivos)+parseInt(sumaDiasFestivos);

                    }
                   // alert(turnosACobrar);
                  //if(puntoServicio == 1141)
                    //    alert("TURNOS COBRAR: " + turnosACobrar);
                   obtenerTurnosCubiertosTotal(puntoServicio,turnosACobrar,totalFestivos);
                    //elementosSolicitadosFatiga();
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
             console.log(jqXHR.responseText);
            }
        });

    }
  

    function encontrarPuntoClienteEntidad(idCliente,idEntidad,fecha1,fecha2){        
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
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
        return puntosE;
    }


    function encontrarPunto(listaPuntos,idPuntoServicio){
        for(var i=0; i<listaPuntos.length ; i++){
            if(listaPuntos[i].puntoServicioId == idPuntoServicio ){
                return true;
            }
        }

        return false;
    }


    function obtenerTurnosCubiertosTotal(idPuntoServicio,turnosACobrar, totalFestivos){

     
      
      var rangoFecha1=$("#txtFechaFatiga1").val();
      var rangoFecha2=$("#txtFechaFatiga2").val();
    
       $.ajax({
            
            type: "POST",
            url: "ajax_generarResumenAsistencia.php",
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
                    var resumen = crearResumenDeTurnosFatiga (turnosACobrar,totalFestivos,2);
                    $('#tableConsultaFatiga tr:last').after(resumen);
                }else{
                  alert("error en turnos total suces");
                }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }

    function generarCeldasFatigaTotal (rangoFechas, asistencia, numeroEmpleado,sumaDiasFestivos,puntoServicioId)
    {
     // console.log(asistencia);
          var result = "";
          var sumaTurnosPeriodo=0;
          var descansos=0;
          var totalFestivos=0;
          var sumaTurnosDia31=0;

          var valorCobraDescanso=$("#txtCobraDescansoFatiga").val();
          var valorCobraDiaFestivo=$("#txtCobraDiaFestivo").val();
          var valorCobra31=$("#txtCobra31").val();

          for (var i = 0; i < rangoFechas.length; i++)
          {
              var fecha = formatDateYYYYMMDD (rangoFechas [i]);
              var asistenciaText = "&nbsp;";

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
                asistenciaText="";
              }else if(asistenciaText=="F"){
                asistenciaText="F";
              }else if(asistenciaText=="PER"){
                asistenciaText="";
              }else if(asistenciaText=="V/P"){
                asistenciaText="1";
              }else if(asistenciaText=="V/D"){
                asistenciaText="";
              }else if(asistenciaText=="INC"){
                asistenciaText="";
              }else if(asistenciaText=="B"){
                asistenciaText="";
              }else if(asistenciaText=="DT12"){
                asistenciaText="1";
              }
              else if(asistenciaText=="V/P2"){
                asistenciaText="2";
              }else if(asistenciaText=="V/D2"){
                asistenciaText="";
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

          result +="<td width='20px' id='td_tqc_"+numeroEmpleado+"_"+puntoServicioId+"' name='td_tqc_"+numeroEmpleado+"_"+puntoServicioId+"' sumaTurnosPeriodo='"+ sumaTurnosPeriodo +"' descansos='"+descansos+"'>"+sumaTurnosPeriodo+"</td>";
          result +="<td width='20px' id='td_tdff_"+numeroEmpleado+"' name='td_tdff_"+numeroEmpleado+"' sumaDiasFestivos='"+ sumaDiasFestivos +"' >"+sumaDiasFestivos+"</td>";
          result +="<td width='20px' id='td_tqt_"+numeroEmpleado+"' name='td_tqt_"+numeroEmpleado+"' totalTurnos='"+totalTurnos+"'>"+totalTurnos+"</td>";

          return result;
     }


     function obtenerTurnoAsistencia(fechaAsistencia,numeroEmpleado,puntoServicio,idplantillaPunto){
        var turno=0;
        $.ajax({
            
            type: "POST",
            url: "ajax_consultaTurnoAsistenciaByFecha.php",
            data: {"fechaAsistencia": fechaAsistencia, "numeroEmpleado": numeroEmpleado, "puntoServicio": puntoServicio,"idplantillaPunto": idplantillaPunto},
            dataType: "json",
            async:false,
            success: function(response) {
                if (response.status == "success")
                {
                    turno = response.turno;
                }
            },           

            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });

        return turno;

     }



</script>