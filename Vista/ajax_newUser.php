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
$usuario = $_SESSION ["userLog"]["usuario"];
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxNewUser.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));
if (!empty ($_POST))
{ 
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $usuarioPassword1 = md5(getValueFromPost("contrasenaUser1"));
    $usuarioPassword2 = md5(getValueFromPost("contrasenaUser2"));	
	$datos = array (
    "usuario" => getValueFromPost("usuarioEmpleado"),
    "contrasenia" => getValueFromPost("contrasenaUser1"),
    "contrasenia2" => getValueFromPost("contrasenaUser2"),
    "usuarioRolId" => getValueFromPost("idRolUser"),
    "apellidoPaterno" => strtoupper(getValueFromPost("apellidoPaternoEmpleadoUser")),
    "apellidoMaterno" =>strtoupper( getValueFromPost("apellidoMaternoEmpleadoUser")),
    "nombre" => strtoupper(getValueFromPost("nombreEmpleadoUser")),
    "entidadFederativaUsuario" => getValueFromPost("idEndidadFederativaUser"),
    "correoElectronico" => getValueFromPost("correoUser"),
    "usuarioCreacion" => $usuario,
    "entidadEmpleadoUsuario" => getValueFromPost("numeroEmpleadoEntidadUser"),
    "consecutivoEmpleadoUsuario" => getValueFromPost("numeroEmpleadoConsecutivoUser"),
    "categoriaEmpleadoUsuario" => getValueFromPost("numeroEmpleadoTipoUser"),
    "largotbl" => getValueFromPost("largotbl"),
    "idsEntidades" => getValueFromPost("idsEntidades"), 
    "largotbllineanegocio" => getValueFromPost("largotbllineanegocio"),
    "idslineasnegocio" => getValueFromPost("idslineasnegocio"), 
    );

    //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true)); 
    try
    {

       $negocio -> newUser($datos);    
        $negocio-> asignacionEmpleadoSupervisor($datos);       
        $response ["status"] = "success";
        $response ["message"] = "El usuario <strong>".$datos["usuario"]."</strong> fue creado con éxito para el empleado ". $datos["nombre"]." ". $datos["apellidoPaterno"]." ". $datos["apellidoMaterno"]." ";     
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>
