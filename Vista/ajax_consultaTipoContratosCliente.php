<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log               = new KLogger("ajax_consultaTipoContratosCliente.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();

try {
    $datos = $negocio -> obtenerCatalogoContratosDeClientes();
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));     
    
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al obtener los contratos";}
echo json_encode($response);
