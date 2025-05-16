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

	$ultimoFolio = $negocio -> negocio_obtenerFolioPreseleccion();
	$response["folioPre"]= $ultimoFolio;
	//$log -> LogInfo ("ultimoNumeroOrden" . var_export ($ultimoNumeroOrden, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener ultimo folio";
}

echo json_encode($response);


?>