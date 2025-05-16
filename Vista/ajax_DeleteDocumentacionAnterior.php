<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio(); 

$response = array ();

verificarInicioSesion($negocio);


	//$log = new KLogger ( "ajax_DeleteDocumentacionAnterior.log" , KLogger::DEBUG );
	//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));    
	$documentacion = array (
		"idEntidadEmpladoDocumento" =>getValueFromPost("numeroEmpleadoEntidad"), 
		"empleadoConsecutivoDocumento" => getValueFromPost("numeroEmpleadoConsecutivo"),
		"empleadoTipoDocumento" => getValueFromPost("numeroEmpleadoTipo"),
		);
//$log->LogInfo("Valor de la variable documentacion: " . var_export ($documentacion, true));       
	try
	{
		$negocio -> negocio_DeleteEntregaDocumentacion($documentacion);

		$response["status"] = "success";
		$response ["message"] = "Documentacion Registrada";
	}
	catch(Exception $e)
	{
		$response["status"] = "error";
		$response["message"] = "Error al registrar Documentacion:" .$e -> getMessage();
	}


echo json_encode($response);

?>