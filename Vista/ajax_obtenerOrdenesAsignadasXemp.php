<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_obtenerOrdenesAsignadasXemp.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$ordenes              = array();
$numEmp= getValueFromPost("numEmp");

try {
    $ordenes = $negocio -> obtenerOrdenesbyEMp($numEmp);
 
    $response["status"] = "success";
    $response["datos"]  = $ordenes;
//$log->LogInfo("Valor de la variable datos1: " . var_export ($ordenes, true));     

} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
