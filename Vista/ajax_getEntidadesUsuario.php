<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$log = new KLogger ( "ajax_getEntidadesUsuario.log" , KLogger::DEBUG );
$response = array("status" => "success");
$entidadConsulta=$_SESSION ["userLog"]["entidadFederativaUsuario"];
    $log->LogInfo("Valor de _SESSION" . var_export ($_SESSION, true));
    $log->LogInfo("Valor de entidadConsulta" . var_export ($entidadConsulta, true));
try {
    $EntUser             = $negocio->negocio_GetEntidadesUser($entidadConsulta);
    $response["datos"] = $EntUser;
  //  $log->LogInfo("Valor de response" . var_export ($response, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Puedo Obtener Las Entidades Del Usuario";
}
echo json_encode($response);
