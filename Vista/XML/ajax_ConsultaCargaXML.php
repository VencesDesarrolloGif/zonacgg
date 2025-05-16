<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger("consultaCargaXML.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();
$mes =$_POST["mesXML"];
$anio=$_POST["anioActual"];
$tipo=$_POST["tipoDoc"];

try {
    if($tipo=='1') {
        $nombreDocumento="XML_IMSS".$mes.$anio;

        $sql = "SELECT NombreArchivoXMLImss as nombreDocumentoXML 
                FROM XML_IMSS
                WHERE NombreArchivoXMLImss LIKE '%$nombreDocumento%'
                ORDER BY idArchivoXMLImss DESC
                LIMIT 1"; 

    }else if($tipo=='2') {
        $nombreDocumento="XML_INFONAVIT".$mes.$anio;

        $sql = "SELECT NombreArchivoXMLInfonavit  as nombreDocumentoXML 
                FROM XML_INFONAVIT
                WHERE NombreArchivoXMLInfonavit LIKE '%$nombreDocumento%'
                ORDER BY idArchivoXMLInfonavit DESC
                LIMIT 1";    
    }
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al iniciar sesion";}
echo json_encode($response);
