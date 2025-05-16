<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
	//	$log = new KLogger ( "ajaxConsultaMunicipiosPorEntidad.log" , KLogger::DEBUG );
	try{
		
		$ListaDatosEmpleado = $negocio -> negocio_ObtenerDatosPersonalesYCurp();
		$response["ListaDatosEmpleado"]= $ListaDatosEmpleado;
		//$log->LogInfo("Valor de response" . var_export ($response, true));
		

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo ListaDatosEmpleado";
	}
echo json_encode($response);

?>