<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

// $log = new KLogger ( "ajaxListaEmpresas.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{


	$listaEmpresas = $negocio -> negocio_ListaEmpresas();
	$response["listaEmpresas"]= $listaEmpresas;
	// $log->LogInfo("Valor de la variable \$listaEmpresas: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes";
}

echo json_encode($response);

?>