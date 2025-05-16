<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php"; 
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getIdClientePorPunto.log" , KLogger::DEBUG );
$idpuntoservicio=$_POST["idpuntoservicio"];

try {
    $puestos   = $negocio->obtenerIdClientePorPunto($idpuntoservicio);
    
    $response["datos"] = $puestos;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}
//$log->LogInfo("Valor de response" . var_export ($response, true));

echo json_encode($response);
