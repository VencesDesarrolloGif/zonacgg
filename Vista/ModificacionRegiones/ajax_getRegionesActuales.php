<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_obtenerEntidadesPorRegion.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//
try {
    $sql = "SELECT * FROM catalogoRegiones
            where EstatusRegion='0'
            order by DescripcionRegiones";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
// $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
