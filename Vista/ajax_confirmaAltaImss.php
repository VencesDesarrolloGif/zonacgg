<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
 
$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio);

if (!empty($_POST)) {
    //$log = new KLogger("ajaxConfirnaAltaImss.log", KLogger::DEBUG);

    $usuario = $_SESSION["userLog"]["usuario"];

    $datosImss = array(
        "numeroLote"          => getValueFromPost("numeroLote"),
        "empleadoEstatusImss" => getValueFromPost("empleadoEstatusImss"),
        "folioTxt"            => getValueFromPost("folioTxt"),
    );

    //$log->LogInfo("*********USUARIO CONFIRMACION ALTA IMSS: " . var_export ($usuario, true));

    //$log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));
    try
    {
        $negocio->confirmaAltaImss($datosImss);

        $response["status"]  = "success";
        $response["message"] = "Confirmación finalizada";
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
