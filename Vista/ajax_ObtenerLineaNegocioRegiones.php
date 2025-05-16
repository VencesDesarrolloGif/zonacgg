<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
try {

    $LineaNegocio      = $negocio->negocio_obtenerListaLineaNegocio();
    $response["datos"] = $LineaNegocio;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response); 