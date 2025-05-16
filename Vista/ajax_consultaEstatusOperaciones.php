<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
//$log = new KLogger ( "ajax_consultaEstatusOperaciones.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de usuario" . var_export ($usuario, true));

try {
    $estatusOp   = $negocio->obtenerEstatusOperaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    $response["datos"] = $estatusOp;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}
echo json_encode($response);
