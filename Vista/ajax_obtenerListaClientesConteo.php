<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxListaClientes.log" , KLogger::DEBUG );
$opcion=$_POST["opcion"];
$idcliente=$_POST["idcliente"];

$response = array("status" => "success");

try{

	$listaClientes= $negocio -> negocio_obtenerListaClientesConteo($opcion,$idcliente);
	$response["listaClientes"]= $listaClientes;
	//$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}

echo json_encode($response);

?>