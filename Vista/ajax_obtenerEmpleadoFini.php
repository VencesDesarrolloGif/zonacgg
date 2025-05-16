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
		//$log = new KLogger ( "ajaxObtenerEmpleadoPorId.log" , KLogger::DEBUG );
		$empleadoId=getValueFromPost("numeroEmpleado");
	try{
	//	$empleadoEntidad=substr($empleadoId, 0,2);
	//	$empleadoConsecutivo=substr($empleadoId, 3,4);
	//	$empleadoCategoria=substr($empleadoId, 8,2);
		$empleado= $negocio -> negocio_obtenerEmpleadoFini($empleadoId);
		$response["empleado"]= $empleado;
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>