<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>
<center> 
  <div id="divError"></div>   
   <h3>Clientes Facturables</h3>
     <table>
       <tr>
           <td>
               <div class="chart-container" style="width:1vw">
                   <input type="radio" id="radioSíCOBERTURA" name="radioSí">
                   <h4>Si</h4>
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:1vw">
                   <input type="radio" id="radioNoCOBERTURA" name="radioNo">
                   <h4>No</h4>                                        
               </div>
           </td>
       </tr>     
     </table><br>
</center>
</head> <br><br>

<center>
<div id="DivCobertura" style="display: none;">
   <div class="col-lg-12" style="font-size:50px;">Cobertura</div><br>
  
  <div id="DivFechas" style="display: none;">
     DE:<input id="inputFechaInicio" placeholder="Seleccione Fecha" name="inputFechaInicio" type="text" class="input-medium"> 
     A: <input id="inputFechaFin"    placeholder="Seleccione Fecha" name="inputFechaFin"    type="text" class="input-medium">
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
        <img id="buscartipoSupervisor" title="Busqueda general por supervisor" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos(); " style="display: none;"> 
      </div>

      <div id="DivClientes" style="display: none;">
        <select id="seleccionarCliente" name="seleccionarCliente" class="input-large"></select> 
        <img id="buscarCliente" title="Buscar por cliente" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivEntidadesParaSupervisores" style="display: none;" >
         <select id="seleccionarEntidadParaSupervisores" name="seleccionarEntidadParaSupervisores" class="input-large"></select> 
         <img id="buscarEntidadParaSupervisores" title="Buscar por entidad" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivSupervisor" style="display: none;">
         <select id="seleccionarSupervisor" name="seleccionarSupervisor" class="input-large"></select> 
         <img id="buscarSupervisor" title="Buscar por supervisor" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivEntidades" style="display: none;" >
         <select id="seleccionarEntidad" name="seleccionarEntidad" class="input-large"></select> 
         <img id="buscarEntidad" title="Buscar por entidad" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivClientesXGeneral" style="display: none;">
        <select id="seleccionarClienteGeneral" name="seleccionarClienteGeneral" class="input-large"></select> 
        <img id="buscarClienteGeneral" title="Buscar por cliente" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivClientesSupervisor" style="display: none;">
        <select id="seleccionarClienteSupervisor" name="seleccionarClienteSupervisor" class="input-large"></select> 
        <img id="buscarClienteSupervisor" title="Buscar por cliente" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>

      <div id="DivPuntoServicio" style="display: none;">
         <select id="seleccionarPuntoServicio" name="seleccionarPuntoServicio" class="input-large"></select> 
         <img id="buscarPuntodeServicio" title="Buscar por punto de servicio" src="img/botonbuscar.jpg" width="125px" onclick="GraficaCoberturaTurnos();" style="display: none;">
      </div>
      
      <div class="col-lg-12" style="padding-top:20px;" id="DivGraficaCobertura" name="DivGraficaCobertura"  style="display: none;">         
          <div id="DivGrafCob" name="DivGrafCob"></div> 
      </div>

      <div class="col-lg-12" style="padding-top:20px;" id="DivGraficaCoberturaSupervisor" name="DivGraficaCoberturaSupervisor"  style="display: none;">         
          <div id="DivGrafCobSupervisor" name="DivGrafCobSupervisor"></div> 
      </div>

      <div class="col-lg-12" id="DivGraficaCobertura1" name="DivGraficaCobertura1"  style="display: none;">
       <table>
        <tr>
          <th>
              <div style="width:35vw" id="DivGrafConteoTurnos" name="DivGrafConteoTurnos"></div> 
          </th>
          <th>
              <div style="width:35vw" id="DivGrafPorcentajeCobertura" name="DivGrafPorcentajeCobertura"></div> 
          </th>
        </tr>
       </table>
      </div>
</div><!-- termina divcobertura-->
</center>

    <script src="Chart.min.js"></script>
<script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioCobertura());  

function inicioCobertura(){
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

$("#radioNoCOBERTURA").change(function(){
  
  if($('#radioNoCOBERTURA').is(":checked")){
     $("#radioNoCOBERTURA").val(1);
     $("#radioSíCOBERTURA").prop("checked", false);
     $("#radioSíCOBERTURA").val(0);
     $("#buscartipoSupervisor").hide();
     $("#seleccionarClienteGeneral").hide();
     $("#buscarClienteGeneral").hide();
   }else{
         $("#radioNoCOBERTURA").val(0);
        }
    $("#DivCobertura").show();
    $("#DivFechas").show();
    $("#inputFechaInicio").val("");
    $("#inputFechaFin").val("");
    $("#seleccionarLineNegocio").val(0);
    $("#seleccionarCliente").empty();
    $("#seleccionarSupervisor").empty();
    $("#seleccionarEntidad").empty();
    $("#seleccionarClienteSupervisor").empty();
    $("#seleccionarPuntoServicio").empty();
    $("#DivClientes").hide();
    $("#DivSupervisor").hide();
    $("#DivEntidades").hide();
    $("#DivEntidadesParaSupervisores").hide();
    $("#DivClientesSupervisor").hide();
    $("#DivPuntoServicio").hide();
    $("#DivSeleccionarTipo").hide();
    $("#buscarEntidad").hide();
    $("#DivGraficaCobertura").hide();
    $("#DivGraficaCoberturaSupervisor").hide();
    $("#DivGraficaCobertura1").hide();
});

$("#radioSíCOBERTURA").change(function(){
  if($('#radioSíCOBERTURA').is(":checked")){
     $("#radioSíCOBERTURA").val(1);
     $("#radioNoCOBERTURA").prop("checked", false);
     $("#radioNoCOBERTURA").val(0);
     $("#buscartipoSupervisor").hide();
     $("#seleccionarClienteGeneral").hide();
     $("#buscarClienteGeneral").hide();
   }else{
         $("#radioSíCOBERTURA").val(0);
        }
    $("#DivCobertura").show();
    $("#DivFechas").show();
    $("#inputFechaInicio").val("");
    $("#inputFechaFin").val("");
    $("#seleccionarLineNegocio").val(0);
    $("#seleccionarCliente").empty();
    $("#seleccionarSupervisor").empty();
    $("#seleccionarEntidad").empty();
    $("#seleccionarClienteSupervisor").empty();
    $("#seleccionarPuntoServicio").empty();
    $("#DivClientes").hide();
    $("#DivSupervisor").hide();
    $("#DivEntidades").hide();
    $("#DivEntidadesParaSupervisores").hide();
    $("#DivClientesSupervisor").hide();
    $("#DivPuntoServicio").hide();
    $("#DivSeleccionarTipo").hide();
    $("#buscarEntidad").hide();
    $("#DivGraficaCobertura").hide();
    $("#DivGraficaCoberturaSupervisor").hide();
    $("#DivGraficaCobertura1").hide();
 });

$("#seleccionarLineNegocio").change(function(){

  var tipo=$("#seleccionarLineNegocio").val();
  $("#DivGraficaCobertura").hide();
  $("#DivGraficaCoberturaSupervisor").hide();
  $("#DivGraficaCobertura1").hide();
  $("#DivClientesXGeneral").hide();
  $("#buscartipoSupervisor").hide();

  if (tipo==0){
      $("#DivSeleccionarTipo").hide();
      $("#seleccionarTipo").val(0);
      $("#DivClientes").hide();
      $("#DivEntidades").hide();
      $("#DivEntidadesParaSupervisores").hide();
      $("#DivPuntoServicio").hide();
      $("#DivSupervisor").hide();
      $("#DivClientesSupervisor").hide();
    }else{
      $("#DivFechas").show();
      $("#buscartipo").hide();
      $("#seleccionarTipo").val(0);
      $("#DivSeleccionarTipo").show();
      $("#seleccionarCliente").val(0);
      $("#DivClientes").hide();
      $("#seleccionarEntidad").val(0);
      $("#DivEntidades").hide();
      $("#DivEntidadesParaSupervisores").hide();
      $("#seleccionarPuntoServicio").val(0);
      $("#DivPuntoServicio").hide();
      $("#DivSupervisor").hide();
      $("#DivClientesSupervisor").hide();
      $("#seleccionarClienteSupervisor").val(0);
    }
});

$("#seleccionarTipo").change(function(){

  var valorgifTipo = $("#radioNoCOBERTURA").val();
  var tipo=$("#seleccionarTipo").val();
  var Linea=$("#seleccionarLineNegocio").val();
  $("#seleccionarCliente").val(0);
  $("#seleccionarSupervisor").empty();  
  $("#seleccionarPuntoServicio").empty(); 
  $("#seleccionarCliente").empty(); 
  $("#seleccionarEntidad").empty(); 
  $("#seleccionarClienteSupervisor").empty(); 
  $("#buscarEntidad").hide();
  $("#DivGraficaCobertura").hide();
  $("#DivGraficaCoberturaSupervisor").hide();
  $("#DivGraficaCobertura1").hide();
  $("#DivClientesXGeneral").hide();
  $("#buscartipoSupervisor").hide();
  $("#seleccionarSupervisor").empty();
  $("#buscarSupervisor").hide();

  if(tipo==0){//tipo
    $("#buscartipo").hide();
    $("#DivClientes").hide();
    $("#DivEntidades").hide();
    $("#DivEntidadesParaSupervisores").hide();
    $("#DivPuntoServicio").hide();
    $("#DivSupervisor").hide();
    $("#DivClientesSupervisor").hide();
  }
  if(tipo==1){//general
    $("#buscartipo").show();
    $("#buscarEntidad").hide();
    $("#DivClientes").hide();
    $("#DivEntidades").show();
    $("#DivEntidadesParaSupervisores").hide();
    $("#DivPuntoServicio").hide();
    $("#DivSupervisor").hide();
    $("#DivClientesSupervisor").hide();
    obtenerEntidades(valorgifTipo,Linea,tipo);
  }
  if(tipo==2) {//Cliente
     $("#buscartipo").hide();
     $("#buscarCliente").hide();
     $("#DivClientes").show();
     $("#DivEntidades").hide();
     $("#DivEntidadesParaSupervisores").hide();
     $("#DivPuntoServicio").hide();
     $("#DivSupervisor").hide();
     $("#DivClientesSupervisor").hide();

     var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
     $.ajax({
             type: "POST",
             url: "ajax_obtenerClientesXlineaNegocio.php",
             data: {"LineaNegocioElegida": LineaNegocioElegida,"valorgifTipo": valorgifTipo},
             dataType: "json",
             success: function(response) {
               $("#seleccionarCliente").empty();  
               $('#seleccionarCliente').append('<option value="0">Seleccionar</option>');
                 if(response.status == "success"){
                    for(var i = 0; i < response.datos.length; i++){
                         $('#seleccionarCliente').append('<option value="' + (response.datos[i].idCliente) + '">' + response.datos[i].razonSocial + '</option>');
                    }
                    if (valorgifTipo==1) {
                        $("#seleccionarCliente").val(13);  
                        $("#buscarCliente").hide();  
                        CargarEntidadesxCliente(13);
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

  if(tipo==3){//Supervisor
     $("#buscartipo").hide();
     $("#DivSupervisor").hide();
     $("#DivEntidades").hide();
     $("#DivEntidadesParaSupervisores").show();
     $("#DivClientes").hide(); 
     $("#DivPuntoServicio").hide();
     $("#buscarEntidadParaSupervisores").hide();
     var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
     obtenerEntidades(valorgifTipo,LineaNegocioElegida,tipo);
      if(valorgifTipo==0){
         $("#buscartipoSupervisor").show();
        }
  }//termina if tipo 3
});

function obtenerEntidades(valorgifTipo,Linea,tipo){
//no importa si es por supervisor y gerente regional, por que buscara los supervisores por entidad, y solo muestra las regiones asignadas
  $.ajax({
          type: "POST",
          url: "ajax_entidadesGeneral.php",
          data: {"valorgifTipo": valorgifTipo, "Linea": Linea},
          dataType: "json",
          success: function(response) {
            if (tipo==1) {
             $("#seleccionarEntidad").empty();  
             $('#seleccionarEntidad').append('<option value="0">ENTIDAD</option>');
               if(response.status == "success"){
                 for (var i = 0; i < response.datos.length; i++){
                     $('#seleccionarEntidad').append('<option value="'+(response.datos[i].idEntidadFederativa)+'">'+response.datos[i].nombreEntidadFederativa+'</option>');
                   }
               }else{
                 alert("Error al cargar Linea de Negocio");
               }
            }else if(tipo==3){
                  $("#seleccionarEntidadParaSupervisores").empty();  
                  $('#seleccionarEntidadParaSupervisores').append('<option value="0">ENTIDAD</option>');
                    if(response.status == "success"){
                      for (var i = 0; i < response.datos.length; i++){
                          $('#seleccionarEntidadParaSupervisores').append('<option value="'+(response.datos[i].idEntidadFederativa)+'">'+response.datos[i].nombreEntidadFederativa+'</option>');
                        }
                    }else{
                      alert("Error al cargar Linea de Negocio");
                    }
            }
          },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
      });
}

$("#seleccionarEntidadParaSupervisores").change(function(){
   var tipo=$("#seleccionarTipo").val();
   var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
   var valorgifTipo = $("#radioNoCOBERTURA").val();
   var entidadElegida = $("#seleccionarEntidadParaSupervisores").val();
   $("#buscartipoSupervisor").hide();
   $("#buscarPuntodeServicio").hide();
   $("#buscarClienteSupervisor").hide();
   $("#buscarEntidad").hide();
   $("#seleccionarPuntoServicio").empty().append('<option value="0">PUNTO DE SERVICIO</option>');
   $("#seleccionarClienteSupervisor").empty().append('<option value="0">CLIENTE</option>');
   $("#seleccionarEntidad").empty().append('<option value="0">ENTIDADES ASIGNADAS</option>');

     if (entidadElegida==0) {
        $("#buscarEntidadParaSupervisores").hide();
        $("#buscarSupervisor").hide();
        $("#seleccionarSupervisor").empty().append('<option value="0">SUPERVISOR</option>');
          if (valorgifTipo==0){
            $("#buscartipoSupervisor").show();
          }
          if (valorgifTipo==1) {
            alert("SELECCIONE UNA ENTIDAD");
          }
     }
        if (tipo==3 && entidadElegida!=0) {
           $("#DivSupervisor").show();
           obtenerSupervisoresXentidad(LineaNegocioElegida,valorgifTipo,entidadElegida);
           if (valorgifTipo==0){
              $("#buscarEntidadParaSupervisores").show();
            }
        }
});

function obtenerSupervisoresXentidad(LineaNegocioElegida,valorgifTipo,entidadElegida){//pr

   $.ajax({
             type: "POST",
             url: "ajax_obtenerSupervisoresXEntidad.php",//revisada en produccion
             data: {"LineaNegocioElegida": LineaNegocioElegida,"valorgifTipo": valorgifTipo,"entidadElegida": entidadElegida},
             dataType: "json",
             success: function(response) {
               $("#seleccionarSupervisor").empty();  
               $('#seleccionarSupervisor').append('<option value="0">Seleccionar</option>');
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
}

$("#seleccionarCliente").change(function()
{
  $("#buscartipo").hide();
  $("#buscarPuntodeServicio").hide();
  $("#buscarEntidad").hide();
  $('#seleccionarPuntoServicio').empty().append('<option value="0">PUNTO DE SERVICIO</option>');
  var ClienteElegido = $("#seleccionarCliente").val();
  var clientesel = $("#seleccionarCliente").val();
  var valorgifTipo = $("#radioNoCOBERTURA").val();

  if(clientesel==0 || clientesel=="Seleccionar"){
   $("#buscarCliente").hide();
   $("#seleccionarEntidad").empty().append('<option value="0">ENTIDAD</option>');
   alert("SELECCIONE CLIENTE") 
  }
  if(ClienteElegido != 0 && ClienteElegido != "Elegir" && valorgifTipo==0){
     $("#buscarCliente").show();
  }

  if(ClienteElegido != 0 && ClienteElegido != "Elegir" && valorgifTipo==1){
     $("#buscarCliente").hide();
  }
     CargarEntidadesxCliente(ClienteElegido);
});

function CargarEntidadesxCliente(ClienteElegido)
{
 var LineaNegocioElegida = $("#seleccionarLineNegocio").val();
 $("#DivEntidades").show();
 $.ajax({
         type: "POST",
         url: "ajax_CatalogoEntidadesXCliente.php",
         data: {"ClienteElegido": ClienteElegido,"LineaNegocioElegida": LineaNegocioElegida},
         dataType: "json",
          success: function(response) {
            $("#seleccionarEntidad").empty().append('<option value="0">ENTIDAD</option>');
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

$("#seleccionarSupervisor").change(function() {

  $("#buscarEntidad").hide();
  $("#buscarPuntodeServicio").hide();
  $("#buscarSupervisor").show();
  $("#buscarClienteSupervisor").hide();
  $("#DivEntidades").show();
  $("#buscartipoSupervisor").hide();
  $('#seleccionarEntidad').empty().append('<option value="0">ENTIDADES ASIGNADAS</option>');
  $('#seleccionarPuntoServicio').empty().append('<option value="0">PUNTO DE SERVICIO</option>');
  $('#seleccionarClienteSupervisor').empty().append('<option value="0">SELECCIONAR</option>');
  var supervisorElegido = $("#seleccionarSupervisor").val();
  var LineaElegida = $("#seleccionarLineNegocio").val();
  var valorgifTipo = $("#radioNoCOBERTURA").val();
  $("#buscarEntidadParaSupervisores").hide();

  if (supervisorElegido=='0'){
     $("#buscarSupervisor").hide();
      if (valorgifTipo==0) {
         $("#buscarEntidadParaSupervisores").show();
      }
  }else{
    $.ajax({
            type: "POST",
            url: "ajax_obtenerEntidadesXSupervisor.php",
            data: {"supervisorElegido": supervisorElegido,"LineaElegida": LineaElegida,"valorgifTipo": valorgifTipo},
            dataType: "json",
            success: function(response){
              var entidadesTraidas=response.datos;
              var totalEntidades = entidadesTraidas.length;
               if (totalEntidades=='0'  || totalEntidades==0 || totalEntidades=='' || totalEntidades=='NULL' || totalEntidades==null || totalEntidades=='null') 
                {
                 alert("SIN PUNTOS DE SERVICIO ACTIVOS");
                 $("#buscarSupervisor").hide();
                 $("#buscarClienteSupervisor").hide();
                }
              $("#seleccionarEntidad").empty().append('<option value="0">ENTIDADES ASIGNADAS</option>');
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
  }
});

$("#seleccionarEntidad").change(function() {

  $("#buscarCliente").hide();
  $("#buscarSupervisor").hide();
  $("#buscarEntidad").show();
  $("#buscarClienteSupervisor").hide();
  $("#buscarClienteGeneral").hide();
  $("#buscarPuntodeServicio").hide();
  $("#seleccionarPuntoServicio").val("0");
  $('#seleccionarPuntoServicio').empty().append('<option value="0">PUNTO DE SERVICIO</option>');

  var lineaNegocio = $("#seleccionarLineNegocio").val();
  var tipoElegido = $("#seleccionarTipo").val();
  var supervisorele= $("#seleccionarSupervisor").val();
  var ClienteElegido = $("#seleccionarCliente").val();
  var EntidadElegida = $("#seleccionarEntidad").val();
  var puntoSelegido = $("#seleccionarPuntoServicio").val();
  var valorgifTipo = $("#radioNoCOBERTURA").val();
  var EntidadSupervisor = $("#seleccionarEntidadParaSupervisores").val();

  if (tipoElegido==1) {
       if (EntidadElegida==0){
          $("#buscarEntidad").hide();
          $('#seleccionarClienteGeneral').empty().append('<option value="0">CLIENTE</option>');
          $("#buscartipo").show();
        }
       if (EntidadElegida!=0){
          $("#DivClientesXGeneral").show();
          $("#seleccionarClienteGeneral").show();
          $("#buscartipo").hide();
          var LineaNegocioElegida = $("#seleccionarLineNegocio").val();

          $.ajax({
             type: "POST",
             url: "ajax_clientesXentidad.php",
             data: {"LineaNegocioElegida": LineaNegocioElegida,"EntidadElegida": EntidadElegida},
             dataType: "json",
             success: function(response) {
               $("#seleccionarClienteGeneral").empty();  
               $('#seleccionarClienteGeneral').append('<option value="0">CLIENTE</option>');
                 if(response.status == "success"){
                    for(var i = 0; i < response.datos.length; i++){
                         $('#seleccionarClienteGeneral').append('<option value="' + (response.datos[i].idCliente) + '">' + response.datos[i].razonSocial + '</option>');
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
     if (tipoElegido==2 && EntidadElegida==0) {
       $("#buscarEntidad").hide();
         if (valorgifTipo==0) {
            $("#buscarCliente").show();
         }
           if (valorgifTipo==1) {
             alert("SELECCIONE UNA ENTIDAD");
           }
     } 

  if (tipoElegido==2) {//por cliente*
           $("#DivPuntoServicio").show();

              if(EntidadElegida != 0 && EntidadElegida != "ENTIDAD"){
                $.ajax({
                        type: "POST",
                        url: "ajax_PuntoServicioXEntidadyCliente.php",//revisado en pro
                        data: {"EntidadElegida": EntidadElegida, "ClienteElegido": ClienteElegido, "lineaNegocio": lineaNegocio, "valorgifTipo": valorgifTipo},
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
        }
  if(tipoElegido==3){//por supervisor
  $("#DivClientesSupervisor").show();
  $.ajax({
       type: "POST",
       url: "ajax_obtenerClientesXSupervisor.php",
       data: {"EntidadElegida": EntidadElegida, "supervisorele": supervisorele, "lineaNegocio": lineaNegocio, "valorgifTipo": valorgifTipo},
       dataType: "json",
       success: function(response) {
         $("#seleccionarClienteSupervisor").empty();  
         $('#seleccionarClienteSupervisor').append('<option value="0">CLIENTE</option>');
           if(response.status == "success"){
              for(var i = 0; i < response.datos.length; i++){
                   $('#seleccionarClienteSupervisor').append('<option value="' + (response.datos[i].idCliente) + '">' + response.datos[i].razonSocial + '</option>');
              }
           }else{
               alert("Error al cargar Entidades");
             }
       },
     error: function(jqXHR, textStatus, errorThrown){
       alert(jqXHR.responseText);
     }
  });
     $("#buscarClienteSupervisor").hide();
     $("#DivPuntoServicio").show();
  }
if (tipoElegido==3 && EntidadSupervisor!=0 && supervisorele!=0 && EntidadElegida==0) {
     $("#buscarEntidad").hide();
     $("#buscarSupervisor").show();
     $("#buscarEntidadParaSupervisores").hide();
       //alert("5");
  }
});

$("#seleccionarClienteSupervisor").change(function() 
{
  var lineaNegocio = $("#seleccionarLineNegocio").val();
  var supervisorele= $("#seleccionarSupervisor").val();
  var EntidadElegida = $("#seleccionarEntidad").val();
  var clienteElegidoSupervisor = $("#seleccionarClienteSupervisor").val();
  var valorgifTipo = $("#radioNoCOBERTURA").val();
  $("#buscarEntidadParaSupervisores").hide();

  if (clienteElegidoSupervisor==0 || clienteElegidoSupervisor=='0') {
     $("#buscarClienteSupervisor").hide();
     $("#buscarEntidad").show();
     $("#buscarPuntodeServicio").hide();
     $('#seleccionarPuntoServicio').empty().append('<option value="0">PUNTO DE SERVICIO</option>');
   }else{
      $("#buscarClienteSupervisor").show();
      $("#buscarEntidad").hide();
      $("#buscarPuntodeServicio").hide();
           $.ajax({
              type: "POST",
              url: "ajax_PuntoServicioXEntidadSupervisor.php",
              data: {"EntidadElegida": EntidadElegida,"lineaNegocio": lineaNegocio, "supervisorele": supervisorele, "clienteElegidoSupervisor": clienteElegidoSupervisor,"valorgifTipo": valorgifTipo},
              dataType: "json",
              success: function(response){
                $("#seleccionarPuntoServicio").empty().append('<option value="0">PUNTO DE SERVICIO</option>');  
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
});

$("#seleccionarClienteGeneral").change(function(){
  $("#buscarClienteGeneral").show();
  $("#buscarEntidad").hide();
  var clienteGralEle = $("#seleccionarClienteGeneral").val();
    if (clienteGralEle==0) {
       $("#buscarEntidad").show();
       $("#buscarClienteGeneral").hide();
    }
});

$("#seleccionarPuntoServicio").change(function() {
  $("#buscarClienteSupervisor").hide();
  $("#buscarEntidad").hide();
  $("#buscarEntidadParaSupervisores").hide();
  var puntoElegigo= $("#seleccionarPuntoServicio").val();
  var ClienteEle= $("#seleccionarCliente").val();
  var ClienteSupervisor= $("#seleccionarClienteSupervisor").val();
  var entidadEle= $("#seleccionarEntidad").val();
  var tipocliente= $("#seleccionarTipo").val();

  if(puntoElegigo==0 && entidadEle!=0 && ClienteEle!=0 && tipocliente==2){
     //alert("1");
     $("#buscarPuntodeServicio").hide();
     $("#buscarEntidad").show();
    }
  if(puntoElegigo==0 && ClienteSupervisor!=0 && tipocliente==3){
  //alert("2");
     $("#buscarEntidad").hide();
     $("#buscarPuntodeServicio").hide();
     $("#buscarClienteSupervisor").show();
  }
  if(puntoElegigo!=0 && ClienteSupervisor!=0){
     //alert("3");
     $("#buscarPuntodeServicio").show();
    }
});

function GraficaCoberturaTurnos(){
waitingDialog.show();
var lineaNegocioElegido = $("#seleccionarLineNegocio").val();
var tipoElegido = $("#seleccionarTipo").val();
var clienteElegido = $("#seleccionarCliente").val();
var entidadElegida = $("#seleccionarEntidad").val();
var PuntoServElegido = $("#seleccionarPuntoServicio").val();
var supervisorElegido = $("#seleccionarSupervisor").val();
var fechaInicioElegida = $("#inputFechaInicio").val();
var fechaFinElegida = $("#inputFechaFin").val();
var clienteElegidoSuperv = $("#seleccionarClienteSupervisor").val();
var clienteElegidoGral = $("#seleccionarClienteGeneral").val();
var entidadSupervisores = $("#seleccionarEntidadParaSupervisores").val();
var tipoBusqueda=0;
var valorgif = $("#radioNoCOBERTURA").val();
  
if(fechaInicioElegida ==0 || fechaFinElegida ==0) 
  {
    waitingDialog.hide();
   alert("ingrese Fechas");
  }
  else if(fechaInicioElegida > fechaFinElegida)
  {
   waitingDialog.hide();
   alert("La fecha de inicio elegida no puede ser mayor a la fecha final");
  }
  else if (lineaNegocioElegido=="0")
  {
    waitingDialog.hide();
   alert("Seleccione una linea de negocio");
  }
  else{
       var coberturapuntoServicioId = $("#seleccionarPuntoServicio").val();
       var coberturafechaInicial = $("#inputFechaInicio").val();
       var coberturafechaFinal = $("#inputFechaFin").val();

       $("#DivGraficaCobertura").show();
       $("#DivGraficaCobertura1").show();
       $("#DivGraficaCoberturaSupervisor").show();
       var canvas = "<canvas id='CanvasGraficaCobertura' name='CanvasGraficaCobertura'></canvas>";
       var canvas1 = "<canvas id='CanvasGraficaConteoTurnos' name='CanvasGraficaConteoTurnos'></canvas>";
       var canvas2 = "<canvas id='CanvasGraficaPorcentajeCobertura' name='CanvasGraficaPorcentajeCobertura'></canvas>";
       var canvasSupervisor = "<canvas id='CanvasGraficaCoberturaSupervisor' name='CanvasGraficaCoberturaSupervisor'></canvas>";
       $('#DivGrafCob').html(canvas); 
       $('#DivGrafConteoTurnos').html(canvas1); 
       $('#DivGrafPorcentajeCobertura').html(canvas2); 
       $('#DivGrafCobSupervisor').html(canvasSupervisor); 

      if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1 && entidadElegida ==0 && valorgif==0)
        {//buscar tipo general
         // alert("1");
            tipoBusqueda=1;
           var coberturapuntoServicioId=0;
           var clienteElegido=0;
           var entidadElegida=0;
           var supervisorElegido=0;    
           var clienteElegidoSuperv=0;    
        }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida ==0 && (PuntoServElegido ==0 || PuntoServElegido =="null" || PuntoServElegido ==  null && valorgif==0))
      {//Xcliente
       // alert("2");
            tipoBusqueda=2;
           var coberturapuntoServicioId=0;
           var entidadElegida=0;
           var supervisorElegido=0;  
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido ==0 && valorgif==0)
      {//busqueda cliente y entidad
       // alert("3");
            tipoBusqueda=3;
           var supervisorElegido=0;
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido !=0 && valorgif==0)
      { //busqueda punto-Cliente
        // alert("4");
            tipoBusqueda=4;    
           var supervisorElegido=0; 
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida ==0 && clienteElegidoSuperv==0 && (PuntoServElegido ==0 || PuntoServElegido =="null" || PuntoServElegido ==null) && valorgif==0)
      {// buscar por supervisor
        // alert("5");
            tipoBusqueda=5;
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv==0 && PuntoServElegido ==0 && valorgif==0)
      {//Xsup-entidad
       // alert("6");
            tipoBusqueda=6; 
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv!=0 && PuntoServElegido ==0 && valorgif==0)
      {//Xsup,entidad,cliente
        // alert("7");
            tipoBusqueda=7; 
      } 

      else if(fechaInicioElegida != 0 && fechaFinElegida != 0 && lineaNegocioElegido != 0 && tipoElegido == 3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv!=0 && PuntoServElegido !=0 && valorgif==0 && entidadSupervisores!=0)
      {//punto sup
        // alert("8");
            tipoBusqueda=8;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1 && entidadElegida !=0 && valorgif==0  && clienteElegidoGral==0)
      {//general entidad
        // alert("9");
            tipoBusqueda=9;
           var coberturapuntoServicioId=0;
           var clienteElegido=0;
           var supervisorElegido=0;    
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1 && entidadElegida ==0 && valorgif==1)
      {//GRAL GIF
        // alert("10");
            tipoBusqueda=10;
           var coberturapuntoServicioId=0;
           var clienteElegido=0;
           var entidadElegida=0;
           var supervisorElegido=0;    
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1 && entidadElegida !=0 && valorgif==1)
      {//general entidades GIF
        // alert("11");
            tipoBusqueda=11;
           var coberturapuntoServicioId=0;
           var clienteElegido=0;
           var supervisorElegido=0;    
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido ==0 && valorgif==1)
      {//cliente y entidad gif
        // alert("12");
            tipoBusqueda=12;
           var supervisorElegido=0;
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==2 && clienteElegido !=0 && entidadElegida !=0 && PuntoServElegido !=0 && valorgif==1)
      { //punto-Cliente GIF
        // alert("13");
            tipoBusqueda=13;    
           var supervisorElegido=0; 
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida ==0 && clienteElegidoSuperv==0 && (PuntoServElegido ==0 || PuntoServElegido =="null" || PuntoServElegido ==null) && valorgif==1)
      {//supervisor GIF
      // alert("14");
            tipoBusqueda=14;
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv!=0 && PuntoServElegido ==0 && valorgif==1)
      {//sup,entidad,cliente GIF
      // alert("15");
            tipoBusqueda=15; 
      } 

      else if(fechaInicioElegida != 0 && fechaFinElegida != 0 && lineaNegocioElegido != 0 && tipoElegido == 3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv!=0 && PuntoServElegido !=0 && valorgif==1)
      {//punto sup gif
       // alert("16");
            tipoBusqueda=16;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido !=0 && entidadElegida !=0 && clienteElegidoSuperv==0 && PuntoServElegido ==0 && valorgif==1)
      {//Xsup-entidadGIF
       // alert("17");
            tipoBusqueda=17; 
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==1 && entidadElegida !=0 && valorgif==0 && clienteElegidoGral!=0)
      {//general entidad-cliente
        // alert("18");
            tipoBusqueda=18;
           var coberturapuntoServicioId=0;
           var clienteElegido=0;
           var supervisorElegido=0;    
           var clienteElegidoSuperv=0;    
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && valorgif==0 && entidadSupervisores==0)
      {// buscar por supervisor general
       // alert("19");
            tipoBusqueda=19;
      }

      else if(fechaInicioElegida !=0 && fechaFinElegida !=0 && lineaNegocioElegido !=0 && tipoElegido ==3 && supervisorElegido ==0 && valorgif==0 && entidadSupervisores!=0)
      {// buscar por supervisor general
        //alert("20");
            tipoBusqueda=20;
      }
 }
 if (tipoBusqueda ==19 || tipoBusqueda ==20) {
       GraficaCoberturaSupervisor(coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,entidadSupervisores);
   }
   else{
       GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido,clienteElegidoSuperv,clienteElegidoGral);
       //alert("sup");
   }
}

function GraficaCobertura(coberturapuntoServicioId,coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,clienteElegido,entidadElegida,supervisorElegido,clienteElegidoSuperv,clienteElegidoGral){
  $.ajax({
          type: "POST",
          url: "ajax_ConteoTurnosXDia.php",
          data:{"coberturapuntoServicioId":coberturapuntoServicioId,"coberturafechaInicial":coberturafechaInicial,"coberturafechaFinal":coberturafechaFinal,"tipoBusqueda":tipoBusqueda,"lineaNegocioElegido":lineaNegocioElegido,"clienteElegido":clienteElegido,"entidadElegida":entidadElegida,"supervisorElegido":supervisorElegido,"clienteElegidoSuperv":clienteElegidoSuperv,"clienteElegidoGral":clienteElegidoGral},
          dataType: "json",
          async:false,
          success:function(response) {
          waitingDialog.hide();
          var fechas = [];
          var coberturaNoche = [];
          var coberturaDía = [];
          var coberturaNocheCumplida = [];
          var coberturaDiaCumplida = [];
          var prcentajeTotalTunos = [];
          var turnosPorDia = [];
          var turnosCubiertos = [];
          var turnosPorDia1 = [];
          var turnosCubiertos1 = [];
          var datosGrafica= response.result;
          var inicial=coberturafechaInicial.split("-");
          var final=coberturafechaFinal.split("-");
          var dateStart=new Date(inicial[0],(inicial[1]-1),inicial[2]);
          var dateEnd=new Date(final[0],(final[1]-1),final[2]);

          resultado=(((dateEnd-dateStart)/86400)/1000);

          turnosPorDia1=response.result.turnosPorDia1;
          turnosCubiertos1=response.result.turnosCubiertos1;

          turnosdenocheGenerales1=response.result.turnosdenocheGenerales;
          turnosGeneralCubiertosNoche=response.result.turnosGeneralCubiertosNoche;

          turnoDeDiaGeneral=response.result.turnoDeDiaGeneral;
          turnosCubiertosDiaGeneral=response.result.turnosCubiertosDiaGeneral;

          var porcentaje =(turnosCubiertos1/turnosPorDia1)*100;
          var porcentajeGeneral= porcentaje.toFixed(0); 

          var porcentajeDia =(turnosCubiertosDiaGeneral/turnoDeDiaGeneral)*100;
          var porcentajeGeneralDia= porcentajeDia.toFixed(0); 

          var porcentajeNoche =(turnosGeneralCubiertosNoche/turnosdenocheGenerales1)*100;
          var porcentajeGeneralNoche= porcentajeNoche.toFixed(0); 

          for(var i=0; i<resultado+1; i++){
            
            if(i==0)
            {
              var fechasfor = (response.result[coberturafechaInicial]);
              var aa = coberturafechaInicial;
            }else
                 {
                  var fecha = new Date($('#inputFechaInicio').val());
                  fecha.setDate(fecha.getDate() + i+1);
                  var anioA = fecha.getFullYear();
                  var mesA = (fecha.getMonth() + 1);
                  var diaA = fecha.getDate();

                  if(mesA <= 9)
                  {
                     mesAA = "0"+mesA;
                  }else
                      {
                       mesAA=mesA;
                      }
                  if(diaA <= 9)
                    {
                     diaAA = "0"+diaA;
                    }else
                         {
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
             prcentajeTotalTunos.push(fechasfor["PrcentajeTotalTunos"]);
             turnosPorDia.push(fechasfor["turnosPorDia"]);
             turnosCubiertos.push(fechasfor["turnosCubiertos"]);
          }
                          var graficaCanvasCobertura = document.getElementById("CanvasGraficaCobertura"); 
                          var ctx = document.getElementById("CanvasGraficaConteoTurnos");
                          var ctx1 = document.getElementById("CanvasGraficaPorcentajeCobertura");

                          Chart.defaults.global.defaultFontFamily = "Lato";
                          Chart.defaults.global.defaultFontSize = 18;

                          var totalCoberturaDia = {
                              label: 'Petición Cobertura Día(ventas)',
                              data: coberturaDía,
                              backgroundColor: 'rgba(241, 219, 28, 1)',         
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };
                          var totalCoberturaNoche = {
                              label: 'Petición Cobertura Noche(ventas)',
                              data: coberturaNoche,
                              backgroundColor: 'rgba(25, 39, 254, 1)',          
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };
                          var totalCoberturaDiaCum = {
                              label: 'Cobertura Día',
                              data: coberturaDiaCumplida,
                              backgroundColor: 'rgba(210, 179, 0, 1)',
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };  
                          var totalCoberturaNocheCum = {
                              label: 'Cobertura Noche',
                              data: coberturaNocheCumplida,
                              backgroundColor: 'rgba(10, 14, 73, 1)',
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };

                          var porcentajeCobertura = {
                              label: 'Porcentaje Cumplido',
                              data: prcentajeTotalTunos,
                              borderColor: 'red',
                              backgroundColor: 'rgba(254, 25, 25, 1)',
                              type: 'line',
                              fill: false,
                              lineTension: 0,
                              pointRadius: 10,
                              yAxisID: "barPorcentaje"
                          };
 
                          var datoselementos = {
                              labels: fechas,
                              datasets: [totalCoberturaDia, totalCoberturaDiaCum, totalCoberturaNoche, totalCoberturaNocheCum, porcentajeCobertura]
                          };

                          var chartOptions = {
                            scaleUse2Y: true,
                               scales: {                  
                                  yAxes: [{
                                          id: "barElementosReclutados",
                                          ticks:{beginAtZero: true}                                 
                                        },{ scaleLabel: {
                                                         display: true,
                                                         labelString: "Porcentaje de cobertura",
                                                         fontColor: "red"
                                                        },
                                                          id: "barPorcentaje",
                                                          ticks:{beginAtZero: true,
                                                               fontColor: 'red',
                                                               callback: function(value) 
                                                                       {
                                                                        return value + "%"
                                                                        }   
                                                             },
                                                             gridLines: {
                                                                color: "red",
                                                                borderDash: [2, 5],
                                                                },
                                                         }]
                                        }
                          };       

                          var barChart = new Chart(graficaCanvasCobertura, {
                            type: 'bar',
                            data: datoselementos,
                            options: 
                            chartOptions
                          }); 

                          var myChart1 = new Chart(ctx, {
                              type: 'bar',
                              data:{
                              labels:  ['Total de turnos(ventas)', 'Total de turnos cobertura'],
                              datasets:[{
                              data: [turnosPorDia1, turnosCubiertos1],
                              backgroundColor:[
                              'rgba(37, 213, 234, 1)',
                              'rgba(12, 126, 140, 1)'], 
                               borderColor:[
                              'rgba(37, 213, 234, 1)',
                              'rgba(12, 126, 140, 1)'],
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
                                    },
                                    title: {
                                            display: true,
                                            text: 'Conteo de turnos por rango de fechas elegidas',
                                            fontSize: 30,
                                            fontFamily: "candara",
                                            fontColor: '#000',  
                                            position: 'top',
                                          }
                                }
                          });

                          var myChart1 = new Chart(ctx1, {
                              type: 'pie',
                              data:{
                              labels:  ['Porcentaje general de cobertura %','Porcentaje cobertura día %', 'Porcentaje cobertura noche %'],
                              datasets:[{
                              data: [porcentajeGeneral,porcentajeGeneralDia, porcentajeGeneralNoche],
                              backgroundColor:[
                              'rgba(58, 188, 51, 1)',
                              'rgba(210, 179, 0, 1)',
                              'rgba(10, 14, 73, 1)'], 
                               borderColor:[
                              'rgba(58, 188, 51, 1)',
                              'rgba(210, 179, 0, 1)',
                              'rgba(10, 14, 73, 1)'],
                                    borderWidth: 1
                                    }]
                               },
                                options: {
                                    title: {
                                           display: true,
                                           text: 'Porcentaje de cobertura general por fechas',
                                           fontSize: 30,
                                           fontFamily: "candara",
                                           fontColor: '#000',  
                                           position: 'top',
                                           }
                                }
                          });
                         waitingDialog.hide();
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
        });
}

function GraficaCoberturaSupervisor(coberturafechaInicial,coberturafechaFinal,tipoBusqueda,lineaNegocioElegido,entidadSupervisores){
  var valorgifTipo = $("#radioNoCOBERTURA").val();
          
  $.ajax({
          type: "POST",
          url: "ajax_PorcentajeCoberturaSupervisor.php",
          data:{"coberturafechaInicial":coberturafechaInicial,"coberturafechaFinal":coberturafechaFinal,"tipoBusqueda":tipoBusqueda,"lineaNegocioElegido":lineaNegocioElegido,"valorgifTipo":valorgifTipo,"entidadSupervisores":entidadSupervisores},
          dataType: "json",
          async:false,
          success:function(response){
          waitingDialog.hide();
          var turnoDeDiaGeneral = [];
          var turnosdenocheGenerales = [];
          var turnosCubiertosDiaGeneral = [];
          var turnosGeneralCubiertosNoche = [];
          var porcentajeTotalCubierto = [];
          var nombresupervisor = [];
          var largo= response.result;
        for (var i = 0; i < largo.length; i++) {
             turnoDeDiaGeneral.push(response.result[i]["turnoDeDiaGeneral"]);         
             turnosdenocheGenerales.push(response.result[i]["turnosdenocheGenerales"]);
             turnosCubiertosDiaGeneral.push(response.result[i]["turnosCubiertosDiaGeneral"]);
             turnosGeneralCubiertosNoche.push(response.result[i]["turnosGeneralCubiertosNoche"]);
             porcentajeTotalCubierto.push(response.result[i]["porcentajeTotalCubierto"]);
             nombresupervisor.push(response.result[i]["NombreSupervisor"]);
          }
                          var graficaCanvasCoberturaSupervisores = document.getElementById("CanvasGraficaCoberturaSupervisor"); 

                          Chart.defaults.global.defaultFontFamily = "Lato";
                          Chart.defaults.global.defaultFontSize = 18;

                          var totalCoberturaDia = {
                              label: 'Petición Cobertura Día(ventas)',
                              data: turnoDeDiaGeneral,
                              backgroundColor: 'rgba(241, 219, 28, 1)',         
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };
                          var totalCoberturaNoche = {
                              label: 'Petición Cobertura Noche(ventas)',
                              data: turnosdenocheGenerales,
                              backgroundColor: 'rgba(25, 39, 254, 1)',          
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };
                          var totalCoberturaDiaCum = {
                              label: 'Cobertura Día',
                              data: turnosCubiertosDiaGeneral,
                              backgroundColor: 'rgba(210, 179, 0, 1)',
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };  
                          var totalCoberturaNocheCum = {
                              label: 'Cobertura Noche',
                              data: turnosGeneralCubiertosNoche,
                              backgroundColor: 'rgba(10, 14, 73, 1)',
                              yAxisID: "barElementosReclutados",
                              order: 1
                          };

                          var porcentajeCobertura = {
                              label: 'Porcentaje Cumplido',
                              data: porcentajeTotalCubierto,
                              borderColor: 'red',
                              backgroundColor: 'rgba(254, 25, 25, 1)',
                              type: 'line',
                              fill: false,
                              lineTension: 0,
                              pointRadius: 10,
                              yAxisID: "barPorcentaje"
                          };
 
                          var datoselementos = {
                              labels: nombresupervisor,
                              datasets: [totalCoberturaDia, totalCoberturaDiaCum, totalCoberturaNoche, totalCoberturaNocheCum, porcentajeCobertura]
                          };

                          var chartOptions = {
                            scaleUse2Y: true,
                               scales: {                  
                                  yAxes: [{

                                          id: "barElementosReclutados",
                                          ticks:{beginAtZero: true}                                 
                                        },{ scaleLabel: {
                                                       display: true,
                                                       labelString: "Porcentaje de cobertura",
                                                       fontColor: "red"
                                                     },
                                                       id: "barPorcentaje",
                                                       ticks:{beginAtZero: true,
                                                               fontColor: 'red',
                                                               callback: function(value) 
                                                                       {
                                                                          return value + "%"
                                                                        }   
                                                             },
                                                             gridLines: {
                                                                color: "red",
                                                                borderDash: [2, 5],
                                                                },
                                                         }]
                                        }
                          }; 

                          var barChart = new Chart(graficaCanvasCoberturaSupervisores, {
                            type: 'bar',
                            data: datoselementos,
                            options: 
                            chartOptions
                          }); 

                           waitingDialog.hide();
              },
              error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
              }
        });
}


</script>



