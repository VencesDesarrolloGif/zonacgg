<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_GetEstadoNacimientoPostulate.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT  idEntidadFederativa, nombreEntidadFederativa, claveEntidadF from entidadesfederativas where (idEntidadFederativa!='50' and idEntidadFederativa!='33')";    

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
    //$log->LogInfo("Valor de la variable response " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";
}
echo json_encode($response);
