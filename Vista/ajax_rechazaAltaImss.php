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
    // $log = new KLogger("ajaxRechazarAltaImss.log", KLogger::DEBUG);

    $usuario = $_SESSION["userLog"]["usuario"];

    $empleadoId            = getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
/*
    $entidadFederativaId   = substr($empleadoId, 0, 2);
    $empleadoConsecutivoId = substr($empleadoId, 3, 4);
    $empleadoCategoriaId   = substr($empleadoId, 8, 2);
*/
        $entidadFederativaId=$empleadoidd[0];
        $empleadoConsecutivoId=$empleadoidd[1];
        $empleadoCategoriaId=$empleadoidd[2];
    $datosImss = array(
        "empladoEntidadImss"      => $entidadFederativaId,
        "empleadoConsecutivoImss" => $empleadoConsecutivoId,
        "empleadoCategoriaImss"   => $empleadoCategoriaId,
        "empleadoEstatusImss"     => getValueFromPost("empleadoEstatusImss"),
        "folioTxt"                => getValueFromPost("folioTxt"),
    );

    // $log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));
    try
    {
        $negocio->rechazarEmpleadoImss($datosImss);

        $response["status"]  = "success";
        $response["message"] = "Empleado registrado éxitosamente";
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
