<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

try{
	//$log = new KLogger ( "ajax.log" , KLogger::DEBUG );

	$numeroDeVisitantesDelDia = $negocio -> negocio_traerTotalDeVisitantesDelDia();
	$response["numeroDeVisitantesDelDia"]= $numeroDeVisitantesDelDia;
	//$log -> LogInfo (var_export ($numeroDeVisitantesDelDia, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener el numero De Visitamtes Del Dia";
}

echo json_encode($response);


?>