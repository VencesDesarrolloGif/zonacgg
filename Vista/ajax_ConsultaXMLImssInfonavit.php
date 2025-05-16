<?php
session_start();
require_once("../libs/logger/KLogger.php");
require "conexion.php";
//$log = new KLogger("ajax_ConsultaXMLImssInfonavit.log", KLogger::DEBUG);
$response          = array();
$response["status"]= "error";
$datos             = array();

$tipo = $_POST["tipoDoc"];
$anio = $_POST["anioDoc"];
$mes  = $_POST["mesDoc"];


try {
    if ($tipo=='1') {
        $nombreDocumento="XML_IMSS".$mes.$anio;

    $sql = "SELECT * 
            FROM xml_imss
            WHERE NombreArchivoXMLImss LIKE '%$nombreDocumento%'
            ORDER BY idArchivoXMLImss DESC
            LIMIT 1";      
    }else if ($tipo=='2'){

        $nombreDocumento="XML_INFONAVIT".$mes.$anio;
        $sql = "SELECT * 
            FROM xml_infonavit
            WHERE NombreArchivoXMLInfonavit LIKE '%$nombreDocumento%'
            ORDER BY idArchivoXMLInfonavit DESC
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
