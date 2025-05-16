<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_ConsultaRegistrosPatronales.log" , KLogger::DEBUG );
$response = array("status" => "success");
$registrosP= array ();

	try{
		////////////////////Se Obtienen Las Entidades Para La Consulta General Divida Por Entidades Y mandarlas  encapsuladas ////////////////////////////
		$sql = "SELECT idcatalogoRegistrosPatronales 
				FROM catalogoregistrospatronales;"; 

    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$registrosP[] = $reg;
        }

		$response["datos"]= $registrosP;	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?>