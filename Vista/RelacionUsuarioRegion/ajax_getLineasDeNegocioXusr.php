<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
try {
    $usr=$_POST['usr'];

    $sql = "SELECT DISTINCT idLineaNegocioRUR,descripcionLineaNegocio
            FROM relacionusuarios_regiones rur
            LEFT JOIN catalogolineanegocio ln on ln.idLineaNegocio=rur.idLineaNegocioRUR
            WHERE idUsuario='$usr'
            ORDER BY idLineaNegocioRUR";  
                
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
