<?php

$catalogoEntidades = $negocio->negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes  = $negocio->negocio_obtenerListaClientesActivos();
 $catalogoLineaNegocioRegistroPunto = $negocio->negocio_obtenerListaLineaNegocio();
?>

<div class="container" align="center" >
<form class="form-horizontal" id="form_GraficaTurnosDyN" name="form_GraficaTurnosDyN" action="downloadexcelconteoincidenciaspordia.php" target="_blank" method="post">
<h1 align="center">Cobertura</h1>
<br><br>
  <div id="DivFechas" style="display: none;" >
    DE:<input id="inputFechaInicio" name="inputFechaInicio" type="text" class="input-medium"> 
    A: <input id="inputFechaFin"    name="inputFechaFin"    type="text" class="input-medium">
  </div>

    <br><br>
       <select id="seleccionarCliente" name="seleccionarCliente" class="input-large"> <!--onchange="buscarTotalPorCliente();"-->
            <option value='0'>CLIENTE</option>
             <?php
               for ($i=0; $i<count($catatoloClientes); $i++){
                    echo "<option value='". $catatoloClientes[$i]["idCliente"]."'>". $catatoloClientes[$i]["razonSocial"] ." </option>";
               }  
             ?>
       </select>    
    <a style="cursor: pointer" onclick="buscarTotalPorCliente();">Total</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
</div>

<!--<div class="chart-container" style="width:60vw" align="rigth">-->
<div class="chart-container" style="width:60vw" id="DivGraficaGral" name="DivGraficaGral"  style="display: none;"> 
    <canvas id="myChart"></canvas>
</div>
<script type="text/javascript">

$('#inputFechaInicio').datetimepicker({   
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

$('#inputFechaFin').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

$("#seleccionarCliente").change(function(){
  if($("#seleccionarCliente").val()!=0){
   //("#divOpcionesPorclinete").show();
  }else{
      // $("#divOpcionesPorclinete").hide();
  }
});

function buscarTotalPorCliente(){
            $("#DivGraficaGral").hide();  
var rangoFecha1=$("#inputFechaInicio").val();
var rangoFecha2=$("#inputFechaFin").val();
var idcliente=$("#seleccionarCliente").val();//este
var razonsocialcliebte =$('select[id="seleccionarCliente"] option:selected').text();

  if(rangoFecha1=="" || rangoFecha2==""){
     alert("Proporcione Rango de Fecha correcto");
     }else{
           //waitingDialog.show();
           var rangoFechas = crearRangoPorFechas (rangoFecha1, rangoFecha2);
           var turnostotalesdia=0;
           var turnostotalesnoche=0;
        for(var i=0;i<rangoFechas.length;i++){
            var fecha = formatoFechaYYYYMMDD (rangoFechas [i]);
            var turnosdia=incidenciasTotalesPorClienteTurnosDiaOnoche(fecha,idcliente,2);
            turnosdia=parseInt(turnosdia);
            var turnosnoche=incidenciasTotalesPorClienteTurnosDiaOnoche(fecha,idcliente,3);
            turnosnoche=parseInt(turnosnoche);
       
            rowTurnostotalesDia= turnosdia;
            rowTurnostotalesNoche= turnosnoche;
            ///////////////PARA LA SUMA DE TOTAL DE TOTALES//////////////
            turnostotalesdia=(turnostotalesdia+turnosdia);
            turnostotalesnoche=(turnostotalesnoche+turnosnoche);
        }
          rowTurnostotalesDia= turnostotalesdia;
          rowTurnostotalesNoche= turnostotalesnoche;
      }
        GraficaTotalTurnosXCliente(turnostotalesdia,turnostotalesnoche);
          // waitingDialog.hide();

  }

function crearRangoPorFechas (fecha1, fecha2){
 
 var result = [];
 var fechaInicial = SepararDate (fecha1);
 var fechaFinal   = SepararDate (fecha2);
  while (fechaInicial <= fechaFinal){
   result.push (fechaInicial);
   var nuevaFecha = new Date(fechaInicial)
   fechaInicial = new Date(nuevaFecha.setDate (nuevaFecha.getDate() + 1));
  }
  return result;
}

function formatoFechaYYYYMMDD (date){
  var mm = date.getMonth() + 1; 
  if (mm < 10){
      mm = "0"+mm;
  }
  var dd = date.getDate();

  if (dd < 10){
      dd = "0" + dd;
  }
  return [date.getFullYear(), mm, dd].join('-'); // padding
}

/*function incidenciasTotalesPorClienteDia(fechadia,idcliente){
   var turnosporclientebydia =Array();
   $.ajax({
          type: "POST",
          url: "ajax_ConteoTotalTurnosXCliente.php", //no esta por rol
          data: {"idcliente": idcliente,"fechadia": fechadia,"accion":1},
          dataType: "json",
          async:false,
          success: function(response) {
                if (response.status == "success"){
                    turnosporclientebydia = response.datos;
                }else{
                  alert("error en turnos total suces");
                }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                   alert(jqXHR.responseText); 
            }
        });
    //waitingDialog.hide();
    return turnosporclientebydia;
}
*/
function incidenciasTotalesPorClienteTurnosDiaOnoche(fechadia,idcliente,accion){
   //waitingDialog.hide();
$("#DivGraficaGral").show();

   var turnosdianoche =Array();
   $.ajax({
            type: "POST",
            url: "ajax_ConteoTotalTurnosXCliente.php",
            data: {"idcliente": idcliente,"fechadia": fechadia,"accion":accion},
            dataType: "json",
            async:false,
            success: function(response) {

                if (response.status == "success"){
                 //waitingDialog.show();

                    turnosdianoche = response.turnosdianoche[0].turnosdiaonoche;
              console.log(turnosdianoche);
                }else{
                  alert("error en turnos total suces");
                }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
   //waitingDialog.hide();
return turnosdianoche;
}

function SepararDate (fecha){
  var elementos = fecha.split ("-");
  return new Date (elementos[0], elementos[1] - 1, elementos[2]);
}

function GraficaTotalTurnosXCliente(turnostotalesdia,turnostotalesnoche){
   //alert(turnostotalesdia);
 //  alert(turnostotalesnoche);
//waitingDialog.hide();

 var turnostotalesdia = turnostotalesdia;
 var turnostotalesnoche = turnostotalesnoche;

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Turnos Totales de dia', 'Turnos Totales de noche'],
        datasets: [{
            label: 'Turnos',
            data: [turnostotalesdia, turnostotalesnoche],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
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
});

}

</script>



