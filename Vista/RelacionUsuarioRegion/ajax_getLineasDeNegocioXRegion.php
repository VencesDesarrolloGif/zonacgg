<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
try {
    $region=$_POST['region'];

    $sql = "SELECT distinct ir.idLineaNegI,ln.descripcionLineaNegocio
            FROM index_regiones ir
            LEFT JOIN catalogolineanegocio ln on ln.idLineaNegocio=ir.idLineaNegI
            WHERE idRegionI='$region'";  
                
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
