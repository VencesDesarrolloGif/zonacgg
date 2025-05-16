<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_ConsultaIncidencias.log" , KLogger::DEBUG );
$response = array("status" => "success");
$catalogoEspecificacion= array ();
$idIncidencia=$_POST["incidencia"];
	try{
		$sql = "SELECT *
				FROM CatalogoEspecificacionIncidenciaCentroC
				WHERE idTipoIncidenciaEsp=$idIncidencia"; 

    	$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           	$catalogoEspecificacion[] = $reg;
        }
		
		$response["datos"]= $catalogoEspecificacion;	
       	
	}catch(Exception $e ){
		$response["status"]="error";
		$response["error"]="No se puedo obtener Empleado";
	}
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?>