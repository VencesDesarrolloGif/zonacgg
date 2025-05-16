<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();
if(!empty($_POST))
{

	//$log = new Klogger("ajax.log", KLogger::DEBUG);

	$numeroCuenta=getValueFromPost("numeroCta");
	//$log -> logInfo(var_export($numeroCuenta, true));

	$response = $negocio -> negocio_VerificarNumeroCuentaDuplicado($numeroCuenta);

	echo json_encode($response);
}

?>