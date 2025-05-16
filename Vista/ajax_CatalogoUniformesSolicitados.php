<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
//verificarInicioSesion ($negocio);
$response = array("status" => "success");
$uniformes= array();
//$log = new KLogger ( "ajax_CatalogoUniformesSolicitados.log" , KLogger::DEBUG );
try{
	$uniformes= $negocio -> consultacatalogoUniformesSolicitud();
	//$log->LogInfo("Valor de la variable uniformes: " . var_export ($uniformes, true));
    $response["uniformes"]=$uniformes;
	} 
	catch( Exception $e ){
		  $response["status"]="error";
		  $response["error"]="No se puede obtener Empleado";
		 }

echo json_encode($response);

?>