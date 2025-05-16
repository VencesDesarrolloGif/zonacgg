<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
$sucursales = array ();
$sucursalesActuales = array();

if(!empty ($_POST)){
	//$log = new KLogger ( "ajax_eliminarSucursalXent.log" , KLogger::DEBUG );
	$identidad=$_POST['identidad'];	
	$idusuario=$_POST['idusuario'];	

	try{
		$sql = "SELECT idSucursalI
				FROM sucursalesinternas
				WHERE idEntidadPerteneciente='$identidad'";

   		$res = mysqli_query($conexion, $sql);
   		while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   		       $sucursales[] = $reg;
   		}
   		foreach ($sucursales as $sucursal) {
		    $sucursalesActuales[] = $sucursal['idSucursalI'];  // Guardamos solo los idSucursalUsr
		}

			$sucursalesArreglo = implode(',', $sucursalesActuales);

   		$sql1 = "DELETE FROM sucursalesusuario
				WHERE idUsuarioSuc = 31500
				AND idSucursalUsr IN ($sucursalesArreglo)";

   		$res1 = mysqli_query($conexion, $sql1);

		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	}catch( Exception $e ){
		$response["status"]="error";$response["error"]="No se puedo eliminar sucursal";
	}
}
echo json_encode($response);
?>