<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio= new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_obtenerEmpleadosProcesoFiniquitoParaAlmacen.log" , KLogger::DEBUG );
$response = array("status" => "success");
$usuario               = $_SESSION ["userLog"];
try{
    //$log->LogInfo("Valor de la variable usuario: " . var_export ($usuario, true));
    $datos = $negocio -> obtenerEmpleadosProcesoFiniquitoParaAlmacen($usuario);
    
    $response ["datos"] = $datos;
    //$log->LogInfo("Valor de la variable \$responseajax de puntos segun tipo: " . var_export ($response, true));
    
}
catch (Exception $e)
{
    $response ["status"] = "error";
    $response ["message"] = "No se pudieron obtener los puntos"; 
}

echo json_encode ($response);
?>