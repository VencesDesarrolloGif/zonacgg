<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxdatosCierrePeriodo.log" , KLogger::DEBUG );

$response = array("status" => "success");

$fecha1= getValueFromPost("fechaInicioPeriodo");  // modificar por la fecha de inicio del cierre que no se realizao 
$fecha2= getValueFromPost("fechaTerminoPeriodo");  // modificar po rla fecha del cierre el cual no se cero a tiempo

//$fecha1 = "2020-11-16";
//$fecha2 = "2020-11-30";


$periodoId= getValueFromPost("idTipoPeriodo");
// $log->LogInfo("Valor de la variable fecha1: " . var_export ($fecha1, true));
// $log->LogInfo("Valor de la variable fecha2: " . var_export ($fecha2, true));
// $log->LogInfo("Valor de la variable periodoId: " . var_export ($periodoId, true));

try{
	$datosCierrePeriodo= $negocio -> getDatosCierrePeriodoByFechasAndTipoPeriodo($fecha1, $fecha2, $periodoId);
	$response["datosCierrePeriodo"]= $datosCierrePeriodo;
	//$log->LogInfo("Valor de la variable \$datosCierrePeriodo: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener datos";
}

echo json_encode($response);

?>