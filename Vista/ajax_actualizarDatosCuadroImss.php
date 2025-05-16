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
    // $log = new KLogger("ajaxActualizaDatosImssCuadro.log", KLogger::DEBUG);

    $empleadoId = getValueFromPost("numeroEmpleado");
    $monto      = getValueFromPost("salarioDiario");
    $punto      = strpos($monto, ".");
    //$log->LogInfo("Valor de la variable \$punto : " . var_export ($punto, true));

    if ($punto != 0) {
        $salarioDiario = $monto;

    } else {

        $salarioDiario = $monto . ".00";
    }

    $empleadoidd = explode("-", $empleadoId);
/*
            $empleadoEntidad     = substr($empleadoId, 0, 2);
            $empleadoConsecutivo = substr($empleadoId, 3, 4);
            $empleadoCategoria   = substr($empleadoId, 8, 2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];

    

    $datosImss = array(
        "empladoEntidadImss"      => $empleadoEntidad,
        "empleadoConsecutivoImss" => $empleadoConsecutivo,
        "empleadoCategoriaImss"   => $empleadoCategoria,
        "salarioDiario"           => $salarioDiario,
        "registroPatronal"        => getValueFromPost("registroPatronal"),
        "tipomovimiento"          => getValueFromPost("tipomovimiento"),
    );

    try
    {
        // $negocio -> negocio_registroDatosFamiliares($datosFamiliares);
        $negocio->negocio_actualizarDatosImssCuadro($datosImss);

        $response["status"]  = "success";
        $response["message"] = "Datos Imss registrados Exitosamente";
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
