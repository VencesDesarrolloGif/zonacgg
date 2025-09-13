<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";

$response = array();
$datos    = array();
$anio     = $_POST['anio'];
$periodo     = $_POST['periodo'];

$idAnio=null;
$rangos=array();

$log = new KLogger("ajax_llenarPeriodos.log", KLogger::DEBUG);

    //deduccion
$sql = "SELECT IdAnio from aniosperiodos WHERE IdPeriodo='$periodo' AND DescAnio='$anio'";
$res = mysqli_query($conexion, $sql);

if(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    $idAnio = $reg['IdAnio'];
}

if($idAnio!=null){
	$sql1="SELECT *FROM rangoperiodos WHERE IdAnio='$idAnio'";
	$res = mysqli_query($conexion, $sql1);

	while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {

    	$rangos[] = $reg;
	}	

	for($i=0;$i<count($rangos);$i++){
		$rangos[$i]["numero"]=$i+1;
	}

}

$log->LogInfo("Valor de la variable rangos:  " . var_export($rangos, true));

$response["datos"] = $rangos;

echo json_encode($response);
