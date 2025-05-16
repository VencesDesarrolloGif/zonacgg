<center> 
  <br>
   <div class="col-lg-12" style="font-size:50px;">Cobertura</div>
</center>
<br>
<center>
  <br>
  <div id="DivLineaNegocio">
    <select id="seleccionarLineNegocio1a" name="seleccionarLineNegocio1a"></select><br>
  </div>
  <div id="DivSeleccionarSup" style="display: none;">
    <select name="seleccionarSupervisorPlantillaSup" id="seleccionarSupervisorPlantillaSup"></select>   
  </div>

<select id="MesConsultaSup" name="periodoSup" class="input-large" style="display: none;">
  <option value="0">PERIODO</option>
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
<select id="anioConsultaSup" name="anioConsultaSup" style="display: none;">
 <option value="0" selected>EJERCICIO</option>
 <?php $year = date("Y");
 for($i=$year; $i>=2020; $i--){
     echo '<option value="'.$i.'">'.$i.'</option>';
    }
?>
</select>
</center>

<center>
<form class="form-horizontal" id="form_tablaGeneralSup" name="form_tablaGeneralSup" action="ficheroExportPlantillaSupervisor.php" target="_blank" method="post">
    <input type="hidden" id="datos_Tablas" name="datos_Tablas" />
    <div class="container top-buffer-submenu vertical-buffer">
        <div id="tablaDinamicaEntidadesSup"></div>
    </div>
    <button id="descargaTablaGeneralPlantillaSup" name="descargaTablaGeneralPlantillaSup" class="btn btn-success" type="button" style="display:none;"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
</form>
</center>
<script type="text/javascript">

$(document).ready(function() {
  obtenerLineasNegocio();
});//termina ready

function obtenerLineasNegocio(){
 $.ajax({
          type: "POST",
          url: "ajax_obtenerLineasdeNegocio.php",
          dataType: "json",
          success: function(response) {
            $("#seleccionarLineNegocio1a").empty();  
            $('#seleccionarLineNegocio1a').append('<option value="0">LINEA DE NEGOCIO</option>');
              if(response.status == "success"){
                //console.log(response);
                for (var i = 0; i < response.valor.length; i++){
                    $('#seleccionarLineNegocio1a').append('<option value="'+(response.valor[i].idLineaNegocio)+'">'+response.valor[i].descripcionLineaNegocio+'</option>');
                  }
              }else{
                alert("Error al cargar Linea de Negocio");
              }
          },
            error: function(jqXHR, textStatus, errorThrown){
                   alert(jqXHR.responseText);
            }
  });

}

$("#seleccionarLineNegocio1a").change(function(){

  var LineaNegocioElegida = $("#seleccionarLineNegocio1a").val();
  if (LineaNegocioElegida =='0') {
      $("#DivSeleccionarSup").hide();
      $("#seleccionarSupervisorPlantillaSup").val(0);
      $("#MesConsultaSup").hide();
      $("#MesConsultaSup").val(0);
      $("#anioConsultaSup").hide();
      $("#anioConsultaSup").val(0);
      $('#tablaDinamicaEntidadesSup').html(""); 
      $("#descargaTablaGeneralPlantillaSup").hide();
      $('#tablaDinamicaPS').html("");
    } 
    else{
        $("#DivSeleccionarSup").show();
        $("#seleccionarSupervisorPlantillaSup").val(0);
        $("#MesConsultaSup").hide();
        $("#MesConsultaSup").val(0);
        $("#anioConsultaSup").hide();
        $("#anioConsultaSup").val(0);
        $('#tablaDinamicaEntidadesSup').html("");
        $("#descargaTablaGeneralPlantillaSup").hide();
        $('#tablaDinamicaPS').html("");

  $.ajax({
          type: "POST",
          url: "ajax_obtenerSupervisoresXLineaNegocioPlantilla.php",
          data: {"LineaNegocioElegida": LineaNegocioElegida},
          dataType: "json",
          success: function(response) {
            $("#seleccionarSupervisorPlantillaSup").empty();  
            $('#seleccionarSupervisorPlantillaSup').append('<option value="0">SUPERVISOR</option>');
            if(response.status == "success"){
               for(var i = 0; i < response.datos.length; i++){
                   $('#seleccionarSupervisorPlantillaSup').append('<option value="' + (response.datos[i].NumEmpSupervisor) + '">' + response.datos[i].Nombre + '</option>');
                  }
               $("#DivSeleccionarSup").show();
            }else{
                  alert("Error al cargar Entidades");
                  $("#DivSeleccionarSup").hide();
                 }
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
            $("#DivSeleccionarSup").hide();
          }
     });
  }
});

$("#seleccionarSupervisorPlantillaSup").change(function(){
    var supervisor =$("#seleccionarSupervisorPlantillaSup").val();
    if (supervisor =='0'){
        $("#MesConsultaSup").hide();
        $("#MesConsultaSup").val(0);
        $("#anioConsultaSup").hide();
        $("#anioConsultaSup").val(0);
        $('#tablaDinamicaEntidadesSup').html("");
        $("#descargaTablaGeneralPlantillaSup").hide();
        $('#tablaDinamicaPS').html("");
    }else{
          $("#MesConsultaSup").show();
          $("#MesConsultaSup").val(0);
          $("#anioConsultaSup").hide();
          $("#anioConsultaSup").val(0);
          $('#tablaDinamicaEntidadesSup').html("");
          $("#descargaTablaGeneralPlantillaSup").hide();
          $('#tablaDinamicaPS').html("");
         }
});

$("#MesConsultaSup").change(function(){
   var mes =$("#MesConsultaSup").val();
    if(mes =='0') {
       $("#anioConsultaSup").hide();
       $("#anioConsultaSup").val(0);
       $('#tablaDinamicaEntidadesSup').html("");
       $("#descargaTablaGeneralPlantillaSup").hide();
       $('#tablaDinamicaPS').html("");
    }else{
          $("#anioConsultaSup").show();
          $("#anioConsultaSup").val(0);
          $('#tablaDinamicaEntidadesSup').html("");
          $("#descargaTablaGeneralPlantillaSup").hide();
          $('#tablaDinamicaPS').html("");
        }
});

$("#anioConsultaSup").change(function(){ 
  waitingDialog.show();
  tablaPlantillaSupArray = [];
  tablaPlantillaSupArray1 = [];
  var noSupervisor= $("#seleccionarSupervisorPlantillaSup").val();
  var LineaNegocioElegida = $("#seleccionarLineNegocio1a").val();
  var mes = $("#MesConsultaSup").val();
  var anio = $("#anioConsultaSup").val();
  if(anio=='0') {
     alert("seleccione un año");
     waitingDialog.hide();
    }else{
        $.ajax({
               type: "POST",
               url: "ajax_infoXEntidadesSupervisor.php",
               data: {"noSupervisor": noSupervisor,"LineaNegocioElegida": LineaNegocioElegida,"mes": mes,"anio": anio},
               dataType: "json", 
               async: false,
               success: function(response) {
                 if(response.status == "success") {
                    $('#tablaDinamicaEntidadesSup').html(""); 
                    $('#tablaDinamicaPS').html(""); 
                    var mensaje = response.message;
                    var tablaDinamicaEntidadesSup = response.rolesOp;
                    //var tablaDinamicaPS = response.rolesOp;
                    var tablaSup = "<table id='tablaSup' class='table table-bordered'><thead><th>Entidad</th><th>Vehiculos</th><th>Placa(s)</th><th>Elementos Requisición Ventas</th><th>Estado De Fuerza Operativa</th><th>Estado De Fuerza Cubre</th>";//inicio titulo tabla1
                    var tablainfoPS = "<table id='tablainfoPS' class='table table-bordered'><thead><th>Punto de Servicio</th> <th>Latitud(s)</th><th>Longitud</th>";//inio titulo tabla2                    

                    for(var i = 0; i < tablaDinamicaEntidadesSup.length; i++){
                        tablaSup   += "<th>" + tablaDinamicaEntidadesSup[i].DescripcioRolOP + "</th>"; //roles de sus respectivas tablas
                        tablainfoPS+= "<th>" + tablaDinamicaEntidadesSup[i].DescripcioRolOP + "</th>"; //roles de sus respectivas tablas
                      }

                    tablaSup   += "<th>Conteo General Cobertura(Ventas)</th> <th>Cobertura Dia(Ventas)</th> <th>Cobertura Noche(Ventas)</th> <th>Estimacion Cubre Turnos</th> <th>Turnos Merma Por Día</th>"//termina tituloTabla 1
                    tablainfoPS+= "<th>Elementos Requisición ventas</th> <th>Fuerza Operativa</th> <th>Porcentaje Cobertura</th>";//termino titulo tabla 2
                    tablaSup    += "</thead>"// termina titulo
                    tablainfoPS += "</thead>"// termina titulo
                    var totalvehiculos='0';
                    var totalelementosVentas='0';
                    var totalFuerzaOp='0';
                    var totalfuerzaCubre='0';
                    var totalcoberturaGeneralVentas='0';
                    var totalcoberturaDiaVentas='0';
                    var totalcoberturaNocheVentas='0';
                    var totalestimacionCubreTurnos='0';
                    var totalturnosMerma='0';

                    var arraytotalConteoRol=[];
                    var totalConteoRol='0';

                    var totalRequisicionPS='0';
                    var totalFuerzaOpPS='0';
                    var arraytotalConteoRolXPS=[];
                    var totalConteoRolXPS='0';

                    for(var a = 0; a < response.datos.length; a++) {
                        var entidad        = response.datos[a]["entidad"];
                        var vehiculos      = response.datos[a]["vehiculos"];
                        var placasVehiculos= response.datos[a]["placasVehiculos"];
                        var elementosVentas= response.datos[a]["elementosVentas"];
                        var fuerzaOperativa= response.datos[a]["fuerzaOperativa"];
                        var fuerzaCubre    = response.datos[a]["fuerzaCubre"];
                        var coberturaGeneralVentas= response.datos[a]["coberturaGeneralVentas"];
                        var coberturaDiaVentas    = response.datos[a]["coberturaDiaVentas"];
                        var coberturaNocheVentas  = response.datos[a]["coberturaNocheVentas"];
                        var estimacionCubreTurnos = response.datos[a]["estimacionCubreTurnos"];
                        var turnosMerma           = response.datos[a]["turnosMerma"];

                       tablaSup+="<tr><td>"+entidad+"</td><td>"+vehiculos+"</td><td>"+placasVehiculos+"</td><td>"+elementosVentas+"</td>";
                       tablaSup   += "<td>"+fuerzaOperativa+"</td><td>"+fuerzaCubre+"</td>";

                       totalvehiculos      = parseInt(vehiculos) +parseInt(totalvehiculos);
                       totalelementosVentas= parseInt(elementosVentas) +parseInt(totalelementosVentas);
                       totalFuerzaOp       = parseInt(fuerzaOperativa) +parseInt(totalFuerzaOp);
                       totalfuerzaCubre    = parseInt(fuerzaCubre) +parseInt(totalfuerzaCubre);
                       totalcoberturaGeneralVentas= parseInt(coberturaGeneralVentas) +parseInt(totalcoberturaGeneralVentas);
                       totalcoberturaDiaVentas    = parseInt(coberturaDiaVentas) +parseInt(totalcoberturaDiaVentas);
                       totalcoberturaNocheVentas  = parseInt(coberturaNocheVentas) +parseInt(totalcoberturaNocheVentas);
                       totalestimacionCubreTurnos = parseInt(estimacionCubreTurnos) +parseInt(totalestimacionCubreTurnos);
                       totalturnosMerma           = parseInt(turnosMerma) +parseInt(totalturnosMerma);
                      
                       for(var z = 0; z < tablaDinamicaEntidadesSup.length; z++){
                           var rolOp = tablaDinamicaEntidadesSup[z].DescripcioRolOP;
                           var elementoRolOp= response.datos[a][rolOp];
                           tablaSup   += "<td>"+elementoRolOp+"</td>";
                           if(a=="0"){
                                arraytotalConteoRol[z]=[elementoRolOp];
                           }else{
                                totalConteoRol =arraytotalConteoRol[z];
                                var b = parseInt(totalConteoRol) + parseInt(elementoRolOp);
                                arraytotalConteoRol[z] = b;
                           }
                       }//for Z
                       tablaSup += "<td>"+coberturaGeneralVentas+"</td><td>"+coberturaDiaVentas+"</td><td>"+coberturaNocheVentas+"</td><td>"+estimacionCubreTurnos+"</td><td>"+turnosMerma+"</td></tr>";
                    }//for response a

                    tablaSup+="<tr><td>TOTAL</td><td>"+totalvehiculos+"</td><td></td><td>"+totalelementosVentas+"</td><td>"+totalFuerzaOp+"</td><td>"+totalfuerzaCubre+"</td>";
                    
                    for (var f = 0; f < arraytotalConteoRol.length; f++) {
                         tablaSup+="<td>"+arraytotalConteoRol[f]+"</td>";
                      }
                    tablaSup+="<td>"+totalcoberturaGeneralVentas+"</td><td>"+totalcoberturaDiaVentas+"</td><td>"+totalcoberturaNocheVentas+"</td><td>"+totalestimacionCubreTurnos+"</td><td>"+totalturnosMerma+"</td></tr>";

                    var sumaPorcentaje='0';
                    for(var b = 0; b < response.datosPS.length; b++) {
                        var nombrePS= response.datosPS[b]["nombrePS"];
                        var longitud= response.datosPS[b]["longitud"];
                        var latitud = response.datosPS[b]["latitud"];

                        tablainfoPS += "<tr><td>"+nombrePS+"</td><td>"+latitud+"</td><td>"+longitud+"</td>";

                        for(var x = 0; x < tablaDinamicaEntidadesSup.length; x++){
                          var rolOp        = tablaDinamicaEntidadesSup[x].DescripcioRolOP;
                          var elementoRolOp= response.datosPS[b][rolOp];
                          tablainfoPS   += "<td>"+elementoRolOp+"</td>";
                          if(b=="0"){
                                arraytotalConteoRolXPS[x]=[elementoRolOp];
                           }else{
                                totalConteoRolXPS =arraytotalConteoRolXPS[x];
                                var c = parseInt(totalConteoRolXPS) + parseInt(elementoRolOp);
                                arraytotalConteoRolXPS[x] = c;
                           }

                        }//for x
                       var elementosVentasXpS  = response.datosPS[b]["elementosVentasXpS"];
                       var elementosFuerzaOpXPS= response.datosPS[b]["TotalElementosFuerzaOperativaXPS"];
                       var turnosCubieros= response.datosPS[b]["turnosCubiertosXPS"];
                       var turnosXdia= response.datosPS[b]["turnosPorDia"];

                       if ((turnosCubieros=='0' && turnosXdia=='0') || (turnosCubieros!='0' && turnosXdia=='0')) {
                            var porcentajeGeneralXPS= '0'; 
                       }else{
                             var porcentaje =(turnosCubieros/turnosXdia)*100;
                             var porcentajeGeneralXPS= porcentaje.toFixed(0); 
                       }

                       sumaPorcentaje    = parseInt(sumaPorcentaje)+parseInt(porcentajeGeneralXPS);
                       totalRequisicionPS= parseInt(elementosVentasXpS) +parseInt(totalRequisicionPS);
                       totalFuerzaOpPS   = parseInt(elementosFuerzaOpXPS) +parseInt(totalFuerzaOpPS);

                        if(porcentajeGeneralXPS == 100){
                            var label ="<label id='porcentaje' style='color: green;'>"+porcentajeGeneralXPS+"%" +"</label>";
                        }else if(porcentajeGeneralXPS == 80 || (porcentajeGeneralXPS > 80 && porcentajeGeneralXPS < 100)){
                            var label ="<label id='porcentaje' style='color: orange;'>"+porcentajeGeneralXPS+"%" +"</label>";
                        }else{
                            var label ="<label id='porcentaje' style='color: red;'>"+porcentajeGeneralXPS+"%" +"</label>";
                        }
                        response.datosPS[b]["porcentajeGeneralXPS1"]=label;
                        tablainfoPS += "<td>"+elementosVentasXpS+"</td><td>"+elementosFuerzaOpXPS+"</td><td>"+label+"</td></tr>";
                    }//for b
                    var promedioPorcentaje= parseInt(sumaPorcentaje)/response.datosPS.length;
                    var porcentajeTotal= promedioPorcentaje.toFixed(0); 

                    if(porcentajeTotal == 100){
                            var PorcentajeFinalTotal ="<label id='porcentajefinalLabel' style='color: green;'>"+porcentajeTotal+"%" +"</label>";
                        }else if(porcentajeTotal == 80 || (porcentajeTotal > 80 && porcentajeTotal < 100)){
                            var PorcentajeFinalTotal ="<label id='porcentajefinalLabel' style='color: orange;'>"+porcentajeTotal+"%" +"</label>";
                        }else{
                            var PorcentajeFinalTotal ="<label id='porcentajefinalLabel' style='color: red;'>"+porcentajeTotal+"%" +"</label>";
                        }

                    tablainfoPS+="<tr><td></td><td></td><td>TOTAL</td>";

                    for (var g = 0; g < arraytotalConteoRolXPS.length; g++) {
                         tablainfoPS+="<td>"+arraytotalConteoRolXPS[g]+"</td>";
                    }

                    tablainfoPS+="<td>"+totalRequisicionPS+"</td><td>"+totalFuerzaOpPS+"</td><td>"+PorcentajeFinalTotal+"</td></tr>";
                    $("#tablaDinamicaEntidadesSup").append(tablaSup);
                    $("#tablaDinamicaEntidadesSup").append(tablainfoPS);
                    $("#descargaTablaGeneralPlantillaSup").show();
                    waitingDialog.hide();
                    }else{
                          var mensaje = response.message;
                          waitingDialog.hide();
                          alert(mensaje);
                          $('#tablaDinamicaEntidadesSup').hide();
                          $("#descargaTablaGeneralPlantillaSup").hide();
                          $('#tablaDinamicaPS').hide();
                         }
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   alert(jqXHR.responseText);
                   waitingDialog.hide();
                   $('#tablaDinamicaEntidadesSup').hide();
                   $("#descargaTablaGeneralPlantillaSup").hide();
                   $('#tablaDinamicaPS').hide();
               }
           });
         }
});

  $("#descargaTablaGeneralPlantillaSup").click(function(event) {
     $("#datos_Tablas").val( $("<div>").append( $("#tablaDinamicaEntidadesSup").eq(0).clone()).html());
     $("#form_tablaGeneralSup").submit();
     //NOTA :  se utiliza el fichero de asistencia general supervisor de otro modulo (consulta asistencia) para realizar la descarga en excel 
    });











</script>



