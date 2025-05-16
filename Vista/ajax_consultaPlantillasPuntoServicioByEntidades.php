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

	$clientes=getValueFromPost ("clientes");
	$entidades=getValueFromPost ("entidades");
	//$log->LogInfo("Valor de la variable \$idCliente: " . var_export ($idCliente, true));

	$lista= $negocio -> getPlantillasByPuntoServiciosntidades($clientes,$entidades);
//	$log->LogInfo("Valor de la variable lista: " . var_export ($lista, true));
	$response["lista"]= $lista;

} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}

echo json_encode($response);

