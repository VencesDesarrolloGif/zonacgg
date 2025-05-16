<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

try{
	//$log = new KLogger ( "ajaxUltimoNumeroOrden.log" , KLogger::DEBUG );

	$dateServer = date('F d, Y G:i:s');
	$response["dateServer"]= $dateServer;
	//$log -> LogInfo ("ultimoNumeroOrden" . var_export ($ultimoNumeroOrden, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener la hora del servidor";
}

echo json_encode($response);


?>