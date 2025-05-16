<?php

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();


$response = array("status" => "success");

$usuarioEmp=$_GET["usuarioEmp"];
$empleadoidd = explode(" ", $usuarioEmp);
$usuarioEmp1=$empleadoidd[0];
$correo=$empleadoidd[1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Restauración de contraseña para guardia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le stylesheet -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <link href="css/animate-custom.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
  <script type="text/javascript" src="js/bootstrap-checkbox.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
</head>
<body>
 <div class="container">
  <form>
    <center>
        <p><h4>Restauración De contraeña, Ingrese Nueva Contraseña</h4></p>
        <table>
            <tr>
                <td><b>Usuario</b></td>
                <td><input id="usuarioGuardia1" name="usuarioGuardia1" type="text" readonly="true" class="input-large"></td>
            </tr>
        	<tr>
        		<td><b>Nueva contraseña:</b></td>
        		<td><input id="txtNuevaContraseniaGuardia" name="txtNuevaContraseniaGuardia" type="password" maxlength="10" class="input-medium"></td>
        	</tr>
        	<tr>
        		<td><b>Confirmar contraseña:</b></td>
        		<td><input id="txtNuevaContrasenia2Guardia" name="txtNuevaContrasenia2Guardia" type="password" maxlength="10" class="input-medium" ></td>
        	</tr>
        	<tr>
        		<td colspan='2'><button id="btnRestauracionContrasenia" name="btnRestauracionContrasenia" class="btn btn-success" type="button" onclick='restaurarContraseniaParaGuardias();'>Enviar</button></td>
        	</tr>
            <tr>
                <td><input id="usuarioGuardia" name="usuarioGuardia"  type="hidden" class="input-small"></td>
                <td><input id="correoGuardia" name="correoGuardia"  type="hidden" class="input-small"></td>
            </tr>

        </table>
    </center>
  
   
  </form>
   
 </div>
     
</body>
<script type="text/javascript">
$(document).ready(function() {
$("#rolusuario").prop("readonly",true);
  llenarUsuariosguardias('<?php echo $usuarioEmp1?>','<?php echo $correo?>');
});


function llenarUsuariosguardias(usuarioEmp,correo){
    $("#usuarioGuardia").val(usuarioEmp);
    $("#correoGuardia").val(correo);
    $("#usuarioGuardia1").val(usuarioEmp);
    
}

function restaurarContraseniaParaGuardias(){
	var contrasenia = $("#txtNuevaContraseniaGuardia").val();
    var contrasenia2=$("#txtNuevaContrasenia2Guardia").val();
    var usuarioGuardia=$("#usuarioGuardia").val();
    var correo = $("#correoGuardia").val();

    if(contrasenia != contrasenia2){
        alert("Las Contraseñas Son Diferentes Favor De Volver A Escribirlas");
        $("#txtNuevaContraseniaGuardia").val("");
        $("#txtNuevaContrasenia2Guardia").val("");
    }else if( contrasenia==""){
        alert("La Primer Contraseña No Puede estar Vacia !!");
        $("#txtNuevaContraseniaGuardia").val("");
        $("#txtNuevaContrasenia2Guardia").val("");
    }else if(contrasenia2==""){
        alert("La Segunda Contraseña No Puede estar Vacia !!");
        $("#txtNuevaContraseniaGuardia").val("");
        $("#txtNuevaContrasenia2Guardia").val(""); 
    }else{
    	$.ajax({
    	    type: "POST",
    	    url: "ajax_restauracionContraseniaGuardia.php",
    	    data: {"contrasenia":contrasenia,"usuarioGuardia":usuarioGuardia,"correo":correo},
    	    dataType: "json",
    	    success: function(response) {
    	        var mensaje=response.message;
        	   if (response.status=="success") {
    	        	alert(mensaje);
    	        	document.location.href="https://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>";   
    	        }else if (response.status=="error"){
    	        	alert(mensaje);
    	        }
            },error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
            }
    	}); 
    } 
}
	
</script>