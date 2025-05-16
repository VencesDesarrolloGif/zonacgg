<?php
session_start();
require_once("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php");
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success"); 
$numeroEmpleado= getValueFromPost ("numeroEmpleado");
//$log = new KLogger ( "ajax_ObtenerDatosFiscalesGeneralTemporal.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true)); 

try{
    $datos = $negocio -> getDatosFiscalesGeneralTemporal($numeroEmpleado);
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true)); 
    
    $response ["datos"] = $datos;
    //$log->LogInfo("Valor de la variable \responseajax de puntos segun tipo: " . var_export ($response, true));
    
}
catch (Exception $e)
{
    $response ["status"] = "error";
    $response ["message"] = "No se pudieron obtener los puntos"; 
}

echo json_encode ($response);
?>