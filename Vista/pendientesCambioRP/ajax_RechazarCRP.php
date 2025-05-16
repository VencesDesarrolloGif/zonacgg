<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_RechazarCRP.log" , KLogger::DEBUG );
$response = array("status" => "success");

$entidad=$_POST['entidad'];
$consecutivo=$_POST['consecutivo'];
$categoria=$_POST['categoria'];

	try{
		//////////////////// 2 es para saber que se cancelo ////////////////////////////
		$sql = "UPDATE datosimss 
            	SET cambioRPxPS='2'
            	WHERE empladoEntidadImss='$entidad'
            	AND empleadoConsecutivoImss='$consecutivo'
            	AND empleadoCategoriaImss='$categoria'"; 

    	$res = mysqli_query($conexion, $sql);
		
		$response["message"]= "Se declino correctamente";	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["message"]="Error al declinar";
	}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);
?>