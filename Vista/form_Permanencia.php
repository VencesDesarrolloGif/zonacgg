<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>
<div id="divMensajePermanencia"></div>   
<center><h1>PERMANENCIA</h1></center>
</head>
  <br><br>
    <center>
       <div id="DivLineaNegocioPermanencia">
         <select id="seleccionarLineNegocioPermanencia" name="seleccionarLineNegocioPermanencia"></select><br>
       </div>
      <br>
       <div id="DivTotalEmpleados" style="display: none;">
                      Total: <input type="text" class="input-medium" readonly id="inputTotal"           name="inputTotal"> 
                 Operativos: <input type="text" class="input-medium" readonly id="inputOperativoa"      name="inputOperativoa">
            Administrativos: <input type="text" class="input-medium" readonly id="inputAdministrativos" name="inputAdministrativos">
  Porcentaje de Permanencia: <input type="text" class="input-medium" readonly id="inputProcentaje"      name="inputProcentaje">
       </div>
      <br>
       
       <div id="DivSelectorTipoPermanencia" style="display: none;">
          <select name="seleccionarTipoEmpPer" id="seleccionarTipoEmpPer">
           <option value="0">TIPO</option>
           <option value="1">ADMINISTRATIVOS</option>
           <option value="2">OPERATIVOS</option>
          </select>
       </div>

       <div id="DivFechaPermanencia" style="display: none;">
            DE:<input id="inputFechaInicioPermanencia" placeholder="Seleccione Fecha" name="inputFechaInicioPermanencia" type="text" class="input-medium"> 
            A: <input id="inputFechaFinPermanencia"    placeholder="Seleccione Fecha" name="inputFechaFinPermanencia"    type="text" class="input-medium">
       </div>
      <br>
        <img id="BTNBuscarPermanencia" title="Buscar Permanencia" src="img/botonbuscar.jpg" width="125px" style="display: none;">
    </center>
      <br>

   <div id="divTablaPermanencia" style="display: none;">
    <table id="tablaPermanenciaEmpleados"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                <th style="text-align: center;background-color: #B0E76E">Entidad Trabajo</th>
                <th style="text-align: center;background-color: #B0E76E">Punto de Servicio</th>
                <th style="text-align: center;background-color: #B0E76E">Número Supervisor</th>
                <th style="text-align: center;background-color: #B0E76E">Nombre Supervisor</th>
                <th style="text-align: center;background-color: #B0E76E">Estatus</th>       
                <th style="text-align: center;background-color: #B0E76E">Fecha Alta</th>
                <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th> 
                <th style="text-align: center;background-color: #B0E76E">Días de Permanencia</th> 
                <th style="text-align: center;background-color: #B0E76E">Cobertura Generada De su Ingreso Al Día De Hoy</th>
            </tr>
        </thead>
    </table>
  </div>
<script type="text/javascript">

$(inicioPermanencia());  

function inicioPermanencia(){
   CargarSelectorLineaNegocio();
}

$("#seleccionarLineNegocioPermanencia").change(function(){
  $("#DivTotalEmpleados").show();
  $("#DivFechaPermanencia").hide();
  $("#BTNBuscarPermanencia").hide();
  $("#DivSelectorTipoPermanencia").show();
  $("#seleccionarTipoEmpPer").val(0);
  $("#inputFechaInicioPermanencia").val("");
  $("#inputFechaFinPermanencia").val("");
  $("#divTablaPermanencia").hide();
  consultarTotalEmpleados();
});

$("#seleccionarTipoEmpPer").change(function(){
  $("#DivFechaPermanencia").show();
  $("#BTNBuscarPermanencia").show();
$("#divTablaPermanencia").hide();
  cargarInputFechas();
});


$("#BTNBuscarPermanencia").click(function(){
  var tipoBusquedaPermanencia = $("#seleccionarTipoEmpPer").val();
  var fechai= $("#inputFechaInicioPermanencia").val();
  var fechaf= $("#inputFechaFinPermanencia").val();
  var lineaNeg = $("#seleccionarLineNegocioPermanencia").val();
  var mansaje="";

  if(((fechai!=0 && fechai!="" && fechai!=null && fechai!="null" && fechai!="NULL") && (fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL")) && fechai <= fechaf){
     //alert("1");
     waitingDialog.show();    
     consultaPermanencia(fechai,fechaf,lineaNeg,tipoBusquedaPermanencia);
    }

  if((fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL") && (fechai==0 || fechai=="" || fechai==null || fechai=="null" || fechai=="NULL")){
   //alert("2");
     mansaje ="ingrese Fecha inicial";
     cargarmensajeerrorPermanencia(mansaje);
    }

  if((fechai!=0 && fechai!="" && fechai!=null && fechai!="null" && fechai!="NULL") && (fechaf==0 || fechaf=="" || fechaf==null || fechaf=="null" || fechaf=="NULL")){
     //alert("3");
     mansaje ="ingrese Fecha final";
     cargarmensajeerrorPermanencia(mansaje);
    }

  if((fechai==0 || fechai=="" || fechai==null || fechai=="null" || fechai=="NULL") && (fechaf==0 || fechaf=="" || fechaf==null || fechaf=="null" || fechaf=="NULL")){
     //alert("4");
     mansaje ="Ingrese Fechas";
     cargarmensajeerrorPermanencia(mansaje);
    }

  if((fechai > fechaf) && (fechaf!=0 && fechaf!="" && fechaf!=null && fechaf!="null" && fechaf!="NULL")){
     //alert("5");
     mansaje ="La fecha de inicio elegida no puede ser mayor a la fecha final";
     cargarmensajeerrorPermanencia(mansaje);
    }
});

function consultaPermanencia(fechai,fechaf,lineaNeg,tipoBusquedaPermanencia){

  tablaPermanencia = [];
  var sumaDiasPermanenciaEmp=0;
  var diasPermanenciaEmpleado=0;
  $.ajax({
          type: "POST",
          url: "ajax_ConsultaPermanencia.php",
          data:{"fechai":fechai,"fechaf":fechaf,"lineaNeg":lineaNeg,"tipoBusquedaPermanencia":tipoBusquedaPermanencia},
          dataType: "json", 
          success: function(response){
            if(response.status == "success"){
              var diasDePermanenciaRequeridos = response["diasPermanenciaRequerida"];
              var TotalDiasRequeridosXEmpleado =90;//es estatico ya que asi se ppidio

              for(var i = 0; i < response.datos.length; i++){

                  var fechaIngresoEmpleado = response.datos[i]["fechaIngresoEmpleado"];
                  var fechaBajaEmp1 = response.datos[i]["fechaBajaEmpleado1"];
                  var fechaHoy = new Date();
                  var fechaActual=(fechaHoy.getFullYear() + "-" + (fechaHoy.getMonth() +1) + "-" + fechaHoy.getDate());

                  if(fechaBajaEmp1=="-"){
                     var fechaBajaEmpleado = fechaActual;
                    }else{
                          var fechaBajaEmpleado = response.datos[i]["fechaBajaEmpleado"];
                         }
                  var diaInicio = new Date(fechaIngresoEmpleado);
                  var diaFin = new Date(fechaBajaEmpleado);
                  var difference= Math.abs(diaFin-diaInicio);
                  var LargoFecha1 = difference/86400000;
                  var diasDePermanencia = Math.round(LargoFecha1);

                  response.datos[i]["diasDePermanencia"] = diasDePermanencia;

                  if(diasDePermanencia >= TotalDiasRequeridosXEmpleado) {
                      diasPermanenciaEmpleado=90;
                    }else{
                          diasPermanenciaEmpleado=diasDePermanencia;
                         }
                  sumaDiasPermanenciaEmp= sumaDiasPermanenciaEmp+diasPermanenciaEmpleado;
                  var record = response.datos[i];
                  tablaPermanencia.push(record);
              }
                 calculoPorcentaje = (sumaDiasPermanenciaEmp/diasDePermanenciaRequeridos)*100;
                 var porcentajePermanencia= calculoPorcentaje.toFixed(0); 
                 $("#inputProcentaje").val(porcentajePermanencia + '%');
                 $("#divTablaPermanencia").show();
                 CargarTablaPermanencia(tablaPermanencia);
            }else{
                 var mensaje = response.message;
                 }
                 waitingDialog.hide();    
            },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 var tablaPer = null;

 function CargarTablaPermanencia(data) {
  
  if(tablaPer != null) {
      tablaPer.destroy();
    }
  
   tablaPer = $('#tablaPermanenciaEmpleados').DataTable({
    "language":{
               "emptyTable": "No hay registro disponible",
               "info": "Del _START_ al _END_ de _TOTAL_",
               "infoEmpty": "Mostrando 0 registros de un total de 0.",
               "infoFiltered": "(filtrados de un total de _MAX_ registros)",
               "infoPostFix": "(actualizados)",
               "lengthMenu": "Mostrar _MENU_ registros",
               "loadingRecords": "Cargando....",
               "processing": "Procesando....",
               "search": "Buscar:",
               "searchPlaceholder": "Dato para buscar",
               "zeroRecords": "no se han encontrado coincidencias",
               "paginate":{
                          "first": "Primera",
                          "last": "Ultima",
                          "next": "Siguiente",
                          "previous": "Anterior"
                         },
               "aria":{
                       "sortAscending": "Ordenación ascendente",
                       "sortDescending": "Ordenación descendente"
                      }
         },
   data: data,
   destroy: true,
   "columns": [{"data": "NumeroEmpleado"},
             {"data": "NombreEmpleado"},
             {"className": "dt-body-center","data": "EntidadTrabajo"},
             {"className": "dt-body-center","data": "puntoServicio"},
             {"data": "NoSupervisor"},
             {"data": "SupervisorNombre"},
             {"className": "dt-body-center","data": "empleadoEstatus"},
             {"className": "dt-body-center","data": "fechaIngresoEmpleado"},
             {"className": "dt-body-center","data": "fechaBajaEmpleado"},
             {"className": "dt-body-center","data": "diasDePermanencia"},
             {"data": "cobertura"},],
   processing: true,
   dom: 'Bfrtip',
   buttons:{
           buttons: ['excel']
          }
  });
}

function consultarTotalEmpleados(){
$("#inputProcentaje").val(0 + '%');
var lineaNegPermanencia = $("#seleccionarLineNegocioPermanencia").val();
$.ajax({
        type: "POST",
        url: "ajax_ConsultaTotalEmpleados.php",
        data:{"lineaNegPermanencia":lineaNegPermanencia},
        dataType: "json",
        success: function(response){
            if(response.status == "success"){
             
             var totalEmpleados = response.totalEmpleados
             var totalOperativos = response.totalOperativos;
             var totalAdministrativos = response.totalAdministrativos;

             $("#inputTotal").val(totalEmpleados);
             $("#inputOperativoa").val(totalOperativos);
             $("#inputAdministrativos").val(totalAdministrativos);
            }else{
              alert("Error al cargar total empleados");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
        }
  });
}

 function CargarSelectorLineaNegocio(){

$.ajax({
        type: "POST",
        url: "ajax_obtenerLineasdeNegocio.php",
        dataType: "json",
        success: function(response){
          $("#seleccionarLineNegocioPermanencia").empty();  
          $('#seleccionarLineNegocioPermanencia').append('<option value="0">LINEA DE NEGOCIO</option>');
            if(response.status == "success"){
              for(var i = 0; i < response.valor.length; i++){
                  $('#seleccionarLineNegocioPermanencia').append('<option value="'+(response.valor[i].idLineaNegocio)+'">'+response.valor[i].descripcionLineaNegocio+'</option>');
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


 function cargarInputFechas(){

$('#inputFechaInicioPermanencia').datetimepicker({   
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });

$('#inputFechaFinPermanencia').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });
}

function cargarmensajeerrorPermanencia(mensaje){
  $('#divMensajePermanencia').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-error'><strong>Error:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajePermanencia").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajePermanencia').delay(3000).fadeOut('slow');
}


















 </script>