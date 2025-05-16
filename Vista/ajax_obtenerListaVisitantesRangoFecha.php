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

	
		// $log = new KLogger ( "ajaxVisitante.log" , KLogger::DEBUG );
		$fechaConsulta1=getValueFromPost("fechaConsulta1");
		$fechaConsulta2=getValueFromPost("fechaConsulta2");
	try{
		
		$dia1=substr($fechaConsulta1, 8,2);
		$mes1=substr($fechaConsulta1, 5,2);
		$anio1=substr($fechaConsulta1, 0,4);

		$dia2=substr($fechaConsulta2, 8,2);
		$mes2=substr($fechaConsulta2, 5,2);
		$anio2=substr($fechaConsulta2, 0,4);

		$listaVisitantesConRangoDeFecha = $negocio -> negocio_traerListaVisitantesConRangoDeFecha($dia1, $mes1, $anio1, $dia2, $mes2, $anio2);
		$response["listaVisitantesConRangoDeFecha"]= $listaVisitantesConRangoDeFecha;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fechaConsulta1, true));
		// $log->LogInfo("Valor de variable dia substr" . var_export ($dia1, true));
		// $log->LogInfo("Valor de variable mes substr" . var_export ($mes1, true));
		// $log->LogInfo("Valor de variable anio substr" . var_export ($anio1, true));

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fechaConsulta2, true));
		// $log->LogInfo("Valor de variable dia substr" . var_export ($dia2, true));
		// $log->LogInfo("Valor de variable mes substr" . var_export ($mes2, true));
		// $log->LogInfo("Valor de variable anio substr" . var_export ($anio2, true));
		// $log->LogInfo("Valor de la variable \$response listaVisitantesConFechaDe: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Visitantes con fecha";
	}
}

echo json_encode($response);

?>