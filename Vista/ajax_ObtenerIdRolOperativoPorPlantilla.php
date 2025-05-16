<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php"); 
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";  
$datos              = array();
//$log               = new KLogger("ajax_ObtenerIdRolOperativoPorPlantilla.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));    
$PlantillaIdRol=$_POST['PlantillaIdRol'];
try {
    $datos = $negocio -> obtenerIdRolesOperativos($PlantillaIdRol);
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));     
    
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al obtener Id El rol operativo por plantilla";}
echo json_encode($response);
