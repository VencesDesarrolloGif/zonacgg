<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_consultaUsr.log" , KLogger::DEBUG );
$response = array("status" => "success");
// $log->LogInfo("Valor de la variable $_SESSION: " . var_export ($_SESSION, true));
// $log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
$rol=$_SESSION['userLog']['rol'];
try{
        $response["rol"]=$rol;
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>