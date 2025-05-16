<?php
session_start();
require_once("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();  
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxObtenerPlantillaRequisicion.log" , KLogger::DEBUG );  
$puntoServicio=getValueFromPost("puntoServicio");
//$log->LogInfo("Valor de variable de NOMBRE que viene de form" . var_export ($puntoServicio, true));
try{
		 
	$lista= $negocio -> selectPlantillaRequisicion($puntoServicio);
	$response["lista"]= $lista;
	//$log->LogInfo("Valor de variable de nombre que viene de form" . var_export ($nombre, true));
	//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Requisición";
}

echo json_encode($response); 

?>

