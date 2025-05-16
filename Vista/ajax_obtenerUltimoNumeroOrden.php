<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

try{
	//$log = new KLogger ( "ajaxUltimoNumeroOrden.log" , KLogger::DEBUG );

	$ultimoNumeroOrden = $negocio -> negocio_obtenerUltimoNumeroOrden();
	$response["ultimoNumeroOrden"]= $ultimoNumeroOrden;
	//$log -> LogInfo ("ultimoNumeroOrden" . var_export ($ultimoNumeroOrden, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener ultimo numero de orden";
}

echo json_encode($response);


?>