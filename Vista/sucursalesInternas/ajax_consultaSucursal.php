<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$sucursal= $_POST['sucursalNueva'];
//$log = new KLogger ( "ajax_consultaSucursal.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT count(idSucursalI) as totalSucursal
            FROM sucursalesInternas
            WHERE nombreSucursal = '$sucursal'";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
        }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch(Exception $e) {
      $response["mensaje"] = "Error al consultar sucursales existentes";
}
echo json_encode($response);
