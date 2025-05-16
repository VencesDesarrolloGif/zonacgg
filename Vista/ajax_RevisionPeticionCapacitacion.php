<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_RevisionPeticionCapacitacion.log" , KLogger::DEBUG ); 
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$asistenciaFecha=$_POST["asistenciaFecha"];

try {
    $RevisionPeticionCap   = $negocio->ObtenerPeticionesCap($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha);
    $response["datos"] = $RevisionPeticionCap;
//$log->LogInfo("Valor de response" . var_export ($response, true));
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}

echo json_encode($response);
