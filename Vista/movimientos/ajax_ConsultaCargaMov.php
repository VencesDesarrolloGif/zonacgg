<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger("consultaCargaMov.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();

$mes =$_POST["mes"];
$anio=$_POST["anioActual"];

$nombreDocumento="movimiento_".$mes.$anio;

try {
    $sql = "SELECT * 
            FROM documentos_movimientos
            WHERE NombreArchivoMov LIKE '%$nombreDocumento%'
            ORDER BY idArchivoMov DESC
            LIMIT 1";      
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
