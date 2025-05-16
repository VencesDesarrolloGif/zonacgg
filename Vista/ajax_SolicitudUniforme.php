<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_SolicitudUniforme.log", KLogger::DEBUG);
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario            = $_SESSION ["userLog"]["usuario"];
try {
    $datos = $negocio -> obtenerSolicitudUniforme();
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));     

    for ($i = 0; $i < count($datos); $i++) {
        $idSolicitudUniforme     = $datos[$i]["idSolicitudUniforme"];      
        $datos[$i]["AcciónYaAsignado"] = "<img style='width: 15%' title='Aceptar' src='img/confirmarImss.png' class='cursorImg' id='btnAsignado' onclick=confirmarSolicitudManual('$idSolicitudUniforme')>"; 
        }
    $response["status"] = "success";
    $response["datos"]  = $datos;
//$log->LogInfo("Valor de la variable datos1: " . var_export ($datos, true));     

} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
