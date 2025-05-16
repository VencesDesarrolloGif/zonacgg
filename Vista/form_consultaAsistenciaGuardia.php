<?php
    require_once ("../Negocio/Negocio.class.php");
    $negocio = new Negocio ();
    //$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
    //$diasAsistencia2="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Iniciar Sesion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le stylesheet -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
  <link href="css/animate-custom.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
  <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
                    <!--<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>-->
  <script type="text/javascript" src="js/bootstrap-checkbox.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <script type="text/javascript" language="javascript" src="js/dataTables.keyTable.js"></script>
  <script type="text/javascript" language="javascript" src="js/sketch.min.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.contextmenu.r2.packed.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.contextmenu.r2.js"></script>
  <script type="text/javascript" language="javascript" src="js/tooltipster.bundle.min.js"></script>
  <script src="js/jquery.datetimepicker.full.js"></script>
  <script src="js/bootstrap-waitingfor.js" type="text/javascript"></script> 
  <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>

</head>
<body>

 <div class="container">
  <form>
    <center>

      <p><h4>¡Ingrese el correo electrónico que proporciono en su contratación!</h4></p>
      <div class="input-prepend">
        <span class="add-on">Correo electrónico</span>
        <input class="input-large-email" id="txtCorreoElectronicoConsulta" name="txtCorreoElectronicoConsulta" type="text" placeholder="ejemplo@correo.com" >
        <button class="btn btn-success" type="button" onclick="tableEmpleadosByCorreo();"> <span class="glyphicon glyphicon-download-alt"></span>Consultar</button>
      </div>

      <div class="well">
        <div class="row">
          <div class="span3" id="divImg" name="divImg"></div>
          <div class="span14">
            <div class="col-md-4">
              <div class="input-prepend">
                <span class="add-on">No. Empleado</span>
                <input class="input-small" id="txtNumeroGuardia" name="txtNumeroGuardia" type="text" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-prepend">
                <span class="add-on">Nombre</span>
                <input class="input-large" id="txtNombreGuardia" name="txtNombreGuardia" type="text" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-prepend">
                <span class="add-on">Supervisor</span>
                <input class="input-large" id="txtSupervisorGuardia" name="txtSupervisorGuardia" type="text" disabled>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-prepend">
                <span class="add-on">Punto servicio</span>
                <input class="input-large" id="txtPuntoServicioGuardia" name="txtPuntoServicioGuardia" type="text" disabled>
              </div>
            </div>
            <p><h4>¡Consulta tu asistencia!</h4></p>
            <strong>DEL:</strong><input id="txtFecha1ConsultaGuardia" name="txtFecha1ConsultaGuardia" type="text" class="input-medium"> <strong>AL:</strong> <input id="txtFecha2ConsultaGuardia" name="txtFecha2ConsultaGuardia" type="text" class="input-medium"><button class="btn btn-success" type="button" onclick="getAsistenciaGuardiaIdByFecha();"> <span class="glyphicon glyphicon-download-alt"></span>Consultar</button>
          </div><!-- termina div span 12 -->
        </div> <!-- termina div row -->
        


        
      </div> <!-- termina div well -->
      <div id="alertMensajeAsistencia"></div>
      <div id="divDetalleAsistencia" name="divDetalleAsistencia">
        <table class="table table-bordered" id="tableConsultaAsistenciaGuardia" name="tableConsultaAsistenciaGuardia">
            <tr>
              <th>Fecha Asistencia</th>
              <th>Incidencia</th>
              <th>Punto Servicio</th>
              <th>Hora Asistencia APP</th>
              <th>Fecha Registro Asistencia</th>
              <th>Comentario</th>
            </tr>
        </table>
      </div>
      <!-- Modal para mostrar posibles errores en consultas -->
      <div  class="modal fade" role="dialog" id="divErrorConsultaAsistenciaGuardia">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Error al consultar asistencia</h4>
            </div>
            <div class="modal-body">
              <div id="divMensajeErrorConsultaAsistencia"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- termina modal de posibles errores en consulta del guardia-->




    </center>

    <!-- Modal  envio comentario-->
    <div id="divEnvioComentario" name="divEnvioComentario" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
  
  
   <div class="modal-header">
    

      <h4 class="modal-title">Para brindarte la mejor atención trata de ser lo más detallado en la redacción de tu comentario.</h4>
      <div id="alertMsgEnvioComentario"> 
    </div>
    </div>

    <div class="modal-body">


        <div class="input-prepend">
          <span class="add-on">No. Empleado</span>
          <input id="txtNumeroGuardiaComentario" name="txtNumeroGuardiaComentario" type="text" class="input-medium" readonly >
          <input id="txtSupervisorGuardiaComentario" name="txtSupervisorGuardiaComentario" type="hidden" class="input-large" maxlength="14">
        </div>
        <div class="input-prepend">
          <span class="add-on">Nombre</span>
          <input id="txtNombreComentario" name="txtNombreComentario" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Comentario</span>
          Comentario:<textarea class="txtAreaIncidencia" id="txtComentarioGuardia" name="txtComentarioGuardia" rows="5"></textarea>
        </div>
   
      </div>
      <div class="modal-footer" id="footerBajaEmpleado">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick='sendMessage();'>Enviar comentario</button>
      </div>
    </div>  <!-- FIN MODAL envio comentario-->

    
  </form>
   
 </div>
    
</body>
<script type="text/javascript">
    //$("#txtCorreoElectronicoConsulta").val("luci_antonia@gmail.com");

    var stylesConsultaAsitencia = [];

    stylesConsultaAsitencia ["DES"] = "background-color:#FEFF00";
    stylesConsultaAsitencia ["F"] = "background-color:#FA5858";
    stylesConsultaAsitencia ["PER"] = "background-color:#01AFF5";
    stylesConsultaAsitencia ["V/P"] = "background-color:#538136";
    stylesConsultaAsitencia ["V/D"] = "background-color:#538136";
    stylesConsultaAsitencia ["INC"] = "background-color:#90D24B";
    stylesConsultaAsitencia ["F"] = "background-color:#FE2E2E";
    stylesConsultaAsitencia ["B"] = "background-color:#FF0000";
    stylesConsultaAsitencia ["ING"] = "background-color:#BDBDBD;";
    stylesConsultaAsitencia ["DT12"] = "background-color:#FEFF00";
    stylesConsultaAsitencia ["1"] = "background-color:#FFFFFF";
    stylesConsultaAsitencia ["2"] = "background-color:#FFFFFF";
    stylesConsultaAsitencia ["V/P2"] = "background-color:#538136";
    stylesConsultaAsitencia ["V/D2"] = "background-color:#538136";

var empleadoEstatusId="";
var numeroEmpleado="";
var nombreEmpleado="";
var supervisorId="";
function tableEmpleadosByCorreo()
{
  var correo=$("#txtCorreoElectronicoConsulta").val();
  waitingDialog.show();
  var caso = "1";
  $.ajax({
    type: "POST", 
    url: "ajax_getAsistenciaByGuardiaIdAndFecha.php",
    data: {"correo":correo,"numeroEmpleado":caso, "fecha1": caso, "fecha2":caso,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {        
        var empleadoEncontrado = response.asistenciaEmpleado;
        if(empleadoEncontrado.length==0){
          $("#divMensajeErrorConsultaAsistencia").html("");
          $("#divMensajeErrorConsultaAsistencia").html("<h3>No hay registro de asistencia con el correo electrónico indicado, por favor verifique o comuniquese a la unidad de negocios de contratación para actualizar sus datos.</h3>");
          $("#divErrorConsultaAsistenciaGuardia").modal();
        }else{                       
          numeroEmpleado = empleadoEncontrado[0].numeroEmpleado;
          var descripcionTipoPeriodo=empleadoEncontrado[0].descripcionTipoPeriodo;
          var puntoServicio=empleadoEncontrado[0].puntoServicio;
          nombreEmpleado=empleadoEncontrado[0].nombreEmpleado;
          supervisorId = empleadoEncontrado[0].supervisorId;
          var nombreSupervisor=empleadoEncontrado[0].supervisor;
          var empleadoIdGenero=empleadoEncontrado[0].empleadoIdGenero;
          empleadoEstatusId=empleadoEncontrado[0].empleadoEstatusId;
                                            
          if(empleadoIdGenero==1){
            $("#divImg").html("");
            $("#divImg").html("<img src='img/MaraVilla.png' width='300px' height='300px'>");
          }else{
            $("#divImg").html("");
            $("#divImg").html("<img src='img/JustoLeal.png' width='300px' height='300px'>");
          }
  
          $("#txtNumeroGuardia").val(numeroEmpleado);
          $("#txtNombreGuardia").val(nombreEmpleado);
          $("#txtSupervisorGuardia").val(nombreSupervisor);
          $("#txtPuntoServicioGuardia").val(puntoServicio);

          generarTablaPeriodoConsultaAsistenciaGuardia(descripcionTipoPeriodo);
          $("#txtFecha1ConsultaGuardia").val(response.fecha1);
          $("#txtFecha2ConsultaGuardia").val(response.fecha2);
          
          var asistencia=response.asistenciaEmpleado;
          if(empleadoEstatusId!=0){
            $("#tableConsultaAsistenciaGuardia").find("tr:gt(0)").remove();
            var turnosTotales=0;
            if(asistencia.length==0){
              var alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Consulta de asistencia:</strong>Lo sentimos no hay registro de asistencia<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
              $("#alertMensajeAsistencia").html(alertMsg1);
              $('#msgAlert').delay(3000).fadeOut('slow');
            }
            var asistenciaApp=response.AsistenciaApp;
            for(var j=0; j<asistencia.length; j++){        
              var fechaAsistencia=asistencia[j].fechaAsistencia;
              var nomenclaturaIncidencia=asistencia[j].nomenclaturaIncidencia;
              var puntoServicio=asistencia[j].puntoServicio
              var comentarioIncidencia=asistencia[j].comentarioIncidencia;
              var style = stylesConsultaAsitencia [nomenclaturaIncidencia];
              var descripcionIncidencia=asistencia[j].descripcionIncidencia;
              var FechaRegistroAsis=asistencia[j].FechaRegistroAsis;
              turnosTotales=parseInt(turnosTotales)+parseInt(asistencia[j].valorAsistencia);
              var FechaApp = "SIN REGISTRO";
              for(var k=0; k<asistenciaApp.length; k++){
                var Fecha1=asistenciaApp[k].Fecha;

                if(Fecha1 == fechaAsistencia){
                  var Hora=asistenciaApp[k].Hora;
                  FechaApp = Hora; 
                }
              }  

              $('#tableConsultaAsistenciaGuardia').append("<tr><td class='id'>"+asistencia[j].fechaAsistencia+"</td><td style='" + style + "'><strong>"+descripcionIncidencia+"</strong></td><td>"+puntoServicio+"</td><td>"+FechaApp+"</td><td>"+FechaRegistroAsis+"</td><td>"+comentarioIncidencia+"</td></tr>");
            }
                      
            $("#tableConsultaAsistenciaGuardia").append("<tr><td colspan='6' align='center'><button class='btn btn-primary' type='button' onclick='modalEnvioComentario(\"" + numeroEmpleado + "\", \"" + nombreEmpleado + "\", \"" + supervisorId + "\");'>Enviar comentario</button></td></tr>")
          }else{
            var alertMsg1="<div id='msgAlert' class='alert alert-error'><h3><strong>Consulta de asistencia:</strong>Lo sentimos, fuiste dado de baja de la empresa, para consultar asistencia comunícate o acude directamente a la unidad de contratación.<a href='#' class='close' data-dismiss='alert'>&times;</a></h3></div>";
            $("#alertMensajeAsistencia").html(alertMsg1);
            $('#msgAlert').delay(10000).fadeOut('slow');
          }
        }
      }else{
        var mensaje=response.message;          
        $("#divMensajeErrorConsultaAsistencia").html("");
        $("#divMensajeErrorConsultaAsistencia").html("<img src='img/rechazarImss.png'><h3>"+mensaje+"</h3>");
        $("#divErrorConsultaAsistenciaGuardia").modal();
      }
      waitingDialog.hide();
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); 
    }
  });
}

    var fechasAsistenciaGuardia=[];
    function generarTablaPeriodoConsultaAsistenciaGuardia(descripcionTipoPeriodo){

        var descripcionTipoPeriodo=descripcionTipoPeriodo;

          //alert(tipoPeriodo);

        if (descripcionTipoPeriodo=="QUINCENAL"){

          <?php
          $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
          //echo $diasAsistencia;
          ?>
          fechasAsistenciaGuardia = [];

          <?php
          foreach ($diasAsistencia as $dia):
          ?>
          
          <?php echo "fechasAsistenciaGuardia.push ('" . $dia["fecha"] . "');\n" ?>
          <?php
          endforeach;
          ?>


          fecha1AsistenciaGuardia = fechasAsistenciaGuardia [0];
          fecha2AsistenciaGuardia = fechasAsistenciaGuardia [fechasAsistenciaGuardia.length - 1];
        }else{
          <?php
          $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ("SEMANAL");
          ?>

          fechasAsistenciaGuardia = [];
          <?php
          foreach ($diasAsistencia as $dia):
          ?>
          <?php echo "fechasAsistenciaGuardia.push ('" . $dia["fecha"] . "');\n" ?>
          <?php
          endforeach;
          ?>

          fecha1AsistenciaGuardia = fechasAsistenciaGuardia [0];
          fecha2AsistenciaGuardia = fechasAsistenciaGuardia [fechasAsistenciaGuardia.length - 1];
        }

    }

    
 
    function getAsistenciaGuardiaIdByFecha()
    {
     
      var numeroEmpleado1=$("#txtNumeroGuardia").val();
      var fecha1=$("#txtFecha1ConsultaGuardia").val();
      var fecha2=$("#txtFecha2ConsultaGuardia").val();
waitingDialog.show();

      if(empleadoEstatusId!=0 || empleadoEstatusId=="" ){

        $("#tableConsultaAsistenciaGuardia").find("tr:gt(0)").remove();
        var caso = "2";
        $.ajax ({
          type: "POST",
          url: "ajax_getAsistenciaByGuardiaIdAndFecha.php",
          data: {"correo":caso,"numeroEmpleado":numeroEmpleado1, "fecha1": fecha1, "fecha2":fecha2,"caso":caso},
          dataType: "json",
          success: function (response) {

         
            if (response.status == "success")
            {
                //alert (response.message);
                var asistencia=response.asistenciaEmpleado;
                var turnosTotales=0;
                var asistenciaApp=response.AsistenciaApp;
                for(var j=0; j<asistencia.length; j++){
                                                
                        var fechaAsistencia=asistencia[j].fechaAsistencia;
                        
                        var nomenclaturaIncidencia=asistencia[j].nomenclaturaIncidencia;
                        var puntoServicio=asistencia[j].puntoServicio
                        var comentarioIncidencia=asistencia[j].comentarioIncidencia;
                        var style = stylesConsultaAsitencia [nomenclaturaIncidencia];
                        var descripcionIncidencia=asistencia[j].descripcionIncidencia;
                        var FechaRegistroAsis=asistencia[j].FechaRegistroAsis;
                        turnosTotales=parseInt(turnosTotales)+parseInt(asistencia[j].valorAsistencia);
                        var FechaApp = "SIN REGISTRO";
                        for(var k=0; k<asistenciaApp.length; k++){
                          var Fecha1=asistenciaApp[k].Fecha;
                          if(Fecha1 == fechaAsistencia){
                            var Hora=asistenciaApp[k].Hora;
                            FechaApp = Hora; 
                          }
                        }  
                        $('#tableConsultaAsistenciaGuardia').append("<tr><td class='id'>"+fechaAsistencia+"</td><td style='" + style + "'><strong>"+descripcionIncidencia+"</strong></td><td>"+puntoServicio+"</td><td>"+FechaApp+"</td><td>"+FechaRegistroAsis+"</td><td>"+comentarioIncidencia+"</td></tr>");
                      }
                      $("#tableConsultaAsistenciaGuardia").append("<tr><td colspan='4'><button class='btn btn-primary' type='button' onclick='modalEnvioComentario(\"" + numeroEmpleado + "\", \"" + nombreEmpleado + "\", \"" + supervisorId + "\");'>Enviar comentario</button></td></tr>");
            }else{

              var mensaje=response.message;
                  //alert(mensaje);
                  $("#divMensajeErrorConsultaAsistencia").html("");
                  $("#divMensajeErrorConsultaAsistencia").html("<img src='img/rechazarImss.png'><h3>"+mensaje+"</h3>");
                  $("#divErrorConsultaAsistenciaGuardia").modal();

            }
            waitingDialog.hide();
          },
         error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
        });
      }else{

        var alertMsg1="<div id='msgAlert' class='alert alert-error'><h3><strong>Consulta de asistencia:</strong>Lo sentimos, fuiste dado de baja de la empresa, para consultar asistencia comunícate o acude directamente a la unidad de contratación.<a href='#' class='close' data-dismiss='alert'>&times;</a></h3></div>";
                   
        $("#alertMensajeAsistencia").html(alertMsg1);
        $('#msgAlert').delay(10000).fadeOut('slow');
        waitingDialog.hide();
      }

          

      
    }

    function modalEnvioComentario(numeroEmpleado, nombreEmpleado, supervisorId){

      
      $("#divEnvioComentario").modal();

      $("#txtNumeroGuardiaComentario").val(numeroEmpleado);
      $("#txtNombreComentario").val(nombreEmpleado);
      $("#txtSupervisorGuardiaComentario").val(supervisorId);
    }

     function sendMessage(){


          var comentario=$("#txtComentarioGuardia").val();
          var numeroEmpleado=$("#txtNumeroGuardiaComentario").val();
          var supervisorId=$("#txtSupervisorGuardiaComentario").val();
          //var numeroEmpleado=$("#txtNumeroGuardiaComentario").val();


          $.ajax({
            type: "POST",
            url: "ajax_registroComentarioGuardia.php",
            data: {"numeroEmpleado":numeroEmpleado, "supervisorId":supervisorId, "comentario": comentario},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {
            

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Envio de comentario: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgEnvioComentario").html(alertMsg1);
                    $('#msgAlert').delay(1000).fadeOut('slow');
                    $("#divEnvioComentario").modal("hide");
                    $("#txtNumeroGuardiaComentario").val("");
                    $("#txtNombreComentario").val("");
                    $("#txtComentarioGuardia").val("");
                    $("#txtSupervisorGuardiaComentario").val("");

                    alert(mensaje);

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error al enviar comentario:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          
                    $("#alertMsgEnvioComentario").html(alertMsg1);
                    $('#msgAlert').delay(5000).fadeOut('slow');
                    
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });
      }
        
  $('#txtFecha1ConsultaGuardia').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });

  $('#txtFecha2ConsultaGuardia').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });

    
</script>
</html>