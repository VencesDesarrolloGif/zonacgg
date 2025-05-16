<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ConfirmarComplementoPagado.log" , KLogger::DEBUG );
$numempleado=$_POST["numempleado"];
$folioBaja=$_POST["folioBaja"];
$CantidadComplemento=$_POST["CantidadComplemento"];
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));

try {
   $negocio->UpdateFiniquitoComplementoPagado($numempleado,$folioBaja,$CantidadComplemento);

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Es Posible Mandar La Solicitud De Complemento Para El Finiquito";
}

echo json_encode($response);
