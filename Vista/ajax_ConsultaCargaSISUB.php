<?php
session_start();
require_once("../libs/logger/KLogger.php");
require "conexion.php";
//$log = new KLogger("consultaCargaSISUB.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();

$cuatrimestre =$_POST["cuatrimestre"];
$anio=$_POST["anio"];

$nombreDocumento="SISUB_".$cuatrimestre.$anio;

try {
 
    $sql = "SELECT * 
            FROM documentos_SISUB
            WHERE NombreArchivoSISUB LIKE '%$nombreDocumento%'
            ORDER BY idArchivoSISUB DESC
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
