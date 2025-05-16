<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_ConsultaIncidencia.log" , KLogger::DEBUG );
$response = array("status" => "success");
$catalogoIncidencias= array ();
	try{
		$sql = "SELECT *
				FROM CatalogoTipoIncidenciaCentroC"; 

    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$catalogoIncidencias[] = $reg;
        }
		
		$response["datos"]= $catalogoIncidencias;	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?>