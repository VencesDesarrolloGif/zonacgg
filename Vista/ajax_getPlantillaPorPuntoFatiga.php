<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response                     = array();
$response["status"]           = "error";
$puntoServicio            = $_POST["puntoServicio"]; 
$rangoFecha1            = $_POST["rangoFecha1"]; 
$rangoFecha2            = $_POST["rangoFecha2"]; 
//$usuario                      = $_SESSION ["userLog"]["usuario"];
$datos                        = array();
//$log = new KLogger ( "ajax_getPlantillaPorPuntoFatiga.log" , KLogger::DEBUG ); 
//$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
try {
    $sql = "SELECT * from servicios_plantillas
            where puntoServicioPlantillaId='$puntoServicio'
            and ((estatusPlantilla = 1) or (estatusPlantilla = 0 and ((fechaTerminoPlantilla between CAST('$rangoFecha1' AS DATE) and CAST('$rangoFecha2' AS DATE))
            OR (fechaTerminoPlantilla > CAST('$rangoFecha2' AS DATE)))))";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";}
echo json_encode($response);
