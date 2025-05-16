<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	//$log = new KLogger ( "ajax_reactivarPuntoServicio.log" , KLogger::DEBUG );
	$idPuntoServicio=getValueFromPost("idPuntoServicio");
	$esatusPunto=getValueFromPost("esatusPunto");
	$fechaInicioServicio=getValueFromPost("fechaInicioServicio");
	
		//$log -> LogInfo ("VALOR DE fechaInicioServicio". var_export ($fechaInicioServicio, true));
		//$log -> LogInfo ("VALOR DE idPuntoServicio ".var_export ($idPuntoServicio, true));
	try
	{
		$negocio -> actualizaEstatusPuntoServicioReactivacion($idPuntoServicio, $esatusPunto, $fechaInicioServicio);

		$response["status"] = "success";
		$response ["message"] = "Servicio reactivado";
	}
	catch(Exception $e)
	{
		$response["status"] = "error";
		$response["message"] = "Error al reactivar punto de servicio:" .$e -> getMessage();
	}



echo json_encode($response);

?>