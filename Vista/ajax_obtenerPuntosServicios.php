<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxListaPuntosServicios.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

	$lista= $negocio -> traerCatalogoPuntosServicios();
	$response["lista"]= $lista;
	// $log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Puntos de servicios";
}

echo json_encode($response);

?>