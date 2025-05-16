<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
try {
	$selLineaNegocioRegiones = $_POST["selLineaNegocioRegiones"];
	$selRegiones = $_POST["selRegiones"];

    $RegionesTotales = $negocio->ObtenerRegionesTotalesSelect($selLineaNegocioRegiones,$selRegiones);
    $response["datos"] = $RegionesTotales;

    //$log->LogInfo("Valor de entidad" . var_export ($idEntidad, true));
    //$log->LogInfo("Valor de response" . var_export ($response, true));

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response); 