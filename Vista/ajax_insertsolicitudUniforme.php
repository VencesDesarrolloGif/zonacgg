<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
$response = array("status" => "success");
//$log = new KLogger ( "ajax_insertSolicitudUniforme.log" , KLogger::DEBUG );
$numempleado = $_POST['numempleado'];
$tipouniSolicitud = $_POST['tipouniSolicitud'];
$cantidadsolicitud = $_POST['cantidadsolicitud'];

$numeroSeparado= explode("-", $numempleado);
$empleadoEntidad=$numeroSeparado[0];
$empleadoConsecutivo=$numeroSeparado[1];
$empleadoCategoria=$numeroSeparado[2];

try{
	$negocio -> insertsolicitudUniforme($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$tipouniSolicitud,$cantidadsolicitud);
	//$log->LogInfo("Valor de la variable uniformes: " . var_export ($uniformes, true));
	}catch( Exception $e ){
		  $response["status"]="error";
		  $response["error"]="No se insertoSolicitud";
		 }

echo json_encode($response);

?>