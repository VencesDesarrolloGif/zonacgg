<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");

if(!empty ($_POST)){	
		//$log = new KLogger ( "ajaxObtenerEmpleadoPorId.log" , KLogger::DEBUG );
		$entidadUniforme=getValueFromPost("entidad");
		$tipoUniforme=getValueFromPost("idUniforme");
		$sucursalStock=getValueFromPost("sucursalStock");

try{
	
	$totalUnifome= $negocio -> obtenerUniformesPorEntidad($entidadUniforme, $tipoUniforme,$sucursalStock);
	$response["totalUni"]= $totalUnifome;
	//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}
echo json_encode($response);
?>