<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
if(!empty ($_POST)){
	//$log = new KLogger ( "ajax_eliminarSucursalUsuario.log" , KLogger::DEBUG );
	$idusuario=$_POST['idusuario'];	
	$idSucursalUsr=$_POST['idSucursalUsr'];	

	try{
		$sql = "DELETE FROM sucursalesusuario
				WHERE idUsuarioSuc = '$idusuario'
				AND idSucursalUsr = '$idSucursalUsr'";

   		$res = mysqli_query($conexion, $sql);
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	}catch( Exception $e ){
		$response["status"]="error";$response["error"]="No se puedo eliminar sucursal";
	}
}
echo json_encode($response);
?>