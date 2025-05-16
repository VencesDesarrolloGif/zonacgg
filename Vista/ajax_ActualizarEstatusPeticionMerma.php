<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ActualizarEstatusPeticionMerma.log" , KLogger::DEBUG );
$EmpEntidadM = $_POST["EmpEntidadM"];
$EmpConsecutivoM = $_POST["EmpConsecutivoM"];
$EmpCategoriaM = $_POST["EmpCategoriaM"];
$idPuntoServicioM = $_POST["idPuntoServicioM"];
$idIncidenciaM = $_POST["idIncidenciaM"];
$FechaDelRegistro = $_POST["FechaDelRegistro"];
$Comentario = $_POST["Comentario"];
$Opcion = $_POST["Opcion"];
//$log->LogInfo("Valor de idpuntoservicio" . var_export ($idpuntoservicio, true));

try {
    $puestos   = $negocio->ActualizarEstatusPeticionMerma($EmpEntidadM,$EmpConsecutivoM,$EmpCategoriaM,$idPuntoServicioM,$idIncidenciaM,$FechaDelRegistro,$Comentario,$Opcion);
    $response["datos"] = $puestos;
    

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}

echo json_encode($response);
