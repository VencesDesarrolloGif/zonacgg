<?php

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();


$response = array("status" => "success");

$usuario=$_GET["usuario"];

$empleadoidd = explode("-", $usuario);
$empleadoEntidad=$empleadoidd[0];
$empleadoConsecutivo=$empleadoidd[1];
$empleadoCategoria=$empleadoidd[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Restauración de firma electronica</title>
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
        <p><h4>Restauración De Fimra Electronica interna, Ingrese Nueva Contraseña</h4></p>
        <table>
            <tr>
                <td><b>Empleado</b></td>
                <td><input id="txtNumEmpl" name="txtNumEmpl" type="text" readonly="true" class="input-large"></td>
            </tr>
        	<tr>
        		<td><b>Nueva contraseña:</b></td>
        		<td><input id="txtNuevaContraseniaFirma" name="txtNuevaContraseniaFirma" type="password" class="input-medium"></td>
        	</tr>
        	<tr>
        		<td><b>Confirmar contraseña:</b></td>
        		<td><input id="txtNuevaContrasenia2Firma" name="txtNuevaContrasenia2Firma" type="password" class="input-medium" ></td>
        	</tr>
        	<tr>
        		<td colspan='2'><button id="btnRestauracionContrasenia" name="btnRestauracionContrasenia" class="btn btn-success" type="button" onclick='restaurarContraseniaFirma();'>Enviar</button></td>
        	</tr>
            <tr>
                <td><input id="entidadEmpleadoFirma" name="entidadEmpleadoFirma"  type="hidden" class="input-small"></td>
                <td><input id="consecutivoEmpleadoFirma" name="consecutivoEmpleadoFirma"  type="hidden" class="input-small"></td>
                <td><input id="tipoEmpleadoFirma" name="tipoEmpleadoFirma"  type="hidden" class="input-small"></td>
            </tr>

        </table>
    </center>
  
   
  </form>
   
 </div>
     
</body>
<script type="text/javascript">
$(document).ready(function() {
$("#rolusuario").prop("readonly",true);
  llenarUsuarios('<?php echo $empleadoEntidad?>','<?php echo $empleadoConsecutivo?>','<?php echo $empleadoCategoria?>');
});


function llenarUsuarios(entidad,consecutivo,categoria){
    $("#entidadEmpleadoFirma").val(entidad);
    $("#consecutivoEmpleadoFirma").val(consecutivo);
    $("#tipoEmpleadoFirma").val(categoria);
    $("#txtNumEmpl").val(entidad+"-"+consecutivo+"-"+categoria);
}

function restaurarContraseniaFirma(){
	var contrasenia = $("#txtNuevaContraseniaFirma").val();
    var contrasenia2=$("#txtNuevaContrasenia2Firma").val();
    var entidadEmpleadoFirma=$("#entidadEmpleadoFirma").val();
    var consecutivoEmpleadoFirma=$("#consecutivoEmpleadoFirma").val();
	var tipoEmpleadoFirma=$("#tipoEmpleadoFirma").val();
    if(contrasenia != contrasenia2){
        alert("Las Contraseñas Son Diferentes Favor De Volver A Escribirlas");
        $("#txtNuevaContraseniaFirma").val("");
        $("#txtNuevaContrasenia2Firma").val("");
    }else if( contrasenia==""){
        alert("La Primer Contraseña No Puede estar Vacia !!");
        $("#txtNuevaContraseniaFirma").val("");
        $("#txtNuevaContrasenia2Firma").val("");
    }else if(contrasenia2==""){
        alert("La Segunda Contraseña No Puede estar Vacia !!");
        $("#txtNuevaContraseniaFirma").val("");
        $("#txtNuevaContrasenia2Firma").val(""); 
    }else{
    	$.ajax({
    	    type: "POST",
    	    url: "ajax_restauracionContraseniaFirmaInterna.php",
    	    data: {"contrasenia":contrasenia,"entidadEmpleadoFirma":entidadEmpleadoFirma,"consecutivoEmpleadoFirma":consecutivoEmpleadoFirma,"tipoEmpleadoFirma":tipoEmpleadoFirma},
    	    dataType: "json",
    	    success: function(response) {
    	        var mensaje=response.message;
        	   if (response.status=="success") {
    	        	alert(mensaje);
    	        	document.location.href="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>";   
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