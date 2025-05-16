<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxConsultaPlantillaPuntoServicioCliente.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

	$idCliente=getValueFromPost ("idCliente");
	$puntoServicio=getValueFromPost ("puntoServicio");
	//$log->LogInfo("Valor de la variable \$idCliente: " . var_export ($idCliente, true));

	$lista= $negocio -> getPlantillasByPuntoServiciosClienteNamePoint($idCliente, $puntoServicio);
	$response["lista"]= $lista;
	//$log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));

} 
catch( Exception $e )
{
	$response ["status"] = "error";
    $response ["message"] =  $e -> getMessage ();
}

echo json_encode($response);

