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

	
		// $log = new KLogger ( "ajaxListaMovimientosGeneralDiaStore.log" , KLogger::DEBUG );
		$fecha=getValueFromPost ("fechaConsulta");
		$empresaId=getValueFromPost ("empresaId");
	

	try{
		
	

		$listaMovimientosDiaGeneral = $negocio -> negocio_traeListaMovimientosPorDiaGeneralStoreProcedure($fecha,$empresaId);
		$response["listaMovimientosDiaGeneral"]= $listaMovimientosDiaGeneral;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fecha, true));
		// $log->LogInfo("Valor de variable de empresa que viene de form" . var_export ($empresaId, true));
		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo listaMovimientosDiaGeneral";
	}
}

echo json_encode($response);

?>