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

	
		// $log = new KLogger ( "ajaxListaMovimientosStore.log" , KLogger::DEBUG );
		$fecha=getValueFromPost ("fechaConsulta");
		$bancoId=getValueFromPost ("idBanco");
		$empresaId=getValueFromPost ("empresaId");
	

	try{
		
	

		$listaMovimientosDiaBanco = $negocio -> negocio_traeListaMovimientosPorDiaStoreProcedure($fecha, $bancoId, $empresaId);
		$response["listaMovimientosDiaBanco"]= $listaMovimientosDiaBanco;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fecha, true));
		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo listaMovimientosDiaBanco";
	}
}

echo json_encode($response);

?>