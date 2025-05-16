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
	//$log = new KLogger ( "ajax_obtenerEstatusEMpladoParaFirmaFniquitoUni.log" , KLogger::DEBUG );
	$numeroEmpleado=getValueFromPost("numeroEmpleado");
	try{

		$empleadoidd = explode("-", $numeroEmpleado);
        	$empleadoEntidad=$empleadoidd[0];
        	$empleadoConsecutivo=$empleadoidd[1];
        	$empleadoCategoria=$empleadoidd[2];

		$empleado= $negocio -> negocio_obtenerEstatusEmpladoParaFirmaFniquitoUni($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
		$response["empleado"]= $empleado;
	//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Datos";
	}
}

echo json_encode($response);

?>