<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio(); 
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_UpdatePeticionCapacitacion.log" , KLogger::DEBUG );
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
$asistenciaFecha=$_POST["asistenciaFecha"];
$EstatusCap=$_POST["EstatusCap"];
$usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de idpuntoservicio" . var_export ($idpuntoservicio, true));

try {
   	$negocio->ActualizarPeticionCapacitacion($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$EstatusCap,$usuario);
   // $response["datos"] = $RevisionPeticionM;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Fue Posible Actualizar Peticion De Capacitación";
}

echo json_encode($response);
