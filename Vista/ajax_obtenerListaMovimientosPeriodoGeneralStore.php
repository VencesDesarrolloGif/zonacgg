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

	
		// $log = new KLogger ( "ajaxListaMovimientosPeriodoGeneralStore.log" , KLogger::DEBUG );
		$fecha1=getValueFromPost ("fechaConsultaPeriodo1");
		$fecha2=getValueFromPost ("fechaConsultaPeriodo2");
		$empresaId=getValueFromPost ("empresaId");



		// $log->LogInfo("Valor de variable de fecha1 que viene de form" . var_export ($fecha1, true));
		// $log->LogInfo("Valor de variable de fecha2 que viene de form" . var_export ($fecha2, true));
		// $log->LogInfo("Valor de variable de fecha2 que viene de form" . var_export ($empresaId, true));
	

	try{
		
	

		$listaMovimientosPeriodoGeneral = $negocio -> negocio_traeListaMovimientosPorPeriodoGeneralStoreProcedure($fecha1, $fecha2,$empresaId);
		$response["listaMovimientosPeriodoGeneral"]= $listaMovimientosPeriodoGeneral;

		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo Obtener listaMovimientosPeriodoGeneral";
	}
}

echo json_encode($response);

?>