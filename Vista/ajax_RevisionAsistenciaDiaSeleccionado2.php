<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_RevisionAsistenciaDiaSeleccionado2.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de FechaUno  " . var_export ($FechaUno, true));
$DateVacaciones=$_POST["DateVacaciones"];
$empleadoEntidadId=$_POST["empleadoEntidadId"];
$empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
$empleadoTipoId=$_POST["empleadoTipoId"];
   // $log->LogInfo("Valor de _POST  " . var_export ($_POST, true));

try {

    $RevisionFechaInsertada1   = $negocio->ObtenerRevisionFechaInsertada($DateVacaciones,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);//Dias De Vacaciones Tomadas
    $RevisionFechaInsertada = $RevisionFechaInsertada1[0]["RegistroAsistencia"];
   // $log->LogInfo("Valor de RevisionFechaInsertada1  " . var_export ($RevisionFechaInsertada1, true));
    
    $response["datos"] = $RevisionFechaInsertada;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Fue Posible Realizar La Revisión De La Asistencia";
}

echo json_encode($response);
