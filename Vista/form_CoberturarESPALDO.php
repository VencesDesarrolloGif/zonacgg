<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head><br><br><br>
<center> 
  <div id="divError"></div>   
  <div class="col-lg-12" style="font-size:50px;">Cobertura</div>
</center>
</head> <br><br>
<center>
  <div id="DivFechas" style="display: none;">
     DE:<input id="inputFechaInicio" name="inputFechaInicio" type="text" class="input-medium"> 
     A: <input id="inputFechaFin"    name="inputFechaFin"    type="text" class="input-medium">
  </div>

    <div id="DivLineaNegocio" style="display: none;">
    <select id="seleccionarLineNegocio" name="seleccionarLineNegocio"></select><br>
    </div>

      <div id="DivSeleccionarTipo" style="display: none;">
      <select name="seleccionarTipo" id="seleccionarTipo">
           <option value="0">TIPO</option>
           <option value="1">GENERAL</option>
           <option value="2">CLIENTE</option>
           <option value="3">SUPERVISOR</option>
      </select>   
      <img id="buscartipo" title="Busqueda general" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;"> 
      </div>

        <div id="DivClientes" style="display: none;">
           <select id="seleccionarCliente" name="seleccionarCliente" class="input-large"></select> 
           <img id="buscarCliente" title="Buscar por cliente" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
         </div>

<div id="DivSupervisor" style="display: none;">
   <select id="seleccionarSupervisor" name="seleccionarSupervisor" class="input-large"></select> 
   <img id="buscarSupervisor" title="Buscar por supervisor" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
</div>

<div id="DivEntidades" style="display: none;" >
   <select id="seleccionarEntidad" name="seleccionarEntidad" class="input-large"></select> 
   <img id="buscarEntidad" title="Buscar por entidad" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
</div>

<div id="DivPuntoServicio" style="display: none;">
   <select id="seleccionarPuntoServicio" name="seleccionarPuntoServicio" class="input-large"></select> 
   <img id="buscarPuntodeServicio" title="Buscar por punto de servicio" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
</div>

<div class="col-lg-12" style="padding-top:20px;" id="DivGraficaCobertura" name="DivGraficaCobertura"  style="display: none;">         
    <div id="DivGrafCob" name="DivGrafCob"></div> 
</div>

</center>
<script type="text/javascript">

$(inicioActSPS());  

function inicioActSPS(){
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

  $("#DivLineaNegocio").show();

    $.ajax({
            type: "POST",
            url: "ajax_obtenerLineasdeNegocio.php",
            dataType: "json",
            success: function(response) {
              $("#seleccionarLineNegocio").empty();  
              $('#seleccionarLineNegocio').append('<option value="0">LINEA DE NEGOCIO</option>');
                if(response.status == "success"){
                  for (var i = 0; i < response.valor.length; i++){
                      $('#seleccionarLineNegocio').append('<option value="'+(response.valor[i].idLineaNegocio)+'">'+response.valor[i].descripcionLineaNegocio+'</option>');
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

$("#seleccionarLineNegocio").change(function(){

  var tipo=$("#seleccionarLineNegocio").val();

  if (tipo==0) {
      $("#DivSeleccionarTipo").hide();
      $("#seleccionarTipo").val(0);
      $("#DivClientes").hide();
      $("#DivEntidades").hide();
      $("#DivPuntoServicio").hide();
      $("#DivSupervisor").hide();
  
  }else{
      $("#DivFechas").show();
      $("#buscartipo").hide();
      $("#seleccionarTipo").val(0);
      $("#DivSeleccionarTipo").show();
      $("#seleccionarCliente").val(0);
      $("#DivClientes").hide();
      $("#seleccionarEntidad").val(0);
      $("#DivEntidades").hide();
      $("#seleccionarPuntoServicio").val(0);
      $("#DivPuntoServicio").hide();
      $("#DivSupervisor").hide();
    }
});

$("#seleccionarTipo").change(function(){
  
  $("#seleccionarCliente").val(0);
  var tipo=$("#seleccionarTipo").val();
  
  if(tipo==1){//general
   $("#buscartipo").show();
   $("#DivClientes").hide();
   $("#DivEntidades").hide();
   $("#DivPuntoServicio").hide();
   $("#DivSupervisor").hide();
  }
  if(tipo==2) {//Cliente
     $("#buscartipo").hide();
     $("#DivClientes").show();
     $("#DivEntidades").hide();
     $("#DivPuntoServicio").hide();
     $("#DivSupervisor").hide();

     var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
     $.ajax({
             type: "POST",
             url: "ajax_obtenerClientesXlineaNegocio.php",
             dataType: "json",
             success: function(response) {
               $("#seleccionarCliente").empty();  
               $('#seleccionarCliente').append('<option value="0">Cliente</option>');
                 if(response.status == "success"){
                    for(var i = 0; i < response.datos.length; i++){
                         $('#seleccionarCliente').append('<option value="' + (response.datos[i].idCliente) + '">' + response.datos[i].razonSocial + '</option>');
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

  if(tipo==3) {//Supervisor
     $("#buscartipo").hide();
     $("#DivSupervisor").show();
     $("#DivEntidades").hide();
     $("#DivClientes").hide();
     $("#DivPuntoServicio").hide();

     var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
     $.ajax({
             type: "POST",
             url: "ajax_obtenerSupervisoresXlineaNegocio.php",
             data: {"LineaNegocioElegida": LineaNegocioElegida},
             dataType: "json",
             success: function(response) {
               $("#seleccionarSupervisor").empty();  
               $('#seleccionarSupervisor').append('<option value="0">SUPERVISOR</option>');
                 if(response.status == "success"){
                    for(var i = 0; i < response.datos.length; i++){
                         $('#seleccionarSupervisor').append('<option value="' + (response.datos[i].NumEmpSupervisor) + '">' + response.datos[i].Nombre + '</option>');
                    }
                 }else{
                     alert("Error al cargar Entidades");
                   }
             },
           error: function(jqXHR, textStatus, errorThrown){
             alert(jqXHR.responseText);
           }
     });
  }//termina if tipo 3
});

$("#seleccionarCliente").change(function() {

  $("#buscartipo").hide();
  $("#buscarPuntodeServicio").hide();
  $("#buscarEntidad").hide();
  $("#buscarCliente").show();
  $('#seleccionarPuntoServicio').empty().append('<option value="0">PUNTO DE SERVICIO</option>');
  $("#DivEntidades").show();

  var ClienteElegido = $("#seleccionarCliente").val();

  var clientesel = $("#seleccionarCliente").val();

  if (clientesel==0 || clientesel=="CLIENTE") 
  {
      $("#seleccionarEntidad").empty();  
      $('#seleccionarEntidad').append('<option value="0">ENTIDAD</option>');
  }

  if(ClienteElegido != 0 && ClienteElegido != "Elegir"){
    
    $.ajax({
            type: "POST",
            url: "ajax_CatalogoEntidadesXCliente.php",
            data: {"ClienteElegido": ClienteElegido},
            dataType: "json",
            success: function(response) {
              $("#seleccionarEntidad").empty();  
              $('#seleccionarEntidad').append('<option value="0">ENTIDAD</option>');
                if(response.status == "success"){
                   for(var i = 0; i < response.datos.length; i++){
                       $('#seleccionarEntidad').append('<option value="'+(response.datos[i].idEntidadFederativa)+'">'+response.datos[i].nombreEntidadFederativa+'</option>');
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

$("#seleccionarSupervisor").change(function() {

  $("#buscarEntidad").hide();
  $("#buscartipo").hide();
  $("#buscarSupervisor").show();
  $("#DivEntidades").show();
  var supervisorElegido = $("#seleccionarSupervisor").val();

 /* if (supervisorElegido=='0') {

  $("#buscarSupervisor").hide();


  }*/

    $.ajax({//traigo todas las entidades
            type: "POST",
            url: "ajax_obtenerEntidadesXSupervisor.php",
            data: {"supervisorElegido": supervisorElegido},
            dataType: "json",
            success: function(response){
              

              var entidadesTraidas=response.datos;
              var totalEntidades = entidadesTraidas.length;
              //alert(totalEntidades);
               if (totalEntidades=='0'  || totalEntidades==0 || totalEntidades=='' || totalEntidades=='NULL' || totalEntidades==null || totalEntidades=='null') {
                 alert("SIN ENTIDADES ASIGNADAS");
               }

              $("#seleccionarEntidad").empty();  
              $('#seleccionarEntidad').append('<option value="0">ENTIDAD</option>');
                if (response.status == "success"){
                    for (var i = 0; i < response.datos.length; i++){
                         $('#seleccionarEntidad').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
                    }
                }else{
                  alert("Error al cargar Entidades");
                }
            },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
    });
});

$("#seleccionarEntidad").change(function() {

  $("#buscarCliente").hide();
  $("#buscarEntidad").show();
  $("#buscarPuntodeServicio").hide();
  $("#seleccionarPuntoServicio").val("0");
  var lineaNegocio = $("#seleccionarLineNegocio").val();
  var tipoElegido = $("#seleccionarTipo").val();
  var supervisorele= $("#seleccionarSupervisor").val();
  var ClienteElegido = $("#seleccionarCliente").val();
  var EntidadElegida = $("#seleccionarEntidad").val();


  if (EntidadElegida==0 || EntidadElegida=="ENTIDAD") {
     $("#buscarEntidad").hide();
     $("#buscarCliente").show();
     $("#buscarSupervisor").show();
     $("#seleccionarPuntoServicio").empty();  
     $('#seleccionarPuntoServicio').append('<option value="0">PUNTO DE SERVICIO</option>');
  }

  if (tipoElegido==2) {//por cliente
     $("#DivPuntoServicio").show();
     
            
        if(EntidadElegida != 0 && EntidadElegida != "ENTIDAD"){
          $.ajax({
                  type: "POST",
                  url: "ajax_PuntoServicioXEntidadyCliente.php",
                  data: {"EntidadElegida": EntidadElegida, "ClienteElegido": ClienteElegido, "lineaNegocio": lineaNegocio},
                  dataType: "json",
                  success: function(response) {
                     $("#seleccionarPuntoServicio").empty();  
                     $('#seleccionarPuntoServicio').append('<option value="0">PUNTO DE SERVICIO</option>');
                       
                       if (response.status == "success"){
                           for (var i = 0; i < response.datos.length; i++){
                                $('#seleccionarPuntoServicio').append('<option value="' + (response.datos[i].idPuntoServicio) + '">' + response.datos[i].puntoServicio + '</option>');
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
  }else{//por supervisor
        $("#DivPuntoServicio").show();
        $("#buscarSupervisor").hide();
        if(EntidadElegida != 0 && EntidadElegida != "Elegir"){
           $.ajax({
              type: "POST",
              url: "ajax_PuntoServicioXEntidadSupervisor.php",
              data: {"EntidadElegida": EntidadElegida,"lineaNegocio": lineaNegocio, "supervisorele": supervisorele},
              dataType: "json",
              success: function(response){
                $("#seleccionarPuntoServicio").empty();  
                $('#seleccionarPuntoServicio').append('<option value="0">PUNTO DE SERVICIO</option>');
                  if (response.status == "success"){
                      for (var i = 0; i < response.datos.length; i++){
                           $('#seleccionarPuntoServicio').append('<option value="' + (response.datos[i].idPuntoServicio) + '">' + response.datos[i].puntoServicio + '</option>');
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
});

$("#seleccionarPuntoServicio").change(function() {

  $("#buscarEntidad").hide();
  $("#buscarPuntodeServicio").show();

});

function GraficaCoberturaTurnos(){

var lineaNegocioElegido = $("#seleccionarLineNegocio").val();
var tipoElegido = $("#seleccionarTipo").val();
var clienteElegido = $("#seleccionarCliente").val();
var entidadElegida = $("#seleccionarEntidad").val();
var PuntoServElegido = $("#seleccionarPuntoServicio").val();
var supervisorElegido = $("#seleccionarSupervisor").val();
var fechaInicioElegida = $("#inputFechaInicio").val();
var fechaFinElegida = $("#inputFechaFin").val();

if(fechaInicioElegida ==0 || fechaFinElegida ==0){
   alert("ingrese Fechas");
  }
else if(fechaInicioElegida > fechaFinElegida){
   alert("La fecha de inicio elegida no puede ser mayor a la fecha final");
}
else if (lineaNegocioElegido=="0") {
   alert("Seleccione una linea de negocio");
}
  else{
       var coberturapuntoServicioId = $("#seleccionarPuntoServicio").val();
       var coberturafechaInicial = $("#inputFechaInicio").val();
       var coberturafechaFinal = $("#inputFechaFin").val();

         $("#DivGraficaCobertura").show();
         var canvas = "<canvas id='CanvasGraficaCobertura' name='CanvasGraficaCobertura'></canvas>";
         $('#DivGrafCob').html(canvas); 

      if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1){//buscar tipo general
        
         var tipoBusqueda=1;
         var coberturapuntoServicioId=0;
         var clienteElegido=0;
         var entidadElegida=0;
         var supervisorElegido=0;    

         GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida ==0 && (PuntoServElegido ==0 || PuntoServElegido =="null" || PuntoServElegido ==null)){//busqueda por cliente
         var tipoBusqueda=2;
         var coberturapuntoServicioId=0;
         var entidadElegida=0;
         var supervisorElegido=0;    
         GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);
      }

  else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido ==0){//busqueda cliente y entidad
          var tipoBusqueda=3;
          var supervisorElegido=0;
          GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);

  }

  else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido !=0){ //busqueda punto y cliente
        
    var tipoBusqueda=4;    
    var supervisorElegido=0;    
    GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);
         
  }

  else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida ==0 && (PuntoServElegido ==0 || PuntoServElegido =="null" || PuntoServElegido ==null)){// buscar por supervisor
          var tipoBusqueda=5;
          GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);

  }

  else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida !=0 && PuntoServElegido ==0){//buscar X supervisor y entidad

    var tipoBusqueda=6;    
    GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido);

  }

  else if(fechaInicioElegida != 0 && fechaFinElegida != 0 && lineaNegocioElegido != 0 && tipoElegido == 3 && supervisorElegido !=0 && entidadElegida !=0 && PuntoServElegido !=0){//busqueda punto por supervisor

    var tipoBusqueda=7;    
    GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,supervisorElegido);
  }
  
 }
}

function GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido){
  waitingDialog.show();
  $.ajax({
          type: "POST",
          url: "ajax_ConteoTurnosXDia.php",
          data:{"coberturapuntoServicioId":coberturapuntoServicioId,"coberturafechaInicial":coberturafechaInicial,"coberturafechaFinal":coberturafechaFinal,"tipoBusqueda":tipoBusqueda,"lineaNegocioElegido":lineaNegocioElegido,"clienteElegido":clienteElegido,"entidadElegida":entidadElegida,"supervisorElegido":supervisorElegido},
                 dataType: "json",
                 async:false,
                 success:function(response) {
                    waitingDialog.hide();
              
                  var fechas = [];
                    var coberturaNoche = [];
                    var coberturaDía = [];
                    var coberturaNocheCumplida = [];
                    var coberturaDiaCumplida = [];
                    var datosGrafica= response.result;
                  var inicial=coberturafechaInicial.split("-");
                  var final=coberturafechaFinal.split("-");

                  var dateStart=new Date(inicial[0],(inicial[1]-1),inicial[2]);
                  var dateEnd=new Date(final[0],(final[1]-1),final[2]);

                  resultado=(((dateEnd-dateStart)/86400)/1000);

                 
                  for(var i=0; i<resultado+1; i++){
                    
                    if(i==0){
                      var fechasfor = (response.result[coberturafechaInicial]);
                      var aa = coberturafechaInicial;
                    }else{

                      var fecha = new Date($('#inputFechaInicio').val());
                      fecha.setDate(fecha.getDate() + i+1);
                      var anioA = fecha.getFullYear();
                      var mesA = (fecha.getMonth() + 1);
                      var diaA = fecha.getDate();
                  //alert(mesA + " " + "mesA");
                  //alert(diaA + " " + "diaA");

                       if(mesA <= 9){
                          mesAA = "0"+mesA;
                       }else{
                        mesAA=mesA;
                       }
                       if(diaA <= 9){
                         diaAA = "0"+diaA;
                       }else{
                        diaAA=diaA;
                       }
                       var aa = anioA + '-'  + mesAA + '-' + diaAA;
                       var fechasfor = (response.result[aa]);
                    }

                   fechas.push(aa);
                   coberturaDía.push(fechasfor["turnoDeDia"]);         
                   coberturaNoche.push(fechasfor["turnosDeNoche"]);
                   coberturaNocheCumplida.push(fechasfor["turnosCubiertosNoche"]);
                   coberturaDiaCumplida.push(fechasfor["turnosCubiertosDia"]);
                  }
                          var graficaCanvasCobertura = document.getElementById("CanvasGraficaCobertura"); 
                          Chart.defaults.global.defaultFontFamily = "Lato";
                          Chart.defaults.global.defaultFontSize = 18;
              
                          var totalCoberturaDia = {
                              label: 'Petición Cobertura Día(ventas)',
                              data: coberturaDía,
                              backgroundColor: 'rgba(241, 219, 28, 1)',         
                              yAxisID: "barElementosReclutados"
                          };
                          var totalCoberturaNoche = {
                              label: 'Petición Cobertura Noche(ventas)',
                              data: coberturaNoche,
                              backgroundColor: 'rgba(25, 39, 254, 1)',          
                              yAxisID: "barElementosReclutados"
                          };
                          var totalCoberturaDiaCum = {
                              label: 'Cobertura Día',
                              data: coberturaDiaCumplida,
                              backgroundColor: 'rgba(210, 179, 0, 1)',
                              yAxisID: "barElementosReclutados"
                          };  
                          var totalCoberturaNocheCum = {
                              label: 'Cobertura Noche',
                              data: coberturaNocheCumplida,
                              backgroundColor: 'rgba(10, 14, 73, 1)',
                              yAxisID: "barElementosReclutados"
                          };
 
                          var datoselementos = {
                              labels: fechas,
                              datasets: [totalCoberturaDia, totalCoberturaDiaCum, totalCoberturaNoche, totalCoberturaNocheCum]
                          };            
                          var chartOptions = {
                               scales: {                  
                                  yAxes: [{
                                    id: "barElementosReclutados",
                                    ticks:{beginAtZero: true}
                                  }]
                               }
                          };       

                          var barChart = new Chart(graficaCanvasCobertura, {
                            type: 'bar',
                            data: datoselementos,
                            options: chartOptions
                          }); 
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
        });
}

</script>



