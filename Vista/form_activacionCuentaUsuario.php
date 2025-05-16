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
  <title>Activación de cuenta</title>
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
  <div id="divErrorActivacionCuenta"></div>   
    <center>
        <h2>GRUPO GIF SEGURIDAD</h2>
        <p><h4>¡Ingrese el número de empleado generado en su contratación!</h4></p>
        <div class="input-prepend">
          <img src="img/logoGif.jpg" width="30px"> 
          <span class="add-on">Número Empleado</span>
          <input class="input-small" id="txtNumeroEmpleadoC" name="txtNumeroEmpleadoC" type="text" placeholder="00-0000-00">
          <input class="input-small" id="existecuenta" name="existecuenta" type="hidden" >
          <button class="btn btn-success" type="button" onclick="verificaNumeroEmpleado();"> <span class="glyphicon glyphicon-download-alt"></span>Consultar</button>
        </div>
        <div id='respuesta' name='respuesta'></div>
    </center>  
  </form>
 </div>
</body>
<div class="modal fade" tabindex="-1" role="dialog" name="modalUniformesRequeridos" id="modalUniformesRequeridos" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="divchecks">
        <div id="divErrorModalSolicitud"></div>
        <h4 class="modal-title"><img src="img/alert.png">¿El guardia recibirá uniformes?</h4>
        <center>
       <table>
       <tr>
           <td>
               <div class="chart-container" style="width:1vw">
                   <input type="radio" id="siRecibeUniformes" name="siRecibeUniformes">
                   <h4>Si</h4>
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:1vw">
                   <input type="radio" id="noRecibeUniformes" name="noRecibeUniformes">
                   <h4>No</h4>                                        
               </div>
           </td>
       </tr>     
     </table>
     </center>
      </div>
      <div class="modal-body" align="center" style="display: none;" id="divSolicitudUniformes">
        <p><strong id="errorpermsa"></strong></p>
        <label class="control-label label " for="seleccionartipoUnif">Uniforme Requerido:</label>
        <select id="seleccionartipoUnif" name="seleccionartipoUnif" class="input-large"></select> 
        <br> 
          <label class="control-label label " for="inpCantidad">Cantidad:</label>
          <input class="input-small" id="inpCantidad" name="inpCantidad" type="text" readonly="true">
      </div>
          <label  id="labelSinAsignarUni" style="display: none; color:red;" class="control-label label">Presione Aceptar para continuar con la creacion de la cuenta</label>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="enviarsolicitud()">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<script type="text/javascript">

$(limpiarFormulario());//ready

$("#noRecibeUniformes").change(function(){
     $("#noRecibeUniformes").val(1);
     $("#siRecibeUniformes").val(0);
     $("#siRecibeUniformes").prop("checked", false);
     $("#divSolicitudUniformes").hide();
     $("#labelSinAsignarUni").show();  
     $("#seleccionartipoUnif").val(0);   
     $("#inpCantidad").val(0);   
    });

$("#siRecibeUniformes").change(function(){
     $("#siRecibeUniformes").val(1);
     $("#noRecibeUniformes").val(0);
     $("#noRecibeUniformes").prop("checked", false);
     $("#divSolicitudUniformes").show();
     $("#labelSinAsignarUni").hide();
     $("#seleccionartipoUnif").val(0);   
     $("#inpCantidad").val(0);   
    });

$("#txtNumeroEmpleadoC").keyup(function(){
  limpiarFormularioconsultaEmp();
  });

$("#seleccionartipoUnif").change(function(){
var tipouniSelect = $("#seleccionartipoUnif").val();
if (tipouniSelect !=0) {
  $("#inpCantidad").prop("readonly", false);
  $("#inpCantidad").val("1");
  }else{
       $("#inpCantidad").prop("readonly", true);
       $("#inpCantidad").val("0");
      }
  });



function abrirmodal(){

  var numempleado= $("#txtNumeroEmpleadoC").val();
  var password1=$("#password1").val();
  var password2=$("#password2").val();
  var txtCorreoConsulta=$("#txtCorreoConsulta").val();


  if(numempleado== "" || numempleado== "NULL" || numempleado== "null" || numempleado== "NULL") {
    var mansaje ="INGRESE UN NUMERO DE EMPLEADO";
                  cargarmensajeActivacion(mansaje);
    //alert("INGRESE UN NUMERO DE EMPLEADO");
   }
   else if (txtCorreoConsulta== "" || txtCorreoConsulta== "NULL" || txtCorreoConsulta== "null" || txtCorreoConsulta== "NULL") {
       var mansaje ="INGRESE UN CORREO DE EMPLEADO";
                     cargarmensajeActivacion(mansaje);
       //alert("INGRESE UN CORREO DE EMPLEADO");
   }
   else if (password1== "" || password1== "NULL" || password1== "null" || password1== "NULL"){
       var mansaje ="INGRESE UNA CONTRASEÑA DE EMPLEADO";
                     cargarmensajeActivacion(mansaje);
       //alert("INGRESE UNA CONTRASEÑA DE EMPLEADO");
      }
       else if (password2== "" || password2== "NULL" || password2== "null" || password2== "NULL") {
         var mansaje ="INGRESE LA CONFIRMACION DE LA CONTRASEÑA";
                       cargarmensajeActivacion(mansaje);
         //alert("INGRESE LA CONFIRMACION DE LA CONTRASEÑA");
       }else if(password1 != password2) {
               var mansaje ="LAS CONTRASEÑAS NO COINCIDEN";
                       cargarmensajeActivacion(mansaje);
       }else{

          $("#modalUniformesRequeridos").modal("show");

          $.ajax({
                  type: "POST",
                  url: "ajax_CatalogoUniformesSolicitados.php",
                  dataType: "json",
                  success: function(response) {
                  //console.log(response.uniformes);
                  $("#seleccionartipoUnif").empty(); 
                  $('#seleccionartipoUnif').append('<option value="0">TIPO</option>');
              if(response.status == "success"){
                 for(var i = 0; i < response.uniformes.length; i++){
                     $('#seleccionartipoUnif').append('<option value="' + (response.uniformes[i].TipoUniformeSol) + '">' + response.uniformes[i].Descripcion + '</option>');
                    }
                }else{
                      alert("Error Al Cargar Las Entidades");
                     }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
            }
          });
        }
}

function enviarsolicitud(){
  var numempleado= $("#txtNumeroEmpleadoC").val();
  var tipouniSolicitud= $("#seleccionartipoUnif").val();
  var cantidadsolicitud = $("#inpCantidad").val();

  if($('#siRecibeUniformes').is(":checked")){
    if (tipouniSolicitud==0){
      var mansaje ="SELECCIONE UN TIPO DE UNIFORME VALIDO";
      cargarmensajeModalActivacion(mansaje);
    }else if(cantidadsolicitud== "" || cantidadsolicitud== "NULL" || cantidadsolicitud== "null" || cantidadsolicitud== "NULL" || cantidadsolicitud== "0") {
      var mansaje ="INGRESE UNA CANTIDAD";
      cargarmensajeModalActivacion(mansaje);
    }else if (cantidadsolicitud<=0) {
      var mansaje ="NO PUEDE ASIGNAR UNA CANTIDAD NEGATIVA Ó IGUAL A CERO";
      cargarmensajeModalActivacion(mansaje);
    }else if (!/^([0-9])*$/.test(cantidadsolicitud)) {
      var mansaje ="INGRESE SOLO NUMEROS";
      cargarmensajeModalActivacion(mansaje);
    }
    else{
      $.ajax({
         type: "POST",
         url: "ajax_insertsolicitudUniforme.php",
         data:{numempleado,tipouniSolicitud,cantidadsolicitud},
         dataType: "json",
         success: function(response) {
         if(response.status == "success"){
            crearCuenta();
         }else{
               alert("Error Al insertar solicitud");
              }
           },
         error: function(jqXHR, textStatus, errorThrown){
           alert(jqXHR.responseText);
         }
       });
    }
  }else{
        crearCuenta();
  }
}
  

function verificaNumeroEmpleado()
{ 
  var txtNumeroEmpleadoC = $("#txtNumeroEmpleadoC").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

  if (txtNumeroEmpleadoC.length != 10  && txtNumeroEmpleadoC.length != 11)
    { 
      alert("Número de empleado inválido");
        return;
        //limpiarFormulario();
    }

  if(expreg.test(txtNumeroEmpleadoC) || expreg1.test(txtNumeroEmpleadoC))
  {
    var numeroEmpleado = $("#txtNumeroEmpleadoC").val();

    consultaEmpleadoC(numeroEmpleado);

  }else{
    
  }
}

function consultaEmpleadoC(numeroEmpleado){

  var numeroEmpleado1 = numeroEmpleado;

 $.ajax({
            
            type: "POST",
            url: "ajax_consultaEmpleadoById.php",
            data:{"numeroEmpleado":numeroEmpleado1},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
             
                   var empleadoEncontrado = response.empleado;
                    if (empleadoEncontrado.length == 0){
                    //alert("No existe el número de empleado en la base de datos");
                    var mansaje ="No existe el número de empleado en la base de datos";
                          cargarmensajeActivacion(mansaje);
                    //limpiarFormulario();

                        
                    }else {
                      
                      for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                        empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                        empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                        empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                        empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                        empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                        nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                        tipoEmpleado= empleadoEncontrado[i].idTipoPuesto;
                        empleadoLineaNegocioId=empleadoEncontrado[i].empleadoLineaNegocioId;
                        empleadoEstatusId=empleadoEncontrado[i].empleadoEstatusId;
                        correoElectronico=empleadoEncontrado[i].correoEmpleado;
                        empleadoLocalizacion=empleadoEncontrado[i].empleadoLocalizacion;
                        usuarioExiste=empleadoEncontrado[i].usuario;
                        usuario=empleadoEntidad+empleadoConsecutivo+empleadoCategoria;
                        $("#existecuenta").val(usuarioExiste);
                        if(tipoEmpleado=='02'){ // || empleadoLineaNegocioId!=1

                          var mansaje ="La activación de cuenta sólo esta disponible para elementos de seguridad";
                          cargarmensajeActivacion(mansaje);
                          //alert("La activación de cuenta sólo esta disponible para elementos de seguridad");

                        }else{

                          //verifica si el elemento operativo está activo.
                          /*if(empleadoEstatusId==0){
                            
                            alert("Para poder hacer la activación de la cuenta debes estar activo en la empresa.");

                          }else{*/

                            var div="<div class='well'>";
                              div+="<div class='row'>";
                                div+="<div class='span12'>";
                                div+="<p><h4>Estimado: </h4></p>";
                                  div+="<input class='input-xlarge' id='txtNombreGuardiaC' name='txtNombreGuardiaC' type='text' disabled>";
                                  div+="<p><h4>¡Para continuar por favor ingrese el correo electrónico que proporcionó en su contratación!</h4></p>";
                                   div+="<div class='input-prepend'>";
                                    div+="<span class='add-on'>Correo electrónico</span>";
                                    div+="<input class='input-large-email' id='txtCorreoConsulta' name='txtCorreoConsulta' onkeyup='limpiarCampos();' type='text' placeholder='ejemplo@correo.com' >";
                                    div+="<button class='btn btn-success' type='button' onclick='verificarCoincidenciaCorreo();'> <span class='glyphicon glyphicon-download-alt'></span>Enviar</button>";
                                    div+="</div>";
                                    div+="<div id='DivUsuario' name='DivUsuario' class='span12'></div>";
                                    div+="</div><!-- termina div span 12 -->";
                              div+="</div> <!-- termina div row -->";
                            div+="</div> <!-- termina div well -->";

                            $("#respuesta").html(div);

                            $("#txtNombreGuardiaC").val(nombreEmpleado+" "+empleadoApellidoPaterno+" "+empleadoApellidoMaterno);

                       //  }
                          

                        }
                                             

                      }
                    }

                }else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "index.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
        });

}

function verificarCoincidenciaCorreo(){
  var txtCorreoConsulta=$("#txtCorreoConsulta").val();
  var numeroEmpleadoExiste = $("#txtNumeroEmpleadoC").val();
  var existecuenta = $("#existecuenta").val();
  //alert(existecuenta);
  if(txtCorreoConsulta==correoElectronico){
    if(existecuenta =="null" || existecuenta =="NULL" || existecuenta =="" || existecuenta == null  || existecuenta =="0"){
      var htmlUsuario="<p><h4>¡El usuario generado para iniciar sesión es tú mismo número de empleado, pero sin guiones!</h4></p>";
      htmlUsuario+="<table><tr><td>Usuario:</td><td><input class='input-small' id='txtUsuario' name='txtUsuario' type='text' disabled></td></tr>";
      htmlUsuario+="<tr><td>Escribe una Contraseña:</td><td><input class='input-small' id='password1' name='password1' type='password' maxlength='10'></td></tr>";
      htmlUsuario+="<tr><td>Confirma tu contraseña:</td><td><input class='input-small' id='password2' name='password2' type='password' maxlength='10'></td></tr>";
      htmlUsuario+="<tr><td colspan='2'><button id='btncrearCuenta' onclick='abrirmodal();' class='btn btn-warning' type='button' >Crear cuenta</button></td></tr></table>";
      $("#DivUsuario").html(htmlUsuario);
      $("#txtUsuario").val(usuario);
    }else{
      $("#DivUsuario").html("");
      mandarcorreorecuperacionContraseniaGurdia(txtCorreoConsulta,numeroEmpleadoExiste);
    }   

  }else{
    alert("El correo electrónico que acaba de ingresar "+txtCorreoConsulta+" no coincide con el correo registrado en su contratación, por favor verifique para poder activar la cuenta.");
  }
}

function crearCuenta(){//success del modal

  var password1=$("#password1").val();
  var password2=$("#password2").val();
  var idRolUser="16";
  $.ajax({
          type: "POST",
          url: "ajax_newUserEmpleado.php",
          data: {"empleadoEntidad":empleadoEntidad,"empleadoConsecutivo":empleadoConsecutivo,"empleadoCategoria":empleadoCategoria, "usuario":usuario, "password1":password1,"password2":password2, "idRolUser":idRolUser, "apellidoPaterno":empleadoApellidoPaterno,"apellidoMaterno":empleadoApellidoMaterno, "nombreEmpleado":nombreEmpleado, "empleadoLocalizacion":empleadoLocalizacion,"correoElectronico":correoElectronico},
          dataType: "json",
          success: function(response){
                var mensaje=response.message;

                if (response.status=="success") {
                  alert(mensaje);
                  limpiarFormulario();
                  $("#modalUniformesRequeridos").modal("hide");
                } else if (response.status=="error")
                {
                  //$("#modalUniformesRequeridos").modal("hide");
                  alert(mensaje);
                  //limpiarFormulario();
                }
              },
            error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
          }
        });  

}

function limpiarFormulario(){

  $("#txtNumeroEmpleadoC").val("");
  $("#txtCorreoConsulta").val("");
  $("#txtNombreGuardiaC").val("");
  $("#txtUsuario").val("");
  $("#password1").val("");
  $("#password2").val("");
  $("#respuesta").html("");
  $("#DivUsuario").html("");

  var correoElectronico="";
  var usuario="";
  var empleadoEntidad="";
  var empleadoConsecutivo="";
  var empleadoCategoria ="";
  var empleadoApellidoPaterno="";
  var empleadoApellidoMaterno="";
  var nombreEmpleado="";
  var tipoEmpleado="";
  var empleadoLineaNegocioId="";
  var empleadoEstatusId="";
  var empleadoLocalizacion="";

}

function limpiarFormularioconsultaEmp(){

 // $("#txtNumeroEmpleadoC").val("");
  $("#txtCorreoConsulta").val("");
  $("#txtNombreGuardiaC").val("");
  $("#txtUsuario").val("");
  $("#password1").val("");
  $("#password2").val("");
  $("#respuesta").html("");
  $("#DivUsuario").html("");

}

function limpiarFormularioCONSULTACORREO(){
 $("#txtUsuario").val("");
 $("#password1").val("");
 $("#password2").val("");
 $("#DivUsuario").html("");
}

function limpiarCampos (){
  //alert("2");
  limpiarFormularioCONSULTACORREO();
}

function mandarcorreorecuperacionContraseniaGurdia(correo,numeroempleadoexiste){
  waitingDialog.show();
  $.ajax({
    type: "POST",
    url: "ajax_EnviarCorreoRestauracionContraseniaGurdia.php",
    data:{"correo":correo,"numeroempleadoexiste":numeroempleadoexiste},
    dataType: "json",
    success: function(response) {
      console.log(response);
      waitingDialog.hide();
      limpiarFormulario();
      alert(response.message);
    },error: function(jqXHR, textStatus, errorThrown) {
      waitingDialog.hide();

      alert(jqXHR.responseText);
    }
  });
 }


 function cargarmensajeActivacion(mensaje){
  $('#divErrorActivacionCuenta').fadeIn('slow');
  mensajeErroract="<div id='msgAlert' class='alert alert-error'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divErrorActivacionCuenta").html(mensajeErroract);
  $(document).scrollTop(0);
  $('#divErrorActivacionCuenta').delay(3000).fadeOut('slow');

}

function cargarmensajeModalActivacion(mensaje){
  $('#divErrorModalSolicitud').fadeIn('slow');
  mensajeErrorModalAct="<div id='msgAlert' class='alert alert-error'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divErrorModalSolicitud").html(mensajeErrorModalAct);
  $(document).scrollTop(0);
  $('#divErrorModalSolicitud').delay(3000).fadeOut('slow');

}
    
</script>
</html>