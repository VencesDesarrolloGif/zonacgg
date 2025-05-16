<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");




	
		// $log = new KLogger ( "ajaxListaIngresosEgresosProcedure.log" , KLogger::DEBUG );
		$mes=getValueFromPost ("mes");
		$anio=getValueFromPost ("anio");
		$empresaId=getValueFromPost ("empresaId");
		
		// $log->LogInfo("Valor de variable de mes que viene de form" . var_export ($mes, true));
		// $log->LogInfo("Valor de variable de anio que viene de form" . var_export ($anio, true));
		// $log->LogInfo("Valor de variable de empresa que viene de form" . var_export ($empresaId, true));
	

	try{
		
	

		$listaIngresosEgresos = $negocio ->negocio_traerListaIngresosEgresos($mes, $anio, $empresaId);
        
		$response["listaIngresosEgresos"]= $listaIngresosEgresos;

		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo listaIngresosEgresos";
	}


echo json_encode($response);

?>