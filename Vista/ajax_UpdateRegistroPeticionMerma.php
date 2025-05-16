<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_UpdateRegistroPeticionMerma.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$asistenciaFecha=$_POST["asistenciaFecha"];
$valordia=$_POST["valordia"];
$usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de idpuntoservicio" . var_export ($idpuntoservicio, true));

try {
   	$negocio->ActualizareRegistroPeticionMerma1($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$valordia,$usuario);
   // $response["datos"] = $RevisionPeticionM;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}

echo json_encode($response);
