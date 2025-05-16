<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxObtenerInfoXEmpID.log" , KLogger::DEBUG );
$empleadoId=getValueFromPost("numeroEmpleado");
//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($empleadoId, true));
try{
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
    
    $empleado= $negocio -> obtenerInfoAsigXEmp($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
    $response["empleado"]= $empleado;
    $ordenes = $negocio -> obtenerOrdenesbyEMp($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
    $response["ordenes"]=$ordenes;
   }catch( Exception $e ){
	  $response["status"]="error";
	  $response["error"]="No se puedo obtener Empleado";
	 }
echo json_encode($response);

?>