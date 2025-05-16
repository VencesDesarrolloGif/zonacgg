<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log               = new KLogger("ajax_consultaRolesOperativos.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));    
$TipoTurno=$_POST['TipoTurno'];
try {
    $datos = $negocio -> obtenerRolesOperativos($TipoTurno);
   // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));     
    
    $response["status"] = "success";
    $response["datos"]  = $datos; 
} catch (Exception $e) {
    $response["mensaje"] = "Error al obtener los contratos";}
echo json_encode($response);
