<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_consultaSubDepartamentos.log" , KLogger::DEBUG );

$departamento= $_POST['departamento'];
try {
    $sql = "SELECT RPD.idPuesto,descripcionPuesto
            FROM relacionpuestosdepartamentos rpd
            LEFT JOIN catalogopuestos CP ON cp.idPuesto=rpd.idPuesto
            WHERE idDepartamento='$departamento'
            ORDER BY descripcionPuesto";

$log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
        }
$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch(Exception $e) {
      $response["mensaje"] = "Error al Obtener Entidades";
}
echo json_encode($response);
