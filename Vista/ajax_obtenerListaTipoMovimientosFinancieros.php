<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

	
// $log = new KLogger ( "ajaxConsultaTipoMovimientosFianacieros.log" , KLogger::DEBUG );
		

	try{
		
		
		$listaTipoMovimientosFinancieros= $negocio -> negocio_ListaTipoMovimientosFinancieros();
		$response["listaTipoMovimientosFinancieros"]= $listaTipoMovimientosFinancieros;

		// $log->LogInfo("Valor de la variable \$response listaTipoMovimientosFinancieros: " . var_export ($response, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener listaTipoMovimientosFinancieross";
	}


echo json_encode($response);

?>