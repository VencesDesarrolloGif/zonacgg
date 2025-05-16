<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
//$log = new KLogger ( "ajaxGetProveedores.log" , KLogger::DEBUG );
try{

	$asignaciones = $negocio ->  obtenerAsignaciones();
	
	//$log->LogInfo("Valor de la variable $proveedores: " . var_export ($proveedores, true))	

	$response["data"]= $asignaciones;

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de personal Activo";	
}

echo json_encode($response);

?>


