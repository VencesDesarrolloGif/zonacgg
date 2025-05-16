<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();

//$log = new Klogger("ajaxVerificarNumeroIMSS.log", KLogger::DEBUG);

if(!empty($_POST))
{
	$numeroSeguroSocial=getValueFromPost("numeroSeguroSocial");
	
	
	
	//$log -> logInfo(var_export($numeroSeguroSocial, true));
	
	

	$response = $negocio -> verificarNumeroSeguroSocialDuplicado($numeroSeguroSocial);
	//$log -> logInfo(var_export($response, true));
	

	echo json_encode($response);
}
else
{
	//$log -> logInfo("No se proporcionaron datos para realizar la verificación");
	
	$response = array (
		"status" => "error",
		"message" => "No se proporcionaron datos para realizar la verificacion"
	);

	echo json_encode($response);
}

?>