<?php
session_start();

require_once "../Negocio/Negocio.class.php"; 
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_EstatusEmpleadoPorFecha.log" , KLogger::DEBUG );
$numeroEmpleado=$_POST["numeroEmpleado"];
$numeroEmpleadoexplode=(explode("-",$numeroEmpleado));
$empleadoEntidad = $numeroEmpleadoexplode[0];
$empleadoConsecutivo = $numeroEmpleadoexplode[1];
$empleadoCategoria = $numeroEmpleadoexplode[2];
$fechaActual = date("Y-m-d");
//$log->LogInfo("Valor de fechaActual" . var_export ($fechaActual, true));
try {
    $empleadoEstatus   = $negocio->getEstatusEmpleadoXFecha($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
    $response["datos"] = $empleadoEstatus;
    $response["datos"][0]["FechaActual"]=$fechaActual;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvo El Estatus Del Empleado";
}
echo json_encode($response);
