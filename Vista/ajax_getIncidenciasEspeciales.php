<?php
session_start(); 

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajaxConsutaIncidenciasEspeciales.log" , KLogger::DEBUG );

$fecha1=$_GET["fecha1"];
$fecha2=$_GET["fecha2"];
$numeroEmpleado=$_GET["numeroEmpleado"];

$empleadoidd = explode("-", $numeroEmpleado);
/*
        $empleadoEntidad=substr($numeroEmpleado,0,2);
		$empleadoConsecutivo=substr($numeroEmpleado,3,4);
		$empleadoTipo=substr($numeroEmpleado,8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoTipo=$empleadoidd[2];




//$log->LogInfo("Valor de la variable \$fecha1 : " . var_export ($fecha1, true));
//$log->LogInfo("Valor de la variable \$fecha2 : " . var_export ($fecha2, true));
//$log->LogInfo("Valor de la variable \$numeroEmpleado : " . var_export ($numeroEmpleado, true));
//$log->LogInfo("Valor de la variable \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
//$log->LogInfo("Valor de la variable \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
//$log->LogInfo("Valor de la variable \$empleadoTipo : " . var_export ($empleadoTipo, true));

$response = array("status" => "success");
	try{
		
		$lista= $negocio -> getIncidenciasEspeciales($fecha1,$fecha2,$empleadoEntidad,$empleadoConsecutivo,$empleadoTipo);
		$response["lista"]= $lista;

		
		//$log->LogInfo("Valor de la variable \$response : " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Requisición";
	}


echo json_encode($response);

?>