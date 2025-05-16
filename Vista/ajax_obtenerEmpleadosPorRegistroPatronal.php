<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php"; 
$negocio = new Negocio();
verificarInicioSesion($negocio); 
// $log              = new KLogger("ajaxCunsultaEmpleadosPorRegistroPatronal.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));
$registroPatronal = getValueFromPost("registroPatronal");
$response = array("status" => "success");
try {
    $listaEmpleados             = $negocio->obtenerListaEmpleadosSinImssPorRegistroPatronal($registroPatronal);
    $response["listaEmpleados"] = $listaEmpleados;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener consulta";
}
echo json_encode($response);
