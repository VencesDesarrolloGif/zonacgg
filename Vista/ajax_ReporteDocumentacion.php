<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("ajax_ReporteDocumentacion.log", KLogger::DEBUG);

$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
$FechaInicioDoc = $_POST["FechaInicioDoc"];
$FechaFinDoc = $_POST["FechaFinDoc"];
//$log->LogInfo("Valor de la variable $_POST: " . var_export ($_POST, true));
try {
    $datos = $negocio -> obtenerListaReportesDocumentos($FechaInicioDoc,$FechaFinDoc);        
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));                                                                      
    $response["status"] = "success"; 
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al Consultar Adeudos Empleados";}
echo json_encode($response);
