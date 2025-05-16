<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php"); 
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success"); 
  //  $log = new KLogger ( "ajax_ObtenerMotivoBajaForzada.log" , KLogger::DEBUG );
try{
    $datos = $negocio -> obtenerCatalogoMotivoBajaForzada();  
    $response ["datos"] = $datos;
}
catch (Exception $e)
{
    $response ["status"] = "error";
    $response ["message"] = "No se pudieron obtener los datos";
}
echo json_encode ($response); 
?>