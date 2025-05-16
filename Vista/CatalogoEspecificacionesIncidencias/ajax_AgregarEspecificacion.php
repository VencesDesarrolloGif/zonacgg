<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_AgregarEspecificacion.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
$response = array("status" => "success");
$incidencia=$_POST['incidencia'];
$especificacion=$_POST['especificacion'];
$usuario=$_SESSION['userLog']['usuario'];

	try{
		$sql1 ="INSERT INTO CatalogoEspecificacionIncidenciaCentroC(idTipoIncidenciaEsp,descripcionEspecificacionIncidenciaCC,usuario,fechaAdd) VALUES('$incidencia','$especificacion','$usuario',now())"; 

    	$res1 = mysqli_query($conexion, $sql1);
	}catch(Exception $e ){
		$response["status"]="error";
	}
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
// $log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));
echo json_encode($response);
?>