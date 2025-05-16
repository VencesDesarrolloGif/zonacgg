<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
$usuario=$_SESSION["userLog"];

		// $log = new KLogger ( "ajax_clavesparacomprobar.log" , KLogger::DEBUG );


	// $log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));

	try{
	
		$datos= $negocio -> negocio_obtenerClavesComprobacione($usuario);
		//$log->LogInfo("Valor de variable datos" . var_export ($datos, true));
		$response["datos"]= $datos;
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No Existen Comprobaciones Disponibles";
	}
echo json_encode($response);

?>