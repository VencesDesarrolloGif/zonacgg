<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
$sucursales = array ();
$sucursalesActuales = array();
if(!empty ($_POST)){
	// $log = new KLogger ( "ajax_SucursalesXent.log" , KLogger::DEBUG );
		// $log->LogInfo("Valor de session" . var_export ($_SESSION, true));
		// $log->LogInfo("Valor de count" . var_export (count($_SESSION['userLog']['sucursalesUsuario']), true));

	$identidad=$_POST['EntidadSeleccionada'];	

	try{
		for ($i = 0; $i < count($_SESSION['userLog']['sucursalesUsuario']); $i++) {
		    $sucursalesActuales[] = $_SESSION['userLog']['sucursalesUsuario'][$i];  // Guardamos solo los idSucursalUsr
		}
		$sucursalesArreglo = implode(',', $sucursalesActuales);
		// $log->LogInfo("Valor de sucursalesArreglo" . var_export($sucursalesArreglo, true));
		$sql = "SELECT idSucursalI,nombreSucursal
				FROM sucursalesinternas
				WHERE idEntidadPerteneciente='$identidad'
				AND idSucursalI IN ($sucursalesArreglo)";

		// $log->LogInfo("Valor de sql" . var_export($sql, true));
   		$res = mysqli_query($conexion, $sql);
   		while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   		       $sucursales[] = $reg;
   		}
   		$response["datos"]=$sucursales;
		// $log->LogInfo("Valor de sucursales" . var_export($sucursales, true));
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	}catch( Exception $e ){
		$response["status"]="error";$response["error"]="No se puedo eliminar sucursal";
	}
}
echo json_encode($response);
?>