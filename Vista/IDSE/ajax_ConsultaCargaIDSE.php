<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger("consultaCargaIDSE.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();
$regPat =$_POST["regPatIDSE"];
$mes =$_POST["mesIDSE"];
$anio=$_POST["anioActual"];
$tipo=$_POST["tipoDoc"];

try {
    if($tipo=='1') {
        $nombreDocumento="IDSE_EMA_".$regPat."_".$mes.$anio;

        $sql = "SELECT NombreArchivoIDSEEMA as nombreDocumentoIDSE 
                FROM IDSE_EMA
                WHERE NombreArchivoIDSEEMA LIKE '%$nombreDocumento%'
                ORDER BY idArchivoIDSEEMA DESC
                LIMIT 1"; 

    }else if($tipo=='2') {
        $nombreDocumento="IDSE_EBA_".$regPat."_".$mes.$anio;

        $sql = "SELECT NombreArchivoIDSEEBA  as nombreDocumentoIDSE 
                FROM IDSE_EBA
                WHERE NombreArchivoIDSEEBA LIKE '%$nombreDocumento%'
                ORDER BY idArchivoIDSEEBA DESC
                LIMIT 1";    
    }
        // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
