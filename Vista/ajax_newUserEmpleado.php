<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio (); 


$response = array ();
$response ["status"] = "error";

//$log = new KLogger ( "ajaxNewUser.log" , KLogger::DEBUG );
  
if (!empty ($_POST))
{
    

	$datos = array (
    "usuario" => getValueFromPost("usuario"),
    "contrasenia" => getValueFromPost("password1"),
    "contrasenia2" => getValueFromPost("password2"),
    "usuarioRolId" => getValueFromPost("idRolUser"),
    "apellidoPaterno" => strtoupper(getValueFromPost("apellidoPaterno")),
    "apellidoMaterno" =>strtoupper( getValueFromPost("apellidoMaterno")),
    "nombre" => strtoupper(getValueFromPost("nombreEmpleado")),
    "entidadFederativaUsuario" => getValueFromPost("empleadoLocalizacion"),
    "correoElectronico" => getValueFromPost("correoElectronico"),
    "entidadEmpleadoUsuario" => getValueFromPost("empleadoEntidad"),
    "consecutivoEmpleadoUsuario" => getValueFromPost("empleadoConsecutivo"),
    "categoriaEmpleadoUsuario" => getValueFromPost("empleadoCategoria"),
    );

    //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));

     
    try
    {

        $negocio -> newUserEmpleado($datos);
      //  if($datos["usuarioRolId"]==11 || $datos["usuarioRolId"]==16){

            $negocio-> asignacionEmpleadoSupervisor($datos);

      //  }
               
        $response ["status"] = "success";
        $response ["message"] = "El usuario ".$datos["usuario"]." fue creado con éxito para el empleado ". $datos["nombre"]." ". $datos["apellidoPaterno"]." ". $datos["apellidoMaterno"]." ";      
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $error=$e -> getMessage ();

        if($error=="Uno de los valores que intenta registrar se duplica en la base de datos."){
            $response["message"]="La cuenta de usuario ".$datos["usuario"]." ya fue activada con otra contraseña";

        }else{
            $response ["message"] =  $e -> getMessage ();
        }
        //verificar error
        
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>
