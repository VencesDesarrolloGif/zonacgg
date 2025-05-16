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

	
		//$log = new KLogger ( "ajaxObtenerAsistenciaEmpleadoFecha.log" , KLogger::DEBUG );

	try{

		$empleadoId=getValueFromPost("empleadoId");
		$empleadoidd = explode("-", $empleadoId);
		
		$empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];

		$fechaAsistencia=getValueFromPost("fechaAsistencia");

		$asistencia= $negocio -> getAsistenciaByEmpleadoFecha($fechaAsistencia, $empleadoEntidad, $empleadoConsecutivo,$empleadoCategoria);
		$response["asistencia"]= $asistencia;

		/*$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
		$log->LogInfo("Valor de variable empleadoEntidad substr" . var_export ($empleadoEntidad, true));
		$log->LogInfo("Valor de variable empleadoConsecutivo substr" . var_export ($empleadoConsecutivo, true));
		$log->LogInfo("Valor de variable empleadoCategoria substr" . var_export ($empleadoCategoria, true));
		$log->LogInfo("Valor de variable fechaAsistencia " . var_export ($fechaAsistencia, true));
		
		$log->LogInfo("Valor de la variable \$response asistencia: " . var_export ($response, true));*/

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Asistencia";
	}
}

echo json_encode($response);

?>