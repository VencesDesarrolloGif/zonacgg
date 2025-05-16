<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log               = new KLogger("ajax_ConfirmarSolicitudUniformes.log", KLogger::DEBUG);
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$idSolicitudUniforme= $_POST['idSolicitudUniforme'];
//$log->LogInfo("Valor de la variable idSolicitudUniforme: " . var_export ($idSolicitudUniforme, true));     
try {
    $negocio -> ConfirmarManualmenteSolicitud($idSolicitudUniforme);
    $response["status"] = "success";

} catch (Exception $e) {
    $response["mensaje"] = "Error al actualizar";}
echo json_encode($response);
