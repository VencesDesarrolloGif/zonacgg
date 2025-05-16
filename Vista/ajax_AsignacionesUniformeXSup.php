<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_AsigacionesUNIFSUP.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$Nosupervisor= $_SESSION["userLog"]["empleadoId"];
$rol= $_SESSION["userLog"]["rol"];
//$log->LogInfo("Valor de la variable Nosupervisor: " . var_export ($Nosupervisor, true));     
//$log->LogInfo("Valor de la variable rol: " . var_export ($rol, true));     

if ($rol=="Supervisor") {
   $tipoBusqueda='4';
}else if ($rol=="Consulta Supervisor") {
    $tipoBusqueda='5';
}else if ($rol=="Reclutador") {
    $tipoBusqueda='6';
}
//$log->LogInfo("Valor de la variable tipoBusqueda: " . var_export ($tipoBusqueda, true));     

try {
    //$datos = $negocio -> obtenerListaHistoricoAsignacionesSup($Nosupervisor,$tipoBusqueda);
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));     
    
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
