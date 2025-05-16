<?php

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");

$negocio = new Negocio();


$response = array("status" => "success");

$usuario=$_GET["usuario"];
$empleadoidd = explode("-", $usuario);
/*
    $empleadoEntidad=substr($usuario, 0,2);
    $empleadoConsecutivo=substr($usuario, 3,4);
    $empleadoCategoria=substr($usuario, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Restauración de contraseña</title>
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

        <p><h4>Restauración de contraseña, ingrese nueva contraseña</h4></p>
        <table>
        	<tr>
        		<td><b>Usuario:</b></td><td>
              <select id="selectUsuarios" name="selectUsuarios" class="input-large">
              
              </select></td>
        	</tr>
          <tr>
            <td><b>Rol de Usuario:</b></td><td>
              <input type="text" id="rolusuario" name="rolusuario" class="input-large">
              
              
          </tr>
        	<tr>
        		<td><b>Nueva contraseña:</b></td>
        		<td><input id="txtNuevaContrasenia" name="txtNuevaContrasenia" type="password" class="input-small" maxlength="10" ></td>
        	</tr>
        	<tr>
        		<td><b>Confirmar contraseña:</b></td>
        		<td><input id="txtNuevaContrasenia2" name="txtNuevaContrasenia2" type="password" class="input-small" maxlength="10" ></td>
        	</tr>
        	<tr>
        		<td colspan='2'><button id="btnRestauracionContrasenia" name="btnRestauracionContrasenia" class="btn btn-success" type="button" onclick='restaurarContraseniaUsuario();'>Enviar</button></td>
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
     $.ajax({
       type: "POST",
       url: "ajax_getUsuariosByEmpleado.php",
       data: {"entidadEmpleado":entidad,"consecutivoEmpleado":consecutivo,"categoriaEmpleado":categoria},
       dataType: "json",
       success: function(response) {
           var mensaje=response.message;
           $("#selectUsuarios").empty();
           if (response.status=="success") {              
              var usuarios=response.usuarios;              
              if(usuarios.length >0){
                 $("#selectUsuarios").append("<option value='0'>Seleccione usuario</option>");
                  $.each(usuarios, function(i) {
                      var usuario=response.usuarios[i].usuario;

                     $("#selectUsuarios").append("<option value='"+usuario+"'>"+usuario+"</option>");
                 });
              }else{
                $("#selectUsuarios").append("<option>No hay usuarios</option>");
              }
           } else if (response.status=="error")
           {
              alert(mensaje);
           }


         },
       error : function (jqXHR, textStatus, errorThrown)
            {
                alert(jqXHR.responseText);
            }
   });  
}

function restaurarContraseniaUsuario(){
	 var contrasenia = $("#txtNuevaContrasenia").val();
	 var contrasenia2=$("#txtNuevaContrasenia2").val();
	 var user=$("#selectUsuarios").val();
if(user==0){
  alert("Seleccione usuario");
}else {
	 $.ajax({
	     type: "POST",
	     url: "ajax_restauracionContrasenia.php",
	     data: {contrasenia:contrasenia,contrasenia2:contrasenia2,user:user},
	     dataType: "json",
	     success: function(response) {
	         var mensaje=response.message;

	         if (response.status=="success") {
	         	alert(mensaje);
	         	document.location.href="https://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>";
	             
	         } else if (response.status=="error")
	         {
	         	alert(mensaje);
	         }


	       },
	     error: function(){
	           alert('error handing here');
	     }
	 }); 
   } 

}

$("#selectUsuarios").change(function(){
var usuario=$("#selectUsuarios").val();
if($("#selectUsuarios").val()==0){
$("#rolusuario").val("");
}else{
$.ajax({
       type: "POST",
       url: "ajax_getRolUsuario.php",
       data: {usuario:usuario},
       dataType: "json",
       success: function(response) {
          //console.log(response);
      $("#rolusuario").val(response.rolusuario[0].descripcionRolUsuario);

         },
       error: function(){
             alert('error handing here');
       }
   }); 
}
});

	
</script>