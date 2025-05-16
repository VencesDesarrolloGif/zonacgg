<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_clientesByEntidad.log" , KLogger::DEBUG );

$response = array("status" => "success");

$entidad= getValueFromPost("entidad");


try{

	$clientes= $negocio -> negocio_obtenerClientesByEntidad($entidad);
	$response["datos"]= $clientes;
	// $log->LogInfo("Valor de la variable \$clientes: " . var_export ($clientes, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No puedo obtener datos";
}

echo json_encode($response);

?>