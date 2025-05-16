<?php
session_start();
require_once("../libs/logger/KLogger.php");
require "conexion.php";
//$log = new KLogger("ajax_ConsultaEMAEBA.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();

$tipo = $_POST["tipoDoc"];
$anio = $_POST["anioDoc"];
$mes  = $_POST["mesDoc"];
$registroPatronal = $_POST["regDoc"];


try {
    if ($tipo=='3') {
        $nombreDocumento="IDSE_EMA_".$registroPatronal."_".$mes.$anio;
    $sql = "SELECT * 
            FROM IDSE_EMA
            WHERE NombreArchivoIDSEEMA LIKE '%$nombreDocumento%'
            ORDER BY idArchivoIDSEEMA DESC
            LIMIT 1";      
    }else if ($tipo=='4'){
        $nombreDocumento="IDSE_EBA_".$registroPatronal."_".$mes.$anio;
        $sql = "SELECT * 
            FROM IDSE_EBA
            WHERE NombreArchivoIDSEEBA LIKE '%$nombreDocumento%'
            ORDER BY idArchivoIDSEEBA DESC
            LIMIT 1"; 
    }
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
