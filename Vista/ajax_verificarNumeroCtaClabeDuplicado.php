<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();
if(!empty($_POST))
{

	//$log = new Klogger("ajaxVerificarNumeroCuentaClabeDuplicado.log", KLogger::DEBUG);

	$numeroCuentaClabe=getValueFromPost("numeroCuentaClabe");
	//$log -> logInfo(var_export($numeroCuentaClabe, true));

	$response = $negocio -> negocio_VerificarNumeroCuentaClabeDuplicado($numeroCuentaClabe);
	//$log -> logInfo(var_export($response, true));

	echo json_encode($response);
}

?>