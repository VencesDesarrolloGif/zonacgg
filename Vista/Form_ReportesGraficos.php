<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<center>
  <div id="divNota" style="display: none">
   <p style="border:ridge #D00C03 1px;">Nota: Al dar click en el buscador, Traerá la información requerida<br>dependiendo de los selectores que haya elegido.</p>
  </div>
 <h3>Clientes Facturables</h3>
     <table>
       <tr>
           <td>
               <div class="chart-container" style="width:2vw">
                   <input type="radio" id="radioSí" name="radioSí">
                   <h4>Si</h4>
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:2vw">
                   <input type="radio" id="radioNo" name="radioNo">
                   <h4>No</h4>                                        
               </div>
           </td> 
       </tr>      
     </table>
</center><br>

<div id="divConCorporativoGif" style="display: none">
  <div id="DivTitGraficaGral">
   <head>   
    <center> 
     <h1>GRAFICA GENERAL</h1>   
    </center>
   </head><br>
 </div>
  <center> 
    <input id="checkMermaIncapacidad" type="checkbox"> <h5>Buscar Merma e Incapcidades</h5><br>
  </center>
 
  <div id="divGIFContenedorsinMerma">
    <center>
          <select id="seleccionarLineaNegocioGif" name="seleccionarLineaNegocioGif" class="input-large" disabled=""> 
           <?php
             for ($i=0; $i<count($catalogoLineaNegocio); $i++){
                  echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
             }  
           ?>
          </select>
   <select name="selectMesGif" id="selectMesGif">
         <option value="1">ENERO</option>
         <option value="2">FEBRERO</option>
         <option value="3">MARZO</option>
         <option value="4">ABRIL</option>
         <option value="5">MAYO</option>
         <option value="6">JUNIO</option>
         <option value="7">JULIO</option>
         <option value="8">AGOSTO</option>
         <option value="9">SEPTIEMBRE</option>
         <option value="10">OCTUBRE</option>
         <option value="11">NOVIEMBRE</option>
         <option value="12">DICIEMBRE</option>
   </select><img id="btnbusquedaGifmes" title="Buscar Por Mes"src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGif();" style="display: none;"><br>
         
   <select id="seleccionarEntidadGif" name="seleccionarEntidadGif" class="input-large" ></select>
   <img id="btnbusquedaGifEntidad" title="Buscar Por Entidad" src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGif();" style="display: none;"><br>
         
   <select id="seleccionarPSGif" name="seleccionarPSGif" class="input-large" style="display: none;"></select>
   <img id="btnbusquedaGifPS" title="Buscar Por Punto de Servicio"src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGif();" style="display: none;"><br>
      
     <div id="DivGraficaGif" class="col-lg-12" style="width:50vw"  name="DivGraficaGif"  style="display: none;">         
        <div id="DivGrafGif" name="DivGrafGif"></div> 
     </div>
  </center>
 </div>

<div id="divGIFMerma" style="display: none"><!--inicia merma-->
  
 <center>
          <select id="seleccionarLineaNegocioGifMerma" name="seleccionarLineaNegocioGifMerma" class="input-large" disabled=""> 
           <?php
             for ($i=0; $i<count($catalogoLineaNegocio); $i++){
                  echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
             }  
           ?>
          </select>
   <select name="selectMesMerma" id="selectMesMerma">
         <option value="1">ENERO</option>
         <option value="2">FEBRERO</option>
         <option value="3">MARZO</option>
         <option value="4">ABRIL</option>
         <option value="5">MAYO</option>
         <option value="6">JUNIO</option>
         <option value="7">JULIO</option>
         <option value="8">AGOSTO</option>
         <option value="9">SEPTIEMBRE</option>
         <option value="10">OCTUBRE</option>
         <option value="11">NOVIEMBRE</option>
         <option value="12">DICIEMBRE</option>
   </select><img id="btnbusquedaGifmesMerma" title="Buscar Por Mes"src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGifMerma();"><br>
         
   <select id="seleccionarEntidadGifMerma" name="seleccionarEntidadGifMerma" class="input-large" ></select>
   <img id="btnbusquedaGifEntidadMerma" title="Buscar Por Entidad" src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGifMerma();" style="display: none;"><br>
         
   <select id="seleccionarPSGifMerma" name="seleccionarPSGifMerma" class="input-large" style="display: none;"></select>
   <img id="btnbusquedaGifPSMerma" title="Buscar Por Punto de Servicio"src="img/botonbuscar.jpg" width="135px" onclick="BuscarElementosGifMerma();" style="display: none;"><br>
      
     <div id="DivGraficaGifMerma" class="col-lg-12" style="width:50vw"  name="DivGraficaGifMerma"  style="display: none;">         
        <div id="DivGrafGifMerma" name="DivGrafGifMerma"></div> 
     </div>
  </center>

</div><!--termina lo de merma-->
</div><!-- termina todo lo de GIF-->

<div id="divSinCorporativoGif" style="display: none">
<head>   
    <center> 
      <div id="divTitulo"></div>   
    </center>
</head><br>
<body><center> 
         <select id="seleccionarLineaNegocio" name="seleccionarLineaNegocio" class="input-large" onchange="GenerarGraficaGeneral(); GraficaReclutadorSupervisor(1);"> 
           <?php
             for ($i=0; $i<count($catalogoLineaNegocio); $i++){
                  echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
             }  
           ?>
        </select><br><br>
         <select name="selectMesReclutador " id="selectMesReclutador">
            <option value="1">ENERO</option>
            <option value="2">FEBRERO</option>
            <option value="3">MARZO</option>
            <option value="4">ABRIL</option>
            <option value="5">MAYO</option>
            <option value="6">JUNIO</option>
            <option value="7">JULIO</option>
            <option value="8">AGOSTO</option>
            <option value="9">SEPTIEMBRE</option>
            <option value="10">OCTUBRE</option>
            <option value="11">NOVIEMBRE</option>
            <option value="12">DICIEMBRE</option>
         </select>
      </center><br><br>
        <div id="reportPage">
          <table  align="center">
             <tr>
                <td>
                    <div class="chart-container" style="width:57vw">
                         <div id="GraficaGRAL" name="GraficaGRAL"></div> 
                    </div>
                </td>
                <td>
                    <div class="chart-container" style="width:25vw">
                         <div id="GraficaGRALI" name="GraficaGRALI"></div>                            
                    </div>
                    <div class="chart-container" style="width:30vw">
                         <div id="GraficaIndiceRotacion" name="GraficaIndiceRotacion"></div>                            
                    </div>
                </td> 
             </tr>           
          </table>
        </div>
      <br>
    <center>
        <select name="slectTipoR" id="slectTipoR">
            <option value="1">RECLUTADORES</option>
            <option value="2">SUPERVISORES</option>
        </select> <br>

        <select id="seleccionarEntidadReclutadorSup" name="seleccionarEntidadReclutadorSup" class="input-large"> 
            <option value="0">ENTIDAD</option>
           <?php
             for ($i=0; $i<count($catalogoEntidadesFederativasALaborar); $i++){
                  echo "<option value='". $catalogoEntidadesFederativasALaborar[$i]["idEntidadFederativa"]."'>". $catalogoEntidadesFederativasALaborar[$i]["nombreEntidadFederativa"] ." </option>";
             }  
           ?>
          </select> <br>
       
          <button class="btn btn-primary" onclick="Grafica15mejores(1)">15 Mejores</button>
          <button id="btnGeneral" class="btn btn-primary">General</button>
          <button class="btn btn-primary" onclick="Grafica15mejores(2)">15 Peores</button>
    </center>

   <h1 align="center">Productividad por reclutador</h1>
        <div class="col-lg" style="display: none;" id="DivGraficaSupervisor" name="DivGraficaSupervisor">         
               <div id="DivGrafSup" name="DivGrafSup" style="width: 100%;height: 100px;"></div> 
        </div>
        <div class="col-lg" style="display: none;" id="DivGraficaReclutador" name="DivGraficaReclutador">         
             <div id="DivGrafReclu" name="DivGrafReclu" style="width: 100%;height: 100px;"></div>    
        </div>
    <!--<link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="../../Vista/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    <script src="Chart.min.js"></script>
</body>
</div><!--termina sin gif-->
</html>
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> DESCARGAR PUSE EL 2.1.1.JS-->
<script >
$(inicioReporteGraf());  

var f=new Date();
var mes=f.getMonth()+1;
var anio=f.getFullYear();

$("#radioNo").click(function() {
  $("#divNota").show();
  $("#radioSí").prop("checked", false);  
  $("#divConCorporativoGif").show();
  $("#divSinCorporativoGif").hide();
});

$("#radioSí").click(function() {
  $("#divNota").hide();
  $("#radioNo").prop("checked", false);  
  $("#divSinCorporativoGif").show();
  $("#divConCorporativoGif").hide();
});


function inicioReporteGraf(){
    $("#selectMesReclutador > option[value='"+mes+"'").attr('selected', 'selected');    
    $("#selectMesGif > option[value='"+mes+"'").attr('selected', 'selected');    
    GenerarGraficaGeneral();
    GraficaReclutadorSupervisor(1);
    entidadesGif(0);
    $("#btnbusquedaGifmes").show();
}

$("#btnGeneral").click(function() {

  var seleccionarEntidadReclutadorSup =$("#seleccionarEntidadReclutadorSup").val();

  if (seleccionarEntidadReclutadorSup=='0') {

       $("#seleccionarEntidadReclutadorSup").val("0");
        GraficaReclutadorSupervisor(1);
        GenerarGraficaGeneral();
    }else{
          GraficaReclutadorSupervisor(2);

    }
});

$("#selectMesReclutador").change(function() {

  $("#seleccionarEntidadReclutadorSup").val("0");
   GenerarGraficaGeneral(); 
   GraficaReclutadorSupervisor(1);
});


$("#slectTipoR").change(function() {

  $("#seleccionarEntidadReclutadorSup").val("0");
   GenerarGraficaGeneral(); 
   GraficaReclutadorSupervisor(1);
});

$("#checkMermaIncapacidad").click(function() {
  entidadesGif(1);

  if($('#checkMermaIncapacidad').is(":checked")) {
  $("#divGIFContenedorsinMerma").hide();
  $("#divGIFMerma").show();


}else{
  $("#divGIFMerma").hide();
  $("#divGIFContenedorsinMerma").show();
}
});

$("#selectMesGif").change(function() {
  $("#seleccionarPSGif").hide();
  $("#btnbusquedaGifmes").show();
  $("#btnbusquedaGifPS").hide();
  $("#btnbusquedaGifEntidad").hide();
  $("#seleccionarEntidadGif").val("0");
  $("#seleccionarPSGif").val("0");

});

$("#seleccionarEntidadGif").change(function(){
  var entidadele = $("#seleccionarEntidadGif").val();

  if (entidadele=="0"){
      $("#btnbusquedaGifEntidad").hide();
      $("#btnbusquedaGifmes").show();
  }
    else{
         $("#seleccionarPSGif").show();
         $("#btnbusquedaGifmes").hide();
         $("#btnbusquedaGifPS").hide();
         $("#btnbusquedaGifEntidad").show();
         $("#seleccionarPSGif").val("0");

         var entidadElegidaGif = $("#seleccionarEntidadGif").val();
         $.ajax({
                 type: "POST",
                 url: "ajax_PuntoServicioGifxEnt.php",
                 data:{"entidadElegidaGif":entidadElegidaGif},
                 dataType: "json",
                 success:function(response) {
                         $("#seleccionarPSGif").empty();  
                         $('#seleccionarPSGif').append('<option value="0">Punto de servicio</option>');
                          if(response.status == "success"){
                             for (var i = 0; i < response.datos.length; i++){
                                  $('#seleccionarPSGif').append('<option value="' + (response.datos[i].idPuntoServicio) + '">' + response.datos[i].puntoServicio + '</option>');
                             }
                          }else{
                                alert("Error al cargar Entidades");
                               }
                 },
                 error: function(jqXHR, textStatus, errorThrown){
                                 alert(jqXHR.responseText);
                                }
         });
    }
});

$("#selectMesMerma").change(function() {
  $("#seleccionarPSGifMerma").hide();
  $("#btnbusquedaGifmesMerma").show();
  $("#btnbusquedaGifPSMerma").hide();
  $("#btnbusquedaGifEntidadMerma").hide();
  $("#seleccionarEntidadGifMerma").val("0");
  $("#seleccionarPSGifMerma").val("0");
});

$("#seleccionarEntidadReclutadorSup").change(function() {
    GraficaReclutadorSupervisor(2);
});

$("#seleccionarEntidadGifMerma").change(function(){
  var entidadele = $("#seleccionarEntidadGifMerma").val();

  if (entidadele=="0"){
      $("#btnbusquedaGifEntidadMerma").hide();
      $("#btnbusquedaGifmesMerma").show();
  }
    else{
         $("#seleccionarPSGifMerma").show();
         $("#btnbusquedaGifmesMerma").hide();
         $("#btnbusquedaGifPSMerma").hide();
         $("#btnbusquedaGifEntidadMerma").show();
         $("#seleccionarPSGifMerma").val("0");

         var entidadElegidaGif = $("#seleccionarEntidadGifMerma").val();
         $.ajax({
                 type: "POST",
                 url: "ajax_PuntoServicioGifxEntMerma.php",
                 data:{"entidadElegidaGif":entidadElegidaGif},
                 dataType: "json",
                 success:function(response) {
                         $("#seleccionarPSGifMerma").empty();  
                         $('#seleccionarPSGifMerma').append('<option value="0">Punto de servicio</option>');
                          if(response.status == "success"){
                             for (var i = 0; i < response.datos.length; i++){
                                  $('#seleccionarPSGifMerma').append('<option value="' + (response.datos[i].idPuntoServicio) + '">' + response.datos[i].puntoServicio + '</option>');
                             }
                          }else{
                                alert("Error al cargar Entidades");
                               }
                 },
                 error: function(jqXHR, textStatus, errorThrown){
                                 alert(jqXHR.responseText);
                                }
         });
    }
});

$("#seleccionarPSGif").change(function(){
var Pserv = $("#seleccionarPSGif").val();

 if(Pserv=='0'){
   $("#btnbusquedaGifEntidad").show();
   $("#btnbusquedaGifPS").hide();

 }else{
     $("#btnbusquedaGifPS").show();
     $("#btnbusquedaGifEntidad").hide();
     }
});

$("#seleccionarPSGifMerma").change(function(){
var Pserv = $("#seleccionarPSGifMerma").val();

 if(Pserv=='0'){
   $("#btnbusquedaGifEntidadMerma").show();
   $("#btnbusquedaGifPSMerma").hide();

 }else{
     $("#btnbusquedaGifPSMerma").show();
     $("#btnbusquedaGifEntidadMerma").hide();
     }
});

/*function entidadesRecSup(merma){
  $.ajax({
          type: "POST",
          url: "ajax_EntidadesReclutadorSupervisor.php",
          dataType: "json",
          success:function(response) {
                  $("#seleccionarEntidadGif").empty();  
                  $('#seleccionarEntidadGif').append('<option value="0">ENTIDAD</option>');
                    if(response.status == "success"){
                       for (var i = 0; i < response.datos.length; i++){
                            $('#seleccionarEntidadGif').append('<option value="' + (response.datos[i].idEntidadPunto) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                       }
                    }else{
                  alert("Error al cargar Entidades");
                     }
          },
           error: function(jqXHR, textStatus, errorThrown){
                           alert(jqXHR.responseText);
           }
  });
}*/

function entidadesGif(merma){
if (merma=='0') {
  $.ajax({
          type: "POST",
          url: "ajax_EntidadesPuntoServicioGif.php",
          data:{"merma":merma},
          dataType: "json",
          success:function(response) {
                  $("#seleccionarEntidadGif").empty();  
                  $('#seleccionarEntidadGif').append('<option value="0">ENTIDAD</option>');
                    if(response.status == "success"){
                       for (var i = 0; i < response.datos.length; i++){
                            $('#seleccionarEntidadGif').append('<option value="' + (response.datos[i].idEntidadPunto) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                       }
                    }else{
                  alert("Error al cargar Entidades");
                     }
          },
           error: function(jqXHR, textStatus, errorThrown){
                           alert(jqXHR.responseText);
                  }
  });
}

else{
  $.ajax({
          type: "POST",
          url: "ajax_EntidadesPuntoServicioGif.php",
          data:{"merma":merma},
          dataType: "json",
          success:function(response) {
                  $("#seleccionarEntidadGifMerma").empty();  
                  $('#seleccionarEntidadGifMerma').append('<option value="0">ENTIDAD</option>');
                    if(response.status == "success"){
                       for (var i = 0; i < response.datos.length; i++){
                            $('#seleccionarEntidadGifMerma').append('<option value="' + (response.datos[i].idEntidadPunto) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                       }
                    }else{
                  alert("Error al cargar Entidades");
                     }
          },
           error: function(jqXHR, textStatus, errorThrown){
                           alert(jqXHR.responseText);
                  }
  });

}
}

//inicia lo de gif

function BuscarElementosGif(){

  var entidadGif = $("#seleccionarEntidadGif").val();
  var pservicioGif = $("#seleccionarPSGif").val(); //poner lo del punto de servicio
  var month=$("#selectMesGif").val();
  var lineaNegocio=$("#seleccionarLineaNegocioGif").val();

    var canvasgif = "<canvas id='canvasGraficaGralGif' name='canvasGraficaGralGif'></canvas>";
    $('#DivGrafGif').html(canvasgif);
 
    if (entidadGif =='0'){ //buscar normal
        var opcion='0';
        }
  
    if(entidadGif != '0' && pservicioGif =='0'){//buscar con entidad
      var opcion='1';
       }

       if(entidadGif != '0' && pservicioGif !='0'){//buscar con entidad
      var opcion='2';
       }

    $.ajax({
        type: "POST",
        url: "ajax_ObtenerPlantillasSoloGif.php",
        data:{month:month, anio:anio, "lineaNegocio":lineaNegocio,"opcion":opcion,"entidadGif":entidadGif,"pservicioGif":pservicioGif},
        dataType: "json",
        success: function(response) {
                var numElementosGif=response.numElementosGifSologif.numElementosGif;
                var ctxGif = document.getElementById("canvasGraficaGralGif"); 
                var myChart = new Chart(ctxGif, {
                type: 'bar',
                data:{
                      labels:['Plantilla Gif'],
                        datasets:[{
                                label:'Grafica general de elementos ',
                                data:[numElementosGif],
                                backgroundColor:['rgba(2, 2, 185, 0.2)'], 
                                borderColor:['rgba(2, 2, 185, 0.2)'],
                                borderWidth: 1
                        }]
                     },
                options:{
                  scales: {
                    yAxes: [{
                      ticks:{beginAtZero: true}
                    }]
                  }
                }
            });
          }
    });
}

function BuscarElementosGifMerma(){


  $("#divGIFMerma").show();

  var entidadGif = $("#seleccionarEntidadGifMerma").val();
  var pservicioGif = $("#seleccionarPSGifMerma").val(); //poner lo del punto de servicio
  var month=$("#selectMesMerma").val();
  var lineaNegocio=$("#seleccionarLineaNegocioGifMerma").val();

    var canvasgifMerma = "<canvas id='canvasGraficaGralGifMerma' name='canvasGraficaGralGifMerma'></canvas>";
    $('#DivGrafGifMerma').html(canvasgifMerma);
 
    if (entidadGif =='0'){ //buscar normal
        var opcion='0';
        }
  
    if(entidadGif != '0' && pservicioGif =='0'){//buscar con entidad
      var opcion='1';
       }

       if(entidadGif != '0' && pservicioGif !='0'){//buscar con entidad
      var opcion='2';
       }

    $.ajax({
        type: "POST",
        url: "ajax_ObtenerPlantillasSoloGifMerma.php",
        data:{month:month, anio:anio, "lineaNegocio":lineaNegocio,"opcion":opcion,"entidadGif":entidadGif,"pservicioGif":pservicioGif},
        dataType: "json",
        success: function(response) {
                var numElementosGif=response.numElementosGifSologif.numElementosGif;
                var ctxGif = document.getElementById("canvasGraficaGralGifMerma"); 
                var myChart = new Chart(ctxGif, {
                type: 'bar',
                data:{
                      labels:['Plantilla Gif'],
                        datasets:[{
                                label:'Grafica general de elementos ',
                                data:[numElementosGif],
                                backgroundColor:['rgba(2, 2, 185, 0.2)'], 
                                borderColor:['rgba(2, 2, 185, 0.2)'],
                                borderWidth: 1
                        }]
                     },
                options:{
                  scales: {
                    yAxes: [{
                      ticks:{beginAtZero: true}
                    }]
                  }
                }
            });
          }
    });
}

function GenerarGraficaGeneral() { 

    var month=$("#selectMesReclutador").val();
    var tipo=$("#slectTipoR").val();
    var lineaNegocio=$("#seleccionarLineaNegocio").val();
    var TextoLinea=document.getElementById("seleccionarLineaNegocio").selectedIndex;
    var TextoLinea1=document.getElementById("seleccionarLineaNegocio").options[TextoLinea].text;

    var titulo = "<h1>GRAFICA GENERAL DE "+TextoLinea1+" </h1>";
    $("#divTitulo").html(titulo);

    if(tipo=="2"){
       var canvas = "<canvas id='GraficaGralXSupervisor"+ month +"' name='GraficaGralXSupervisor"+ month +"'></canvas>";
       $('#GraficaGRAL').html(canvas); 

       var canvas1 = "<canvas id='GraficaGralXSupervisorPie"+ month +"' name='GraficaGralXSupervisorPie"+ month +"'></canvas>";
       $('#GraficaGRALI').html(canvas1);

       var canvas2 = "<canvas id='GraficaIndiceRSupervisor"+ month +"' name='GraficaIndiceRSupervisor"+ month +"'></canvas>";
       $('#GraficaIndiceRotacion').html(canvas2);

    }else{
       var canvas = "<canvas id='GraficaGralXReclutado"+ month +"' name='GraficaGralXReclutado"+ month +"'></canvas>";
       $("#GraficaGRAL").html(canvas);

       var canvas1 = "<canvas id='GraficaGralXReclutadoPie"+ month +"' name='GraficaGralXReclutadoPie"+ month +"'></canvas>";
       $("#GraficaGRALI").html(canvas1);

       var canvas2 = "<canvas id='GraficaIndiceRreclutador"+ month +"' name='GraficaIndiceRreclutador"+ month +"'></canvas>";
       $("#GraficaIndiceRotacion").html(canvas2);
    }
  
    var month=$("#selectMesReclutador").val();
    $.ajax({
        type: "POST",
        url: "ajax_ObtenerAltasXmes.php",
        data:{month:month, anio:anio, "lineaNegocio":lineaNegocio},
        dataType: "json",
        success: function(response) {
         var altasMes = response.altasMes.altasMes;
         var bajasMes = response.bajasMes.bajasMes;
         var numElementosGif=response.numElementosGif.numElementosGif;
         var elementosVentas=response.elementosVentas.elementosVentas;
        
         var indiceRotacioncalculo=((altasMes-bajasMes)/numElementosGif)*100;
         var indiceCoberturaCalculo=((altasMes-bajasMes)/elementosVentas)*100;

         var indiceRotacion = indiceRotacioncalculo.toFixed(2); 
         var indiceCobertura = indiceCoberturaCalculo.toFixed(2);

		 var operacionGifentreVentas=(numElementosGif/elementosVentas)*100;//grafica gif / ventas
         var porcentajeGifentreVentas= operacionGifentreVentas.toFixed(0);
		 
         var indiceRotacionAltasBajas=(bajasMes/altasMes)*100;
         var indiceRotacionAltasBajasGrafica= indiceRotacionAltasBajas.toFixed(0); 

          if(tipo=="2"){
            var ctx = document.getElementById("GraficaGralXSupervisor"+month); 
            var ctx1= document.getElementById("GraficaGralXSupervisorPie"+month);   
            var ctx2= document.getElementById("GraficaIndiceRSupervisor"+month);   
           }else{
            var ctx = document.getElementById("GraficaGralXReclutado"+month);
            var ctx1= document.getElementById("GraficaGralXReclutadoPie"+month);  
            var ctx2 = document.getElementById("GraficaIndiceRreclutador"+month);

           }
            var myChart = new Chart(ctx, {
                type: 'bar',
                data:{
                labels:  ['altasMes', 'bajasMes', 'Plantilla Gif', 'Plantilla Ventas'],
                datasets:[{
                label:  'Grafica general de elementos ',
                data: [altasMes,bajasMes,numElementosGif,elementosVentas],
                backgroundColor:[
                'rgba(52, 219, 67 , 0.5)',
                'rgba(185, 2, 2, 0.5)',
                'rgba(2, 147, 185, 0.5)',                
                'rgba(2, 2, 185, 0.5)'], 
                 borderColor:[
                'rgba(52, 219, 67 , 0.5)',
                'rgba(185, 2, 2, 0.5)',
                'rgba(2, 147, 185, 0.5)',                
                'rgba(2, 2, 185, 0.5)'],
                      borderWidth: 1
                      }]
                 },
                  options: {
                   scales: {
                     yAxes: [{
                      ticks: {
                              }
                          }]
                      }
                  }
            });


         /*   var myChart1 = new Chart(ctx1, {
                type: 'pie',
                data:{
                labels:  ['Índice de rotación %', 'Faltante Plantilla Cobertura '],
                datasets:[{
                //label:   ['Índice de rotación', 'Índice de cobertura'],
                data: [indiceRotacion, indiceCobertura],
                backgroundColor:[
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'], 
                 borderColor:[
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'],
                      borderWidth: 1
                      }]
                 },
                  options: {
                    scales: {
                     yAxes: [{
                      ticks: {
                              beginAtZero: true
                              }
                          }]
                      }
                  }
            });*/ 
			
			var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data:{
                labels:  ['Plantilla Gif / Plantilla Ventas'],
                datasets:[{
                label:  'Plantilla Gif / Plantilla Ventas',
                data: [porcentajeGifentreVentas],
                backgroundColor:[
                'rgba(254, 53, 25, 0.5)'], 
                 borderColor:[
                'rgba(254, 53, 25, 0.5)'],
                      borderWidth: 1
                      }]
                 },
                  options: {
                   scales: {
                     yAxes: [{
                      ticks: {
                        min: 0,
                        max: 500,
                        callback: function(value) {
                        return value + "%"
                        }
                              }
                          }]
                      }
                  }
            });
			

            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data:{
                labels:  ['Bajas del mes/Altas del mes'],
                datasets:[{
                label:  'Indice de Rotación(Bajas/Altas del mes)',
                data: [indiceRotacionAltasBajasGrafica],
                backgroundColor:[
                'rgba(52, 219, 67 , 1)'], 
                 borderColor:[
                'rgba(52, 219, 67 , 1)'],
                      borderWidth: 1
                      }]
                 },
                  options: {
                   scales: {
                     yAxes: [{
                      ticks: {
                        min: 0,
                        max: 500,
                        callback: function(value) {
                        return value + "%"
                        }
                              }
                          }]
                      }
                  }
            });

        }
    });
}



function Grafica15mejores(boton){
var idM =  boton;
var month=$("#selectMesReclutador").val();
var tipo=$("#slectTipoR").val();
var selectEntidad=$("#seleccionarEntidadReclutadorSup").val();
     //alert(selectEntidad);
     if(tipo=="2"){
       var canvas = "<canvas id='GraficaXSupervisor"+ month +"' name='GraficaXSupervisor2"+ month +"'></canvas>";
       $('#DivGrafSup').html(canvas); 
       }else{
       var canvas = "<canvas id='GraficaXReclutado"+ month +"' name='GraficaXReclutado"+ month +"'></canvas>";
       $("#DivGrafReclu").html(canvas);
       }

      if (selectEntidad=="0") {

        $.ajax({
        type: "POST",
        url: "ajax_ElementosXReclutadorSupervisor.php",
        data:{"month":month,"tipo":tipo},
        dataType: "json",
        success: function(response) {

         var nombres = [];
         var elementosACT = [];
         var elementosINACT = [];
         var elementosReclutados = [];
         var datosGrafica= response.data;
         
         if(datosGrafica.length > 15){
            var datosGrafica15 = 15;
         }else{
            var datosGrafica15 = datosGrafica.length;
         }
         if(datosGrafica.length > 15){
            var largoNombresMenos15= datosGrafica.length - 15;
         }else{
            var largoNombresMenos15=0;
         }
     
        if (idM==1) {
         for (var i = 0; i < datosGrafica15; i++) {
              nombres.push(datosGrafica[i]["nombreempleadoreclutador"]);
              elementosReclutados.push(datosGrafica[i]["conteo"]);         
              elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
              elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
        }else {
              for(var i = largoNombresMenos15; i < datosGrafica.length; i++) {
                  nombres.push(datosGrafica[i]["nombreempleadoreclutador"]);
                  elementosReclutados.push(datosGrafica[i]["conteo"]);         
                  elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
                  elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
     }
           if(tipo=="2"){
            var graficaCanvas = document.getElementById("GraficaXSupervisor"+month); 
            $("#DivGraficaSupervisor").show();
            $("#DivGraficaReclutador").hide();  
           }else{
            
             var graficaCanvas = document.getElementById("GraficaXReclutado"+month);
             $("#DivGraficaSupervisor").hide();
             $("#DivGraficaReclutador").show();
             
           }
             Chart.defaults.global.defaultFontFamily = "Lato";
             Chart.defaults.global.defaultFontSize = 18;
             
             var totalreclutados = {
                 label: 'Elementos Reclutados',
                 data: elementosReclutados,
                 backgroundColor: 'rgba(52, 152, 219, 1)',         
                 yAxisID: "barElementosReclutados"
             };

             var totalactivos = {
                 label: 'Elementos Activos',
                 data: elementosACT,
                 backgroundColor: 'rgba(46, 204, 113, 1)',          
                 yAxisID: "barElementosReclutados"
             };

             var totalinactivos = {
                 label: 'Elementos Inactivos',
                 data: elementosINACT,
                 backgroundColor: 'rgba(231, 76, 60, 1)',
                 yAxisID: "barElementosReclutados"
             };      
             
             var datoselementos = {
                 labels: nombres,
                 datasets: [totalreclutados, totalinactivos, totalactivos]
             };            
             
             var chartOptions = {
                  scales: {                  
                     yAxes: [{id: "barElementosReclutados"},
                             {id: "barElementosReclutados"},
                             {id: "barElementosReclutados"}]
                  }
                 };          

             var barChart = new Chart(graficaCanvas, {
               type: 'bar',
               data: datoselementos,
               options: chartOptions
             });          
        }
    }); 

  }else{

    $.ajax({
        type: "POST",
        url: "ajax_15MejoresPeoresXEntidad.php",
        data:{"month":month,"tipo":tipo,"selectEntidad":selectEntidad},
        dataType: "json",
        success: function(response) {

         var nombres = [];
         var elementosACT = [];
         var elementosINACT = [];
         var elementosReclutados = [];
         var datosGrafica= response.data;
         
         if(datosGrafica.length > 15){
            var datosGrafica15 = 15;
         }else{
            var datosGrafica15 = datosGrafica.length;
         }
         if(datosGrafica.length > 15){
            var largoNombresMenos15= datosGrafica.length - 15;
         }else{
            var largoNombresMenos15=0;
         }
     
        if (idM==1) {
         for (var i = 0; i < datosGrafica15; i++) {
              nombres.push(datosGrafica[i]["nombreempleadoreclutador"]);
              elementosReclutados.push(datosGrafica[i]["conteo"]);         
              elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
              elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
        }else {
              for(var i = largoNombresMenos15; i < datosGrafica.length; i++) {
                  nombres.push(datosGrafica[i]["nombreempleadoreclutador"]);
                  elementosReclutados.push(datosGrafica[i]["conteo"]);         
                  elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
                  elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
     }
           if(tipo=="2"){
            var graficaCanvas = document.getElementById("GraficaXSupervisor"+month); 
            $("#DivGraficaSupervisor").show();
            $("#DivGraficaReclutador").hide();  
           }else{
            
             var graficaCanvas = document.getElementById("GraficaXReclutado"+month);
             $("#DivGraficaSupervisor").hide();
             $("#DivGraficaReclutador").show();
             
           }
             Chart.defaults.global.defaultFontFamily = "Lato";
             Chart.defaults.global.defaultFontSize = 18;
             
             var totalreclutados = {
                 label: 'Elementos Reclutados',
                 data: elementosReclutados,
                 backgroundColor: 'rgba(52, 152, 219, 1)',         
                 yAxisID: "barElementosReclutados"
             };

             var totalactivos = {
                 label: 'Elementos Activos',
                 data: elementosACT,
                 backgroundColor: 'rgba(46, 204, 113, 1)',          
                 yAxisID: "barElementosReclutados"
             };

             var totalinactivos = {
                 label: 'Elementos Inactivos',
                 data: elementosINACT,
                 backgroundColor: 'rgba(231, 76, 60, 1)',
                 yAxisID: "barElementosReclutados"
             };      
             
             var datoselementos = {
                 labels: nombres,
                 datasets: [totalreclutados, totalinactivos, totalactivos]
             };            
             
             var chartOptions = {
                  scales: {                  
                     yAxes: [{id: "barElementosReclutados"},
                             {id: "barElementosReclutados"},
                             {id: "barElementosReclutados"}]
                  }
                 };          

             var barChart = new Chart(graficaCanvas, {
               type: 'bar',
               data: datoselementos,
               options: chartOptions
             });          
        }
    });



  }    
}

function GraficaReclutadorSupervisor(opcion){

var opcion =opcion;
var month=$("#selectMesReclutador").val();
var tipo=$("#slectTipoR").val();
var entidadTrabajoRS=$("#seleccionarEntidadReclutadorSup").val();


       if(tipo=="2"){
       var canvas = "<canvas id='GraficaXSupervisor"+ month +"' name='GraficaXSupervisor2"+ month +"'></canvas>";
       $('#DivGrafSup').html(canvas); 
       }else{
       var canvas = "<canvas id='GraficaXReclutado"+ month +"' name='GraficaXReclutado"+ month +"'></canvas>";
       $("#DivGrafReclu").html(canvas);
       }

    if (opcion=="1") {     

        $.ajax({
        type: "POST",
        url: "ajax_GraficaCompletaElementosReclutados.php",
        data:{"month":month,"tipo":tipo},
        dataType: "json",
        success: function(response) {

         var nombres = [];
         var nombres1 = [];
         var elementosACT = [];
         var elementosINACT = [];
         var elementosReclutados = [];
         var datosGrafica= response.data;
         for (var i = 0; i < datosGrafica.length; i++) {
              nombres1.push(datosGrafica[i]["nombreEmpleado"]);
              nombres.push(datosGrafica[i]["numeroEmpleado"]);
              elementosReclutados.push(datosGrafica[i]["numeroElementosReclutados"]);         
              elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
              elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
           if(tipo=="2"){
            var graficaCanvas = document.getElementById("GraficaXSupervisor"+month); 
            $("#DivGraficaSupervisor").show();
            $("#DivGraficaReclutador").hide();  
           }else{
            
             var graficaCanvas = document.getElementById("GraficaXReclutado"+month);
             $("#DivGraficaSupervisor").hide();
             $("#DivGraficaReclutador").show();
             
           }
             Chart.defaults.global.defaultFontFamily = "Lato";
             Chart.defaults.global.defaultFontSize = 12;
            
             
             var totalreclutados = {
                 label: ' Elementos Reclutados',
                 data: elementosReclutados ,
                 backgroundColor: 'rgba(52, 152, 219, 1)',         
                 xAxisID: "barElementosReclutados"
             };

             var totalactivos = {
                 label: 'Elementos Activos',
                 data: elementosACT,
                 backgroundColor: 'rgba(46, 204, 113, 1)',          
                 xAxisID: "barElementosReclutados"
             };

             var totalinactivos = {
                 label: 'Elementos Inactivos',
                 data: elementosINACT,
                 backgroundColor: 'rgba(231, 76, 60, 1)',
                 xAxisID: "barElementosReclutados"
             };      
             
             var datoselementos = {
                 labels: nombres1 ,
                 datasets: [totalreclutados, totalinactivos, totalactivos]
             };            
             
             var chartOptions = {
                  scales: {                  
                     xAxes: [{id: "barElementosReclutados"}]
                  }
                 };          
          
             var barChart = new Chart(graficaCanvas, {
               type: 'bar',//horizontalBar
               data: datoselementos,
               options: chartOptions,
             });     
        }
    });   
  } 

else{

if(tipo=="2"){

       var canvas = "<canvas id='GraficaXSupervisor"+ month +"' name='GraficaXSupervisor2"+ month +"'></canvas>";
       $('#DivGrafSup').html(canvas); 
       }else{
       var canvas = "<canvas id='GraficaXReclutado"+ month +"' name='GraficaXReclutado"+ month +"'></canvas>";
       $("#DivGrafReclu").html(canvas);
       }
        $.ajax({
        type: "POST",
        url: "ajax_GraficaElementosReclutadosEntidad.php",
        data:{"month":month,"tipo":tipo,"entidadTrabajoRS":entidadTrabajoRS},
        dataType: "json",
        success: function(response) {

         var nombres = [];
         var elementosACT = [];
         var elementosINACT = [];
         var elementosReclutados = [];
         var datosGrafica= response.data;
         for (var i = 0; i < datosGrafica.length; i++) {
              nombres.push(datosGrafica[i]["nombreEmpleado"]);
              elementosReclutados.push(datosGrafica[i]["numeroElementosReclutados"]);         
              elementosACT.push(datosGrafica[i]["numeroElementosActivos"]);
              elementosINACT.push(datosGrafica[i]["numeroElementosInactivos"]); 
         }
           if(tipo=="2"){
            var graficaCanvas = document.getElementById("GraficaXSupervisor"+month); 
            $("#DivGraficaSupervisor").show();
            $("#DivGraficaReclutador").hide();  
           }else{
            
             var graficaCanvas = document.getElementById("GraficaXReclutado"+month);
             $("#DivGraficaSupervisor").hide();
             $("#DivGraficaReclutador").show();
             
           }
             Chart.defaults.global.defaultFontFamily = "Lato";
             Chart.defaults.global.defaultFontSize = 18;
             
             var totalreclutados = {
                 label: 'Elementos Reclutados',
                 data: elementosReclutados,
                 backgroundColor: 'rgba(52, 152, 219, 1)',         
                 yAxisID: "barElementosReclutados"
             };

             var totalactivos = {
                 label: 'Elementos Activos',
                 data: elementosACT,
                 backgroundColor: 'rgba(46, 204, 113, 1)',          
                 yAxisID: "barElementosReclutados"
             };

             var totalinactivos = {
                 label: 'Elementos Inactivos',
                 data: elementosINACT,
                 backgroundColor: 'rgba(231, 76, 60, 1)',
                 yAxisID: "barElementosReclutados"
             };      
             
             var datoselementos = {
                 labels: nombres,
                 datasets: [totalreclutados, totalinactivos, totalactivos]
             };            
             
             var chartOptions = {
                  scales: {                  
                     yAxes: [{id: "barElementosReclutados"}]
                  }
                 };          

             var barChart = new Chart(graficaCanvas, {
               type: 'bar',
               data: datoselementos,
               options: chartOptions
             });     
        }
    });   
  } 

} 


 </script>
