<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$log = new KLogger("consultaCargaPDFIMSS.log", KLogger::DEBUG);
$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();

$mes =$_POST["mes"];
$anio=$_POST["anio"];

try {
    $datos = $negocio -> consultaPDFIMSS($mes,$anio);
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
