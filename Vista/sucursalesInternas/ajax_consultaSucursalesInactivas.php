<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$entidad=$_POST['entidad'];
//$log = new KLogger ( "ajax_consultaSucursalesInactivas.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $sql = "SELECT idSucursalI,nombreSucursal
            FROM sucursalesInternas
            WHERE idEntidadPerteneciente='$entidad'
            AND estatusSucursalI='0'";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
        }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch(Exception $e) {
      $response["mensaje"] = "Error al Obtener Entidades";
}
echo json_encode($response);
