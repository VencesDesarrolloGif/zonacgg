<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	// $log = new KLogger ( "ajaxCambiarEstatus.log" , KLogger::DEBUG );
	$visitanteId=getValueFromPost("idVisitante");
	$estatusVisitante=getValueFromPost("visitanteIdEstatus");
	
		// $log -> LogInfo ("VALOR DE visitanteId". var_export ($visitanteId, true));
		// $log -> LogInfo ("VALOR DE estatusVisitante ".var_export ($estatusVisitante, true));
	try
	{
		$negocio -> negocio_actualizarEstatusVisitante($visitanteId, $estatusVisitante);

		$response["status"] = "success";
		$response ["message"] = "Cambio el estatus Visitante";
	}
	catch(Exception $e)
	{
		$response["status"] = "error";
		$response["message"] = "Error al editar el estatus del visitante:" .$e -> getMessage();
	}



echo json_encode($response);

?>