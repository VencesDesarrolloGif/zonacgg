<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php"); 

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxListaClientes.log" , KLogger::DEBUG );
$response = array("status" => "success");
$idEndidadFederativaContratacion=$_POST["idEndidadFederativaContratacion"];
try{

	$datos= $negocio -> negocio_verificarIutTarjetaDespensa($idEndidadFederativaContratacion);
	$response["datos"]= $datos;
	//$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}

echo json_encode($response);

?>