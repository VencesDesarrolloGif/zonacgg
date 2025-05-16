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
		//$log = new KLogger ( "AJAXOBTENERNUMRODEFIMIQUITOS.log" , KLogger::DEBUG );
		$empleadoId=getValueFromPost("numeroEmpleado");
	try{
		

		 $empleadoidd = explode("-", $empleadoId);
/*
         $empleadoEntidad=substr($empleadoId, 0,2);
		$empleadoConsecutivo=substr($empleadoId, 3,4);
		$empleadoCategoria=substr($empleadoId, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];

		$numeroFinis= $negocio -> negocio_obtenerFiniquitoPorConfirmar($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);

//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export (count($numeroFiniquitos), true));
		$numeroFiniquitos=count($numeroFinis);
		$response["numeroFiniquitos"]= $numeroFiniquitos;
		
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>