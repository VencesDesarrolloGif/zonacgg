<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajaxObtenerListaParentescos.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{


	$listaParentescos = $negocio -> negocio_obtenerListaParentescos();
	$response["listaParentescos"]= $listaParentescos;
	//$log->LogInfo("Valor de la variable \$listaParentescos: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Parentescos";
}

echo json_encode($response);

?>