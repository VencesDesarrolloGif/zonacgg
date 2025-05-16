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

	try{
		
		$dia=substr($fechaConsulta1, 8,2);
		$mes=substr($fechaConsulta1, 5,2);
		$anio=substr($fechaConsulta1, 0,4);

		$listaVisitantesConFechaDe = $negocio -> negocio_traerListaVisitantesConFechaDe($dia, $mes, $anio);
		$response["listaVisitantesConFechaDe"]= $listaVisitantesConFechaDe;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fechaConsulta1, true));
		// $log->LogInfo("Valor de variable dia substr" . var_export ($dia, true));
		// $log->LogInfo("Valor de variable mes substr" . var_export ($mes, true));
		// $log->LogInfo("Valor de variable anio substr" . var_export ($anio, true));
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