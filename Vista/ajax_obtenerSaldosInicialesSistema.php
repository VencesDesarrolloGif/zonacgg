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

	
		// $log = new KLogger ( "ajaxConsultaSaldosInicialesSistema.log" , KLogger::DEBUG );
		$fechaDia=getValueFromPost("fechaDia");
		$empresaId=getValueFromPost("empresaId");

	try{
		
		$dia=substr($fechaDia, 8,2);
		$mes=substr($fechaDia, 5,2);
		$anio=substr($fechaDia, 0,4);

		$listaSaldosIniciales= $negocio -> negocio_ListaSaldosIncialesDelDiaSistema($dia, $mes, $anio, $empresaId);
		$response["listaSaldosIniciales"]= $listaSaldosIniciales;

		// $log->LogInfo("Valor de variable de fecha que viene de form" . var_export ($fechaDia, true));
		// $log->LogInfo("Valor de variable dia substr" . var_export ($dia, true));
		// $log->LogInfo("Valor de variable mes substr" . var_export ($mes, true));
		// $log->LogInfo("Valor de variable anio substr" . var_export ($anio, true));
		// $log->LogInfo("Valor de variable empresaId " . var_export ($empresaId, true));
		// $log->LogInfo("Valor de la variable \$response listaSaldosIniciales: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Saldos Iniciales";
	}
}

echo json_encode($response);

?>