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

	$listaDocumentos = $negocio -> negocio_traerListaDocumentos();
	$response["listaDocumentos"]= $listaDocumentos;
	//$log -> LogInfo ("lista documentos" . var_export ($listaDocumentos, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener la lista de documentos";
}

echo json_encode($response);


?>