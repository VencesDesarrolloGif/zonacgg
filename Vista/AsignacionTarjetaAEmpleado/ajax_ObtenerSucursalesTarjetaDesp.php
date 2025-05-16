<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ObtenerSucursalesTarjetaDesp.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
try {
        $sql = "SELECT * from sucursalesinternas order by nombreSucursal";      
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
