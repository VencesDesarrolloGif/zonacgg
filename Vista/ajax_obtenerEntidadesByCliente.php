<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_entidadesByCliente.log" , KLogger::DEBUG );

$response = array("status" => "success");

$cliente= getValueFromPost("cliente");


try{

	$entidades= $negocio -> negocio_obtenerEntidadesByCliente($cliente);
	$response["datos"]= $entidades;
	//$log->LogInfo("Valor de la variable \$entidades: " . var_export ($entidades, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No puedo obtener datos";
}

echo json_encode($response);

?>