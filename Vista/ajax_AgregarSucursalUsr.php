<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
if(!empty ($_POST)){
	//$log = new KLogger ( "ajax_AgregarSucursalUsr.log" , KLogger::DEBUG );
	$idSucursal=$_POST['idSucursal'];	
	$idusuario=$_POST['idusuario'];	

	try{
		$sql = "INSERT INTO sucursalesusuario VALUES ('$idusuario','$idSucursal');";

   		$res = mysqli_query($conexion, $sql);
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	}catch( Exception $e ){
		$response["status"]="error";$response["error"]="No se puedo agregar sucursal";
	}
}
echo json_encode($response);
?>