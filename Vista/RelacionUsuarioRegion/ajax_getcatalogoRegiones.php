<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
try {
    $sql = "SELECT IdRegiones,UPPER(DescripcionRegiones) AS DescripcionRegiones
            FROM catalogoRegiones
            WHERE EstatusRegion='1'
            ORDER BY DescripcionRegiones";      
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"] = $datos;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
