<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos              = array();
$response = array("status" => "success");
// $log = new KLogger ( "ajax_getUsuariosAsignadosXRegion.log" , KLogger::DEBUG );
$region= $_POST['region'];
$lineaNegocio= $_POST['lineaNegocio'];
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $sql = "SELECT rur.idIncrementUR, u.usuario
            FROM relacionUsuarios_regiones rur
            LEFT JOIN usuarios u on u.usuarioId=rur.idUsuario
            WHERE idRegionI='$region'
            AND idLineaNegocioRUR='$lineaNegocio'
            ORDER BY u.usuario";    
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
// $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    
    $response["datos"] = $datos;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
