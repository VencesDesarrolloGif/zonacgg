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

	
		// $log = new KLogger ( "ajaxListaMovimientos.log" , KLogger::DEBUG );
		$fecha=getValueFromPost ("fechaConsulta");
		$idBanco=getValueFromPost ("idBanco");

	try{
		
		$dia=substr($fecha, 8,2);
		$mes=substr($fecha, 5,2);
		$anio=substr($fecha, 0,4);

		$listaMovimientosDiaBanco = $negocio -> negocio_traeListaMovimientosPorDiaBanco($dia, $mes, $anio, $idBanco);
		$response["listaMovimientosDiaBanco"]= $listaMovimientosDiaBanco;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fecha, true));
		// $log->LogInfo("Valor de variable dia substr" . var_export ($dia, true));
		// $log->LogInfo("Valor de variable mes substr" . var_export ($mes, true));
		// $log->LogInfo("Valor de variable anio substr" . var_export ($anio, true));
		// $log->LogInfo("Valor de variable idBanco substr" . var_export ($idBanco, true));
		// $log->LogInfo("Valor de la variable \$response listaMovimientosDiaBanco: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo listaMovimientosDiaBanco";
	}
}

echo json_encode($response);

?>