<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_SolicitarComplementoFiniquito.log" , KLogger::DEBUG );
$montoSolicitadoC=$_POST["montoSolicitadoC"];
$FolioFiniquito=$_POST["FolioFiniquito"];
$numEmpleadoComp=$_POST["numEmpleadoComp"];
//$log->LogInfo("Valor de _POST  " . var_export ($_POST, true));

try {
   $negocio->UpdateFiniquitoComplemento($montoSolicitadoC,$FolioFiniquito,$numEmpleadoComp);

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Es Posible Mandar La Solicitud De Complemento Para El Finiquito";
}

echo json_encode($response);
