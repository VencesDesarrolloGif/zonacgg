<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
try {

    $Cilindros             = $negocio->getCatalogCilindros();
    $response["datos"] = $Cilindros;

    //$log->LogInfo("Valor de entidad" . var_export ($idEntidad, true));
    //$log->LogInfo("Valor de response" . var_export ($response, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Puedo Obtener El Catalogo Los Cilindros Del Vehiculo";
}
echo json_encode($response);
