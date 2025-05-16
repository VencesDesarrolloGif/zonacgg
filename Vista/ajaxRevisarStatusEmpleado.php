<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_PuntosServicioGeoParaRostro.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));
$numeroEmpleado=$_POST["numeroEmpleado"];
try {
    $EstatusEmpleadoGeo   = $negocio->ObtenerEstatusEmpeladoGeo($numeroEmpleado);
    // $log->LogInfo("Valor de EstatusEmpleadoGeo  " . var_export ($EstatusEmpleadoGeo, true));

    $response["datos"] = $EstatusEmpleadoGeo;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Los Dias Disponibles";
}

echo json_encode($response);
