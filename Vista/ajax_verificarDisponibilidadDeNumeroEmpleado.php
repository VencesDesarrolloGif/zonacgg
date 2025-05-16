<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio();

if (!empty($_POST))
{
    //$log = new KLogger ( "ajax.log" , KLogger::DEBUG );


	$numeroEmpleado = getValueFromPost ("numeroEmpleado");
	//$log -> LogInfo (var_export ($numeroEmpleado, true));

	
	$response = $negocio -> negocio_verificarDisponibilidadDeNumeroDeEmpleado ($numeroEmpleado);

	echo json_encode ($response);
}

?>
