<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");


if(!empty ($_POST))
{

	
		//$log = new KLogger ( "ajaxConsultaPuntosPorCliente.log" , KLogger::DEBUG );
		$clienteId=getValueFromPost ("clienteId");

	try{
		
	

		$listaPuntos = $negocio -> traerCatalogoPuntosServiciosByCliente($clienteId);
		$response["listaPuntos"]= $listaPuntos;


	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener puntos de servicios";
	}
}

echo json_encode($response);

?>