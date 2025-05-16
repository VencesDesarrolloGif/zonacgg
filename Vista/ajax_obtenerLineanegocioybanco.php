<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");
$cuentaclabestr=$_POST["cuentaclabe"];
$lineanegocio=$_POST["lineanegocio"];
if(!empty ($_POST))
{
		//$log = new KLogger ( "ajaxObtenerEmpleadoPorId.log" , KLogger::DEBUG );
	try{
		$cuentaclabe=substr($cuentaclabestr, 0,3);
		$datos= $negocio -> negocio_obtenercuentaclabeybanco($cuentaclabe, $lineanegocio);
		$response["datos"]= $datos;
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>