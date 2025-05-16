<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_RevisionPeticionAsistenciaMerma.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$asistenciaFecha=$_POST["asistenciaFecha"];
//$log->LogInfo("Valor de idpuntoservicio" . var_export ($idpuntoservicio, true));

try {
    $RevisionPeticionM   = $negocio->ObtenerPeticionesM($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha);
    $response["datos"] = $RevisionPeticionM;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}

echo json_encode($response);
